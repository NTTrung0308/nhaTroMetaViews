<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DienNuocTheoPhong;
use App\Models\HoaDon;
use App\Models\HopDongThuePhong;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Thêm Log để ghi lỗi

class HoaDonController extends Controller
{
    /**
     * Hiển thị danh sách hóa đơn.
     */
    public function index()
    {
        $hoaDons = HoaDon::with(['room', 'user'])
            ->latest()
            ->paginate(15);
        return view('admin.hoa-dons.index', compact('hoaDons'));
    }

    /**
     * Hiển thị form để chọn tháng/năm tạo hóa đơn hàng loạt.
     */
    public function showGenerateForm()
    {
        return view('admin.hoa-dons.generate-form');
    }

    /**
     * Xử lý tạo hóa đơn hàng loạt cho tất cả các hợp đồng đang hoạt động.
     */
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
        $errors = [];

        // 1. Tối ưu truy vấn: Lấy tất cả dữ liệu cần thiết trước vòng lặp
        $activeContracts = HopDongThuePhong::where('active', true)
            ->with(['room', 'nhaTro.dichVus']) // Eager load các dịch vụ của nhà trọ
            ->get();

        $roomIds = $activeContracts->pluck('room_id')->unique();
        $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();

        // Dùng keyBy() để truy cập nhanh O(1) trong vòng lặp
        $dienNuocMap = DienNuocTheoPhong::whereIn('room_id', $roomIds)
            ->where('thang', $thang)->where('nam', $nam)->get()->keyBy('room_id');
        $existingInvoicesMap = HoaDon::whereIn('room_id', $roomIds)
            ->where('thang', $thang)->where('nam', $nam)->pluck('id', 'room_id');
        $noKyTruocMap = HoaDon::whereIn('room_id', $roomIds)
            ->where('thang', $ngayKyTruoc->month)->where('nam', $ngayKyTruoc->year)->get()->keyBy('room_id');


        DB::beginTransaction();
        try {
            foreach ($activeContracts as $hopDong) {
                // Kiểm tra nhanh xem hóa đơn đã tồn tại hoặc thiếu dữ liệu điện nước chưa
                if ($existingInvoicesMap->has($hopDong->room_id)) {
                    $errors[] = "Phòng {$hopDong->room->ten_phong}: Hóa đơn đã tồn tại.";
                    $countSkipped++;
                    continue;
                }

                $dienNuoc = $dienNuocMap->get($hopDong->room_id);
                if (!$dienNuoc) {
                    $errors[] = "Phòng {$hopDong->room->ten_phong}: Thiếu dữ liệu điện nước.";
                    $countSkipped++;
                    continue;
                }

                // 2. Gọi hàm private để tính toán chi tiết
                $invoiceDetails = $this->calculateInvoiceDetails($hopDong, $dienNuoc);

                // 3. Lấy nợ kỳ trước (từ map đã truy vấn) -> an toàn và hiệu quả
                $noKyTruoc = $noKyTruocMap->get($hopDong->room_id)?->con_no ?? 0;

                // 4. Tổng hợp và tạo hóa đơn
                $tongTien = $hopDong->gia_thue + $invoiceDetails['tong_chi_phi_dich_vu'];

                HoaDon::create(array_merge(
                    [
                        'ma_hoa_don' => 'HD-' . $hopDong->room_id . '-' . str_pad($thang, 2, '0', STR_PAD_LEFT) . $nam,
                        'nha_tro_id' => $hopDong->nha_tro_id,
                        'room_id' => $hopDong->room_id,
                        'user_id' => $hopDong->user_id,
                        'hop_dong_thue_phong_id' => $hopDong->id,
                        'thang' => $thang,
                        'nam' => $nam,
                        'ngay_tao_hoa_don' => now(),
                        'han_thanh_toan' => now()->addDays(10),
                        'tien_thue_phong' => $hopDong->gia_thue,
                        'tong_tien' => $tongTien,
                        'no_ky_truoc' => $noKyTruoc,
                    ],
                    $invoiceDetails // Gộp mảng chứa tiền điện, nước, phụ phí...
                ));

                $countSuccess++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi tạo hóa đơn hàng loạt: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('hoa-dons.index')->with('error', 'Đã xảy ra lỗi nghiêm trọng. Vui lòng thử lại.');
        }

        $message = "Tạo hóa đơn hoàn tất! Thành công: $countSuccess. Bỏ qua: $countSkipped.";
        if (!empty($errors)) {
            session()->flash('generation_errors', $errors);
        }
        return redirect()->route('hoa-dons.index')->with('success', $message);
    }

    /**
     * Tạo một hóa đơn duy nhất cho một hợp đồng cụ thể (tạo thủ công).
     */
    public function taoHoaDonChoHopDong(Request $request, HopDongThuePhong $hopDong)
    {
        $validated = $request->validate([
            'thang' => 'required|integer|between:1,12',
            'nam' => 'required|integer|min:2020',
            'chi_so_dien_truoc' => 'required|integer|min:0',
            'chi_so_dien' => 'required|integer|gte:chi_so_dien_truoc',
            'so_m3_nuoc_truoc' => 'required|integer|min:0',
            'so_m3_nuoc_sau' => 'required|integer|gte:so_m3_nuoc_truoc',
            'so_nguoi' => 'required|integer|min:1',
        ]);

        $thang = $validated['thang'];
        $nam = $validated['nam'];
        $room = $hopDong->room;

        if (HoaDon::where('room_id', $room->id)->where('thang', $thang)->where('nam', $nam)->exists()) {
            return redirect()->back()->with('error', "Hóa đơn cho phòng {$room->ten_phong} tháng {$thang}/{$nam} đã tồn tại!");
        }

        DB::beginTransaction();
        try {
            // 1. Tạo hoặc cập nhật bản ghi điện nước từ input
            $dienNuoc = DienNuocTheoPhong::updateOrCreate(
                ['room_id' => $room->id, 'thang' => $thang, 'nam' => $nam],
                [
                    'nha_tro_id' => $room->nha_tro_id,
                    'chi_so_dien_truoc' => $validated['chi_so_dien_truoc'],
                    'chi_so_dien' => $validated['chi_so_dien'],
                    'dien_tieu_thu' => $validated['chi_so_dien'] - $validated['chi_so_dien_truoc'],
                    'so_m3_nuoc_truoc' => $validated['so_m3_nuoc_truoc'],
                    'so_m3_nuoc_sau' => $validated['so_m3_nuoc_sau'],
                    'nuoc_tieu_thu' => $validated['so_m3_nuoc_sau'] - $validated['so_m3_nuoc_truoc'],
                    'so_nguoi' => $validated['so_nguoi'],
                    'trang_thai_chot' => true
                ]
            );

            // 2. Gọi hàm private để tính toán chi tiết
            $invoiceDetails = $this->calculateInvoiceDetails($hopDong, $dienNuoc);

            // 3. Lấy nợ kỳ trước (an toàn hơn)
            $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();
            $noKyTruoc = HoaDon::where('room_id', $room->id)->where('thang', $ngayKyTruoc->month)->where('nam', $ngayKyTruoc->year)->first()?->con_no ?? 0;

            // 4. Tổng hợp và tạo hóa đơn
            $tongTien = $hopDong->gia_thue + $invoiceDetails['tong_chi_phi_dich_vu'];

            $hoaDonMoi = HoaDon::create(array_merge(
                [
                    'ma_hoa_don' => 'HD-' . $room->id . '-' . str_pad($thang, 2, '0', STR_PAD_LEFT) . $nam,
                    'nha_tro_id' => $hopDong->nha_tro_id,
                    'room_id' => $room->id,
                    'user_id' => $hopDong->user_id,
                    'hop_dong_thue_phong_id' => $hopDong->id,
                    'thang' => $thang,
                    'nam' => $nam,
                    'ngay_tao_hoa_don' => now(),
                    'han_thanh_toan' => now()->addDays(10),
                    'tien_thue_phong' => $hopDong->gia_thue,
                    'tong_tien' => $tongTien,
                    'no_ky_truoc' => $noKyTruoc,
                ],
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
     * Phương thức private để tính toán chi tiết hóa đơn, tránh lặp code.
     * Hàm này là trung tâm của logic nghiệp vụ mới.
     *
     * @param HopDongThuePhong $hopDong
     * @param DienNuocTheoPhong $dienNuocData
     * @return array
     */
    private function calculateInvoiceDetails(HopDongThuePhong $hopDong, DienNuocTheoPhong $dienNuocData): array
    {
        $tienDien = 0;
        $tienNuoc = 0;
        $tongPhuPhi = 0;
        $chiTietDichVuKhac = [];

        // Lấy tất cả dịch vụ đã được eager load từ nhà trọ
        $dichVus = $hopDong->nhaTro->dichVus;

        foreach ($dichVus as $dichVu) {
            $donGia = $dichVu->pivot->don_gia;
            $kieuTinh = $dichVu->pivot->kieu_tinh;
            $maDichVu = $dichVu->ma_dich_vu; // Sử dụng mã dịch vụ để nhất quán
            $thanhTien = 0;
            $soLuong = 1;

            switch ($kieuTinh) {
                case 'theo_cong_to':
                    if ($maDichVu === 'dien_sinh_hoat') {
                        $soLuong = $dienNuocData->dien_tieu_thu;
                        $thanhTien = $soLuong * $donGia;
                        $tienDien = $thanhTien;
                    } elseif ($maDichVu === 'nuoc_sinh_hoat') { // Giả sử mã dịch vụ nước là 'nuoc_sinh_hoat'
                        $soLuong = $dienNuocData->nuoc_tieu_thu;
                        $thanhTien = $soLuong * $donGia;
                        $tienNuoc = $thanhTien;
                    }
                    break;
                case 'dau_nguoi':
                    $soLuong = $dienNuocData->so_nguoi;
                    $thanhTien = $soLuong * $donGia;
                    $tongPhuPhi += $thanhTien;
                    break;
                case 'co_dinh':
                    $soLuong = 1;
                    $thanhTien = $donGia;
                    $tongPhuPhi += $thanhTien;
                    break;
            }

            // Ghi lại chi tiết tất cả các dịch vụ không phải điện nước tính theo công tơ
            // Logic này sẽ tự động đưa nước vào phụ phí nếu nó được tính theo đầu người/cố định
            $isMeteredCoreService = ($maDichVu === 'dien_sinh_hoat' || $maDichVu === 'nuoc_sinh_hoat') && $kieuTinh === 'theo_cong_to';
            if (!$isMeteredCoreService) {
                $chiTietDichVuKhac[] = [
                    'ten_dich_vu' => $dichVu->ten_dich_vu,
                    'don_gia' => $donGia,
                    'so_luong' => $soLuong,
                    'kieu_tinh' => $kieuTinh,
                    'thanh_tien' => $thanhTien,
                ];
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