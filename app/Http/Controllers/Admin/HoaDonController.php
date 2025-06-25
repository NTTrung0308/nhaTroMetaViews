<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DienNuocTheoPhong;
use App\Models\HoaDon;
use App\Models\HopDongThuePhong;
use App\Models\NhaTros;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Thêm Log để ghi lỗi

class HoaDonController extends Controller
{
  /**
     * Hiển thị danh sách hóa đơn.
     */
    public function index(Request $request)
{
    // 1. Bắt đầu với câu truy vấn cơ sở
    $query = HoaDon::query()->with(['room.nhaTro', 'user']);

    // 2. Áp dụng các bộ lọc nếu có
    if ($request->filled('nha_tro_id')) {
        // Lọc theo Nhà trọ
        $query->where('nha_tro_id', $request->nha_tro_id);
    }
    
    if ($request->filled('room_id')) {
        // Lọc theo Phòng
        $query->where('room_id', $request->room_id);
    }

    if ($request->filled('thang')) {
        // Lọc theo Tháng
        $query->where('thang', $request->thang);
    }

    if ($request->filled('nam')) {
        // Lọc theo Năm
        $query->where('nam', $request->nam);
    }

    if ($request->filled('trang_thai')) {
        // Lọc theo Trạng thái hóa đơn
        $query->where('trang_thai', $request->trang_thai);
    }

    // 3. Lấy dữ liệu đã lọc, sắp xếp và phân trang
    // withQueryString() sẽ tự động thêm các tham số lọc vào link phân trang
    $hoaDons = $query->latest()->paginate(15);

    // 4. Lấy dữ liệu cho các dropdown của bộ lọc
    $nhaTros = NhaTros::all();
    $statuses = [
        'chua_thanh_toan' => 'Chưa thanh toán',
        'da_thanh_toan' => 'Đã thanh toán',
        'qua_han' => 'Quá hạn',
        'da_huy' => 'Đã hủy',
    ];

    // 5. Trả về view cùng với dữ liệu
    return view('admin.hoa-dons.index', compact('hoaDons', 'nhaTros', 'statuses'));
}
    /**
     * Hiển thị form để chọn tháng/năm tạo hóa đơn hàng loạt.
     */
    public function showGenerateForm()
    {
        return view('admin.hoa-dons.generate-form');
    }

    /**
     * Xử lý tạo hóa đơn hàng loạt.
     */ public function generateInvoices(Request $request)
    {
        $validated = $request->validate([
            'thang' => 'required|integer|between:1,12',
            'nam' => 'required|integer|min:2020',
        ]);

        $thang = $validated['thang'];
        $nam = $validated['nam'];
        $countSuccess = 0;
        $countSkipped = 0;
        $errors = [];

        $rentedRooms = Rooms::where('da_thue', true)->with(['hopDongHienTai.user', 'nhaTro.dichVus'])->get();
        $roomIds = $rentedRooms->pluck('id')->unique();
        $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();
        
        // SỬA Ở ĐÂY: Thêm điều kiện 'trang_thai_chot' = true
        $dienNuocMap = DienNuocTheoPhong::whereIn('room_id', $roomIds)
            ->where('thang', $thang)
            ->where('nam', $nam)
            ->where('trang_thai_chot', true) // <-- QUAN TRỌNG
            ->get()->keyBy('room_id');
            
        $existingInvoicesMap = HoaDon::whereIn('room_id', $roomIds)->where('thang', $thang)->where('nam', $nam)->pluck('id', 'room_id');
        $noKyTruocMap = HoaDon::whereIn('room_id', $roomIds)->where('thang', $ngayKyTruoc->month)->where('nam', $ngayKyTruoc->year)->get()->keyBy('room_id');

        DB::beginTransaction();
        try {
            foreach ($rentedRooms as $room) {
                $hopDong = $room->hopDongHienTai;
                if (!$hopDong) {
                    $errors[] = "Phòng {$room->ten_phong}: Trạng thái đã thuê nhưng không tìm thấy hợp đồng hoạt động.";
                    $countSkipped++; continue;
                }
                if ($existingInvoicesMap->has($room->id)) {
                    $errors[] = "Phòng {$room->ten_phong}: Hóa đơn đã tồn tại.";
                    $countSkipped++; continue;
                }

                // SỬA Ở ĐÂY: Kiểm tra bản ghi điện nước đã chốt
                $dienNuoc = $dienNuocMap->get($room->id);
                if (!$dienNuoc) {
                    // Thông báo lỗi cụ thể hơn
                    $errors[] = "Phòng {$room->ten_phong}: Chưa chốt số điện nước.";
                    $countSkipped++; continue;
                }
                
                $invoiceDetails = $this->calculateInvoiceDetails($hopDong, $dienNuoc);
                $noKyTruoc = $noKyTruocMap->get($room->id)?->con_no ?? 0;
                $tongTien = $hopDong->gia_thue + $invoiceDetails['tong_chi_phi_dich_vu'];

                HoaDon::create(array_merge(
                    ['ma_hoa_don' => 'HD-'.$room->id.'-'.str_pad($thang,2,'0',STR_PAD_LEFT).$nam, 'nha_tro_id' => $room->nha_tro_id, 'room_id' => $room->id, 'user_id' => $hopDong->user_id, 'hop_dong_thue_phong_id' => $hopDong->id, 'thang' => $thang, 'nam' => $nam, 'ngay_tao_hoa_don' => now(), 'han_thanh_toan' => now()->addDays(10), 'tien_thue_phong' => $hopDong->gia_thue, 'tong_tien' => $tongTien, 'no_ky_truoc' => $noKyTruoc],
                    $invoiceDetails
                ));
                $countSuccess++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi tạo hóa đơn hàng loạt: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('hoa-dons.index')->with('error', 'Đã xảy ra lỗi nghiêm trọng khi tạo hóa đơn.');
        }

        $message = "Tạo hóa đơn hoàn tất! Thành công: $countSuccess. Bỏ qua: $countSkipped.";
        if (!empty($errors)) { session()->flash('generation_errors', $errors); }
        return redirect()->route('hoa-dons.index')->with('success', $message);
    }

    /**
     * ========================================================================
     * HÀM TẠO HÓA ĐƠN THỦ CÔNG (ĐÃ NÂNG CẤP)
     * ========================================================================
     */
    public function taoHoaDonChoHopDong(Request $request, HopDongThuePhong $hopDong)
    {
        // 1. Validation chỉ cần tháng và năm
        $validated = $request->validate([
            'thang' => 'required|integer|between:1,12',
            'nam' => 'required|integer|min:2020',
        ]);
        $thang = $validated['thang'];
        $nam = $validated['nam'];
        $room = $hopDong->room;

        // 2. Kiểm tra hóa đơn đã tồn tại chưa
        if (HoaDon::where('room_id', $room->id)->where('thang', $thang)->where('nam', $nam)->exists()) {
            return redirect()->back()->with('error', "Hóa đơn cho phòng {$room->ten_phong} tháng {$thang}/{$nam} đã tồn tại!");
        }

        // 3. QUAN TRỌNG: Kiểm tra bản ghi điện nước đã được CHỐT chưa
        $dienNuoc = DienNuocTheoPhong::where('room_id', $room->id)
                                    ->where('thang', $thang)
                                    ->where('nam', $nam)
                                    ->where('trang_thai_chot', true)
                                    ->first();

        // Nếu chưa chốt, chuyển hướng người dùng đến trang chốt điện nước
        if (!$dienNuoc) {
            return redirect()->route('dien-nuoc.create', ['room_id' => $room->id, 'thang' => $thang, 'nam' => $nam])
                             ->with('warning', "Vui lòng chốt số điện nước cho phòng {$room->ten_phong} tháng {$thang}/{$nam} trước khi tạo hóa đơn.");
        }

        // 4. Nếu đã chốt, tiến hành tạo hóa đơn
        DB::beginTransaction();
        try {
            $invoiceDetails = $this->calculateInvoiceDetails($hopDong, $dienNuoc);
            $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();
            $noKyTruoc = HoaDon::where('room_id', $room->id)->where('thang', $ngayKyTruoc->month)->where('nam', $ngayKyTruoc->year)->first()?->con_no ?? 0;
            $tongTien = $hopDong->gia_thue + $invoiceDetails['tong_chi_phi_dich_vu'];

            $hoaDonMoi = HoaDon::create(array_merge(
                ['ma_hoa_don' => 'HD-'.$room->id.'-'.str_pad($thang,2,'0',STR_PAD_LEFT).$nam, 'nha_tro_id' => $hopDong->nha_tro_id, 'room_id' => $room->id, 'user_id' => $hopDong->user_id, 'hop_dong_thue_phong_id' => $hopDong->id, 'thang' => $thang, 'nam' => $nam, 'ngay_tao_hoa_don' => now(), 'han_thanh_toan' => now()->addDays(10), 'tien_thue_phong' => $hopDong->gia_thue, 'tong_tien' => $tongTien, 'no_ky_truoc' => $noKyTruoc,],
                $invoiceDetails
            ));
            DB::commit();
            return redirect()->route('hoa-dons.show', $hoaDonMoi->id)->with('success', "Đã tạo thành công hóa đơn cho phòng {$room->ten_phong} tháng {$thang}/{$nam}.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi tạo hóa đơn thủ công: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Phương thức private để tính toán chi tiết hóa đơn.
     */
     private function calculateInvoiceDetails(HopDongThuePhong $hopDong, DienNuocTheoPhong $dienNuocData): array
    {
        $tienDien = 0; $tienNuoc = 0; $tongPhuPhi = 0; $chiTietDichVuKhac = [];
        $dichVusCuaNhaTro = $hopDong->nhaTro->dichVus;

        foreach ($dichVusCuaNhaTro as $dichVu) {
            $donGia = $dichVu->pivot->don_gia;
            $kieuTinh = $dichVu->pivot->kieu_tinh;
            $maDichVu = $dichVu->ma_dich_vu; // Lấy mã dịch vụ để nhận dạng
            $thanhTien = 0;
            
            switch ($kieuTinh) {
                case 'cong_to':
                    if ($maDichVu === 'dien_sinh_hoat') { $thanhTien = $dienNuocData->dien_tieu_thu * $donGia; } 
                    elseif ($maDichVu === 'nuoc') { $thanhTien = $dienNuocData->nuoc_tieu_thu * $donGia; }
                    break;
                case 'dau_nguoi':
                    $thanhTien = $dienNuocData->so_nguoi * $donGia; break;
                case 'co_dinh':
                    $thanhTien = $donGia; break;
            }

            if ($maDichVu === 'dien_sinh_hoat') {
                $tienDien = $thanhTien;
            } elseif ($maDichVu === 'nuoc') {
                $tienNuoc = $thanhTien;
            } else {
                $tongPhuPhi += $thanhTien;
                $chiTietDichVuKhac[] = ['ten_dich_vu' => $dichVu->ten_dich_vu, 'don_gia' => $donGia, 'so_luong' => ($kieuTinh == 'dau_nguoi') ? $dienNuocData->so_nguoi : 1, 'kieu_tinh' => $kieuTinh, 'thanh_tien' => $thanhTien];
            }
        }
        return [
            'tien_dien' => $tienDien, 'tien_nuoc' => $tienNuoc, 'tong_phu_phi' => $tongPhuPhi, 'chi_tiet_dich_vu_khac' => $chiTietDichVuKhac, 'tong_chi_phi_dich_vu' => $tienDien + $tienNuoc + $tongPhuPhi,
        ];
    }


    /**
     * Hiển thị chi tiết hóa đơn.
     */
    public function show(HoaDon $hoaDon)
    {
        $hoaDon->load(['room.nhaTro', 'user', 'hopDong']);
        return view('admin.hoa-dons.show', compact('hoaDon'));
    }

    /**
     * Hiển thị form để cập nhật trạng thái thanh toán.
     */
    public function edit(HoaDon $hoaDon)
    {
        return view('admin.hoa-dons.edit', compact('hoaDon'));
    }

    /**
     * Cập nhật trạng thái thanh toán.
     */
    public function update(Request $request, HoaDon $hoaDon)
    {
        $validated = $request->validate([
            'da_thanh_toan' => 'required|numeric|min:0',
            'trang_thai' => 'required|in:chua_thanh_toan,da_thanh_toan,qua_han,da_huy',
            'ghi_chu' => 'nullable|string',
        ]);

        $hoaDon->update($validated);
        return redirect()->route('hoa-dons.show', $hoaDon)->with('success', 'Cập nhật thanh toán thành công!');
    }

    /**
     * Xóa một hóa đơn.
     */
    public function destroy(HoaDon $hoaDon)
    {
        $hoaDon->delete();
        return redirect()->route('hoa-dons.index')->with('success', 'Đã xóa hóa đơn.');
    }
}