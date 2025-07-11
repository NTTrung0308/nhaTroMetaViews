<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class VnpayController extends Controller
{
    public function createPayment(Request $request, HoaDon $hoaDon)
    {
        if ($hoaDon->con_no <= 0) {
            return redirect()->back()->with('error', 'Hóa đơn này không có nợ hoặc đã được thanh toán.');
        }

        $transaction = Transaction::create([
            'transaction_code' => 'TXN' . time() . $hoaDon->id,
            'hoa_don_id'       => $hoaDon->id,
            'user_id'          => Auth::id(),
            'amount'           => $hoaDon->con_no,
            'description'      => "Thanh toan hoa don " . $hoaDon->ma_hoa_don,
            'gateway'          => 'vnpay',
            'status'           => 'pending',
        ]);

        $vnpayUrl = $this->generateVnpayUrl($transaction);
        return redirect()->away($vnpayUrl); // Sử dụng redirect()->away() cho URL bên ngoài
    }

   
    public function handleReturn(Request $request)
    {
       $vnp_HashSecret = env('VNPAY_HASH_SECRET', '9ZBCAYZF5J4TUYO0D4MNG096UKS6924A');
        $inputData = $request->all();

        // Tìm giao dịch trong DB
        $transaction = Transaction::where('transaction_code', $inputData['vnp_TxnRef'])->first();
        $redirectRoute = redirect()->route('hoa-dons.show', ['hoaDon' => optional($transaction)->hoa_don_id]);

        // 1. Kiểm tra xem giao dịch có tồn tại không
        if (!$transaction) {
            return $redirectRoute->with('error', 'Giao dịch không hợp lệ hoặc không tồn tại.');
        }

        // 2. KIỂM TRA CHỮ KÝ BẢO MẬT (Rất quan trọng để chống giả mạo)
        if (!$this->isSignatureValid($inputData, $vnp_HashSecret)) {
             return $redirectRoute->with('error', 'Chữ ký không hợp lệ. Giao dịch không được xác thực.');
        }
        
        // 3. Kiểm tra kết quả thanh toán từ VNPay
        if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
            
            // 4. KIỂM TRA TRẠNG THÁI GIAO DỊCH (Tránh cập nhật 2 lần)
            if ($transaction->status === 'pending') {
                // Cập nhật trạng thái giao dịch
                $transaction->status = 'completed';
                $transaction->gateway_transaction_code = $inputData['vnp_TransactionNo'];
                $transaction->metadata = $inputData;
                $transaction->completed_at = now();
                $transaction->save();
                
                // Cập nhật hóa đơn
                $this->updateHoaDonAfterPayment($transaction);

                return $redirectRoute->with('success', 'Giao dịch đã được xác nhận và thanh toán thành công!');
            }
            // Nếu trạng thái đã là 'completed' thì chỉ thông báo thành công, không cập nhật nữa
            elseif ($transaction->status === 'completed') {
                return $redirectRoute->with('success', 'Giao dịch đã được xác nhận thành công trước đó.');
            }

        }

        // Nếu giao dịch thất bại hoặc bị hủy
        $transaction->status = 'failed';
        $transaction->metadata = $inputData;
        $transaction->save();
        return $redirectRoute->with('error', 'Giao dịch không thành công. Vui lòng thử lại.');
    }

    // --- CÁC HÀM HỖ TRỢ ---
 public static function generateOrderCode($length = 8)
    {
        return 'ORD' . Str::random($length);
    }
    private function generateVnpayUrl(Transaction $transaction): string
    {
        $vnp_TmnCode = '4Q2DE5BY';
        $vnp_HashSecret = '9ZBCAYZF5J4TUYO0D4MNG096UKS6924A';
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';

 
        $vnp_OrderType = "education";
        $vnp_Amount =  $transaction->amount * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan HD " . $transaction->transaction_code,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('payment.vnpay.return'),
            "vnp_TxnRef" =>$transaction->transaction_code,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);

        $hashdata = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url_full = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;

        return $vnp_Url_full;
    }

    private function isSignatureValid(array $inputData, string $hashSecret): bool
    {
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType'], $inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $hashSecret);
        return $secureHash === $vnp_SecureHash;
    }

    private function updateHoaDonAfterPayment(Transaction $transaction): void
    {
        
        $hoaDon = $transaction->hoaDon;
        if (!$hoaDon) return; // Kiểm tra nếu không tìm thấy hóa đơn

        $hoaDon->da_thanh_toan += $transaction->amount;
       
            $hoaDon->trang_thai = 'da_thanh_toan';
      

        $hoaDon->ghi_chu = ($hoaDon->ghi_chu ? $hoaDon->ghi_chu . "\n" : "") .
            "Thanh toan VNPay luc " . now()->format('d/m/Y H:i:s') .
            ", ma GD: " . $transaction->gateway_transaction_code;

        $hoaDon->save();
    }
}
