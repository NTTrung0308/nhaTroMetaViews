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
        $user = auth()->user();

        // 1. Bắt đầu với câu truy vấn cơ sở
        $query = HoaDon::query()->with(['room.nhaTro', 'user']);

        // Dữ liệu cho các dropdown của bộ lọc
        $nhaTros = collect();
        $userRooms = collect(); // Danh sách phòng của người thuê

        // 2. Áp dụng các điều kiện truy vấn dựa trên vai trò
        if ($user->can('nguoi-thue-tro')) {
            // Người thuê trọ chỉ xem được hóa đơn của mình
            $query->where('user_id', $user->id);

            // Lấy danh sách các phòng mà người này đã/đang thuê
            // Cách 1: Dựa trên các hóa đơn đã có
            $roomIds = HoaDon::where('user_id', $user->id)->pluck('room_id')->unique();
            $userRooms = Rooms::whereIn('id', $roomIds)->get();

            // Cách 2 (Tốt hơn): Nếu bạn có bảng hợp đồng (ví dụ: hop_dongs)
            // $userRooms = Room::whereHas('hopDongs', function ($q) use ($user) {
            //     $q->where('user_id', $user->id);
            // })->get();

        } else {
            // Admin/Quản lý có thể lọc theo nhà trọ
            if ($request->filled('nha_tro_id')) {
                // Sửa đổi để lọc hóa đơn qua mối quan hệ với phòng
                $query->whereHas('room', function ($q) use ($request) {
                    $q->where('nha_tro_id', $request->nha_tro_id);
                });
            }
            // Lấy danh sách nhà trọ cho bộ lọc
            $nhaTros = NhaTros::all();
        }

        // 3. Áp dụng các bộ lọc chung cho cả hai vai trò
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('thang')) {
            $query->where('thang', $request->thang);
        }

        if ($request->filled('nam')) {
            $query->where('nam', $request->nam);
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // 4. Lấy dữ liệu đã lọc, sắp xếp và phân trang
        $hoaDons = $query->latest()->paginate(15);

        // 5. Chuẩn bị dữ liệu trạng thái
        $statuses = [
            'chua_thanh_toan' => 'Chưa thanh toán',
            'da_thanh_toan' => 'Đã thanh toán',
            'qua_han' => 'Quá hạn',
            'da_huy' => 'Đã hủy',
        ];

        // 6. Trả về view
        return view('admin.hoa-dons.index', compact('hoaDons', 'nhaTros', 'userRooms', 'statuses'));
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
     */
    // Trong file app/Http/Controllers/Admin/HoaDonController.php

    public function generateInvoices(Request $request)
    {
        $validated = $request->validate([
            'thang' => 'required|integer|between:1,12',
            'nam' => 'required|integer|min:2020',
        ]);

        $thang = $validated['thang'];
        $nam = $validated['nam'];
        $countSuccess = 0;
        $countSkipped = 0;
        $errorsByRoom = [];

        // Lưu ý: Nên đổi tên model Rooms thành Room cho đúng chuẩn Laravel
        $rentedRooms = Rooms::where('da_thue', true)->with(['hopDongHienTai.user', 'nhaTro.dichVus'])->get();
        $roomIds = $rentedRooms->pluck('id')->unique();
        $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();

        $dienNuocMap = DienNuocTheoPhong::whereIn('room_id', $roomIds)
            ->where('thang', $thang)->where('nam', $nam)
            ->where('trang_thai_chot', true)
            ->get()->keyBy('room_id');

        $existingInvoicesMap = HoaDon::whereIn('room_id', $roomIds)->where('thang', $thang)->where('nam', $nam)->pluck('id', 'room_id');
        $noKyTruocMap = HoaDon::whereIn('room_id', $roomIds)->where('thang', $ngayKyTruoc->month)->where('nam', $ngayKyTruoc->year)->get()->keyBy('room_id');

        DB::beginTransaction();
        try {
            foreach ($rentedRooms as $room) {
                // Lấy tên phòng kèm tên tòa nhà để phân biệt rõ hơn
                $tenPhongDayDu = $room->ten_phong . ' (' . $room->nhaTro->ten_toa_nha . ')';

                $hopDong = $room->hopDongHienTai;
                if (!$hopDong) {
                    $errorsByRoom[$tenPhongDayDu] = "Trạng thái đã thuê nhưng không tìm thấy hợp đồng hoạt động.";
                    $countSkipped++;
                    continue;
                }

                if ($existingInvoicesMap->has($room->id)) {
                    $errorsByRoom[$tenPhongDayDu] = "Hóa đơn cho kỳ này đã tồn tại.";
                    $countSkipped++;
                    continue;
                }

                $dienNuoc = $dienNuocMap->get($room->id);
                if (!$dienNuoc) {
                    $errorsByRoom[$tenPhongDayDu] = "Chưa chốt số điện nước cho kỳ này.";
                    $countSkipped++;
                    continue;
                }

                $invoiceDetails = $this->calculateInvoiceDetails($hopDong, $dienNuoc);
                $noKyTruoc = $noKyTruocMap->get($room->id)?->con_no ?? 0;
                $tongTien = $hopDong->gia_thue + $invoiceDetails['tong_chi_phi_dich_vu'];

                HoaDon::create(array_merge(
                    ['ma_hoa_don' => 'HD-' . $room->id . '-' . str_pad($thang, 2, '0', STR_PAD_LEFT) . $nam, 'nha_tro_id' => $room->nha_tro_id, 'room_id' => $room->id, 'user_id' => $hopDong->user_id, 'hop_dong_thue_phong_id' => $hopDong->id, 'thang' => $thang, 'nam' => $nam, 'ngay_tao_hoa_don' => now(), 'han_thanh_toan' => now()->addDays(10), 'tien_thue_phong' => $hopDong->gia_thue, 'tong_tien' => $tongTien, 'no_ky_truoc' => $noKyTruoc],
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

        // XÂY DỰNG THÔNG BÁO VÀ CHUYỂN HƯỚNG

        // 1. Chuẩn bị thông báo thành công chung
         $status = [
            'message' => "Tạo hóa đơn hoàn tất cho tháng {$thang}/{$nam}!",
            'success_count' => $countSuccess,
            'skipped_count' => $countSkipped,
            'errors' => $errorsByRoom // Đây là mảng lỗi chi tiết
        ];

        // 2. Chuyển hướng và đính kèm mảng trạng thái này vào session
        return redirect()->route('hoa-dons.index')->with('generation_status', $status);

        // 4. Nếu có lỗi, đính kèm thêm cả danh sách lỗi chi tiết
        if (!empty($errorsByRoom)) {
            $redirectResponse->with('generation_errors_detailed', $errorsByRoom);
        }

        // 5. Trả về redirect response đã được xây dựng
        return $redirectResponse;
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
                ['ma_hoa_don' => 'HD-' . $room->id . '-' . str_pad($thang, 2, '0', STR_PAD_LEFT) . $nam, 'nha_tro_id' => $hopDong->nha_tro_id, 'room_id' => $room->id, 'user_id' => $hopDong->user_id, 'hop_dong_thue_phong_id' => $hopDong->id, 'thang' => $thang, 'nam' => $nam, 'ngay_tao_hoa_don' => now(), 'han_thanh_toan' => now()->addDays(10), 'tien_thue_phong' => $hopDong->gia_thue, 'tong_tien' => $tongTien, 'no_ky_truoc' => $noKyTruoc,],
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
        $tienDien = 0;
        $tienNuoc = 0;
        $tongPhuPhi = 0;
        $chiTietDichVuKhac = [];
        $dichVusCuaNhaTro = $hopDong->nhaTro->dichVus;

        foreach ($dichVusCuaNhaTro as $dichVu) {
            $donGia = $dichVu->pivot->don_gia;
            $kieuTinh = $dichVu->pivot->kieu_tinh;
            $maDichVu = $dichVu->ma_dich_vu; // Lấy mã dịch vụ để nhận dạng
            $thanhTien = 0;

            switch ($kieuTinh) {
                case 'cong_to':
                    if ($maDichVu === 'dien_sinh_hoat') {
                        $thanhTien = $dienNuocData->dien_tieu_thu * $donGia;
                    } elseif ($maDichVu === 'nuoc') {
                        $thanhTien = $dienNuocData->nuoc_tieu_thu * $donGia;
                    }
                    break;
                case 'dau_nguoi':
                    $thanhTien = $dienNuocData->so_nguoi * $donGia;
                    break;
                case 'co_dinh':
                    $thanhTien = $donGia;
                    break;
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
            'tien_dien' => $tienDien,
            'tien_nuoc' => $tienNuoc,
            'tong_phu_phi' => $tongPhuPhi,
            'chi_tiet_dich_vu_khac' => $chiTietDichVuKhac,
            'tong_chi_phi_dich_vu' => $tienDien + $tienNuoc + $tongPhuPhi,
        ];
    }


    /**
     * Hiển thị chi tiết hóa đơn.
     */
    public function show(HoaDon $hoaDon)
    {
        $hoaDon->load(['room.nhaTro.dichVus', 'user', 'hopDong']);
      $dichVuDien = null;
    $dichVuNuoc = null;

    // Sử dụng optional chaining (?->) để tránh lỗi nếu room hoặc nhaTro không tồn tại
    if ($services = $hoaDon->room?->nhaTro?->dichVus) {
        // Tìm dịch vụ điện và nước dựa trên tên hoặc một slug/id cố định.
        // !!! QUAN TRỌNG: Bạn cần thay 'Điện' và 'Nước' bằng tên chính xác trong bảng 'dich_vus' của bạn.
        $dichVuDien = $services->firstWhere('ma_dich_vu', 'dien_sinh_hoat'); // Hoặc 'Điện sinh hoạt'
        $dichVuNuoc = $services->firstWhere('ma_dich_vu', 'nuoc'); // Hoặc 'Nước sinh hoạt'
    }

    return view('admin.hoa-dons.show', compact('hoaDon', 'dichVuDien', 'dichVuNuoc'));
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
