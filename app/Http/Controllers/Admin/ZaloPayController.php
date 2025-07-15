<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZaloPayController extends Controller
{
    protected $app_id;
    protected $key1;
    protected $key2;
    protected $endpoint;

    /**
     * Lấy cấu hình từ file config/services.php.
     * Đây là cách làm an toàn và linh hoạt hơn hardcode.
     */
    public function __construct()
    {
        $this->app_id   = config('services.zalopay.app_id', '2554');
        $this->key1     = config('services.zalopay.key1', 'sdngKKJmqEMzvh5QQcdD2A9XBSKUNaYn');
        $this->key2     = config('services.zalopay.key2', 'trMrHtvjo6myautxDUiAcYsVtaeQ8nhf');
        $this->endpoint = config('services.zalopay.endpoint', 'https://sb-openapi.zalopay.vn/v2/create');
    }

    /**
     * BƯỚC 1: TẠO YÊU CẦU THANH TOÁN
     * Được gọi khi người dùng nhấn nút "Thanh toán ZaloPay".
     */
    public function createPayment(Request $request, HoaDon $hoaDon)
    {


     $config = [
  "app_id" => 2554,
  "key1" => "sdngKKJmqEMzvh5QQcdD2A9XBSKUNaYn",
  "key2" => "kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz",
  "refund_url" => "https://sb-openapi.zalopay.vn/v2/refund"
];

$timestamp = round(microtime(true) * 1000); // miliseconds
$uid = "$timestamp".rand(111,999); // unique id 

$params = [
  "app_id" => $config["app_id"],
  "m_refund_id" => date("ymd")."_".$config["app_id"]."_".$uid,
  "timestamp" => $timestamp,
  "zp_trans_id" => 123456789,
  "amount" => 50000,
  "description" => "ZaloPay Intergration Demo"
];

// app_id|zp_trans_id|amount|description|timestamp
$data = $params["app_id"]."|".$params["zp_trans_id"]."|".$params["amount"]
  ."|".$params["description"]."|".$params["timestamp"];
$params["mac"] = hash_hmac("sha256", $data, $config["key1"]);

$context = stream_context_create([
  "http" => [
    "header" => "Content-type: application/x-www-form-urlencoded\r\n",
    "method" => "POST",
    "content" => http_build_query($params)
  ]
]);

$resp = file_get_contents($config["refund_url"], false, $context);
$result = json_decode($resp, true);
dd($result);

        
    }
    /**
     * BƯỚC 2: XỬ LÝ CALLBACK TỪ ZALOPAY SERVER
     * ZaloPay sẽ tự động gọi đến URL này sau khi người dùng thanh toán.
     */
    public function handleCallback(Request $request)
    {
        $result = [];

        try {
            $callback_data = json_decode($request->getContent(), true);
            $mac = hash_hmac('sha256', $callback_data['data'], $this->key2);

            if ($mac !== $callback_data['mac']) {
                $result['return_code'] = -1;
                $result['return_message'] = 'mac not equal';
                Log::warning('ZaloPay Callback: MAC signature mismatch.', $callback_data);
            } else {
                $order_data = json_decode($callback_data['data'], true);
                $transaction = Transaction::where('transaction_code', $order_data['app_trans_id'])->first();

                if ($transaction && $transaction->status === 'pending') {
                    $transaction->status = 'completed';
                    $transaction->gateway_transaction_code = $order_data['zp_trans_id'];
                    $transaction->metadata = $order_data;
                    $transaction->completed_at = now();
                    $transaction->save();

                    $this->updateHoaDonAfterPayment($transaction);
                }

                $result['return_code'] = 1;
                $result['return_message'] = 'success';
            }
        } catch (\Exception $e) {
            Log::error('ZaloPay Callback Exception', ['exception' => $e->getMessage(), 'request' => $request->all()]);
            $result['return_code'] = 0;
            $result['return_message'] = 'exception';
        }

        return response()->json($result);
    }

    protected function createTransaction(HoaDon $hoaDon, string $gateway): Transaction
    {
        return Transaction::create([
            'transaction_code' => 'TEMP_' . time(),
            'hoa_don_id'       => $hoaDon->id,
            'user_id'          => $hoaDon->user_id,
            'amount'           => $hoaDon->con_no,
            'description'      => "Thanh toán hóa đơn " . $hoaDon->ma_hoa_don,
            'gateway'          => $gateway,
            'status'           => 'pending',
        ]);
    }

    protected function updateHoaDonAfterPayment(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction) {
            $hoaDon = HoaDon::where('id', $transaction->hoa_don_id)->lockForUpdate()->first();

            if (!$hoaDon) return;

            if ($hoaDon->trang_thai !== 'da_thanh_toan') {
                $hoaDon->da_thanh_toan += $transaction->amount;

                $conNoMoi = $hoaDon->tong_tien - $hoaDon->da_thanh_toan;
                if ($conNoMoi <= 0) {
                    $hoaDon->trang_thai = 'da_thanh_toan';
                }

                $hoaDon->ghi_chu = ($hoaDon->ghi_chu ? $hoaDon->ghi_chu . "\n" : "") .
                    "Thanh toán " . strtoupper($transaction->gateway) . " lúc " . now()->format('d/m/Y H:i:s') .
                    ", số tiền: " . number_format($transaction->amount) . " VND" .
                    ", mã GD cổng: " . $transaction->gateway_transaction_code;

                $hoaDon->save();
            }
        });
    }
}
