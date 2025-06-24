<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DienNuocTheoPhong;
use App\Models\HoaDon;
use App\Models\HopDongThuePhong;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HoaDonController extends Controller
{
     /**
     * Hiển thị danh sách hóa đơn.
     */
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

        // Lấy tất cả hợp đồng đang hoạt động và các dữ liệu liên quan
        $activeContracts = HopDongThuePhong::where('active', true)->with(['room.nhaTro.dichVus'])->get();
dd($activeContracts);
        DB::beginTransaction();
        try {
            foreach ($activeContracts as $contract) {
                // Kiểm tra xem hóa đơn đã tồn tại chưa
                $existingInvoice = HoaDon::where('room_id', $contract->room_id)
                    ->where('thang', $thang)
                    ->where('nam', $nam)
                    ->exists();

                if ($existingInvoice) {
                    $countSkipped++;
                    continue;
                }

                // 1. Lấy thông tin điện nước đã được nhập sẵn
                $dienNuoc = DienNuocTheoPhong::where('room_id', $contract->room_id)
                    ->where('thang', $thang)
                    ->where('nam', $nam)
                    ->first();

                // Nếu không có bản ghi điện nước cho tháng đó, bỏ qua
                if (!$dienNuoc) {
                    $countSkipped++;
                    continue;
                }

                // 2. Lấy đơn giá dịch vụ của tòa nhà
                $dichVuDien = $contract->room->nhaTro->dichVus()->where('ma_dich_vu', 'dien_sinh_hoat')->first();
                $dichVuNuoc = $contract->room->nhaTro->dichVus()->where('ma_dich_vu', 'nuoc')->first();
                
                $donGiaDien = $dichVuDien->pivot->don_gia ?? 3500;
                $donGiaNuoc = $dichVuNuoc->pivot->don_gia ?? 20000;

                $tienDien = $dienNuoc->dien_tieu_thu * $donGiaDien;
                $tienNuoc = $dienNuoc->nuoc_tieu_thu * $donGiaNuoc;
                
                // 3. Tính các dịch vụ khác
                $cacDichVuKhac = $contract->room->nhaTro->dichVus()->whereNotIn('ma_dich_vu', ['dien_sinh_hoat', 'nuoc'])->get();
                $chiTietDichVuKhac = [];
                $tongPhuPhi = 0;
                foreach ($cacDichVuKhac as $dv) {
                    $thanhTien = ($dv->pivot->kieu_tinh == 'dau_nguoi')
                                ? $dv->pivot->don_gia * $dienNuoc->so_nguoi
                                : $dv->pivot->don_gia;
                    $chiTietDichVuKhac[] = [
                        'ten_dich_vu' => $dv->ten_dich_vu,
                        'don_gia' => $dv->pivot->don_gia,
                        'so_luong' => ($dv->pivot->kieu_tinh == 'dau_nguoi') ? $dienNuoc->so_nguoi : 1,
                        'kieu_tinh' => $dv->pivot->kieu_tinh,
                        'thanh_tien' => $thanhTien,
                    ];
                    $tongPhuPhi += $thanhTien;
                }

                // 4. Lấy nợ kỳ trước
                $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();
                $noKyTruoc = HoaDon::where('room_id', $contract->room_id)
                    ->where('thang', $ngayKyTruoc->month)
                    ->where('nam', $ngayKyTruoc->year)
                    ->first()->con_no ?? 0;

                // 5. Tổng hợp và tạo hóa đơn
                $tongTien = $contract->gia_thue + $tienDien + $tienNuoc + $tongPhuPhi;
                
                HoaDon::create([
                    'ma_hoa_don' => 'HD-' . $contract->room_id . '-' . str_pad($thang, 2, '0', STR_PAD_LEFT) . $nam,
                    'nha_tro_id' => $contract->nha_tro_id,
                    'room_id' => $contract->room_id,
                    'user_id' => $contract->user_id,
                    'hop_dong_thue_phong_id' => $contract->id,
                    'thang' => $thang,
                    'nam' => $nam,
                    'ngay_tao_hoa_don' => now(),
                    'han_thanh_toan' => now()->addDays(10),
                    'tien_thue_phong' => $contract->gia_thue,
                    'tien_dien' => $tienDien,
                    'tien_nuoc' => $tienNuoc,
                    'chi_tiet_dich_vu_khac' => $chiTietDichVuKhac,
                    'tong_phu_phi' => $tongPhuPhi,
                    'tong_tien' => $tongTien,
                    'no_ky_truoc' => $noKyTruoc,
                ]);
                $countSuccess++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('hoa-dons.index')->with('error', 'Lỗi: ' . $e->getMessage());
        }

        return redirect()->route('hoa-dons.index')->with('success', "Tạo hóa đơn hoàn tất! Thành công: $countSuccess. Bỏ qua: $countSkipped (đã tồn tại hoặc thiếu dữ liệu điện nước).");
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
            $dienTieuThu = $validated['chi_so_dien'] - $validated['chi_so_dien_truoc'];
            $nuocTieuThu = $validated['so_m3_nuoc_sau'] - $validated['so_m3_nuoc_truoc'];

            DienNuocTheoPhong::updateOrCreate(
                ['room_id' => $room->id, 'thang' => $thang, 'nam' => $nam],
                ['nha_tro_id' => $room->nha_tro_id, 'chi_so_dien_truoc' => $validated['chi_so_dien_truoc'], 'chi_so_dien' => $validated['chi_so_dien'], 'so_m3_nuoc_truoc' => $validated['so_m3_nuoc_truoc'], 'so_m3_nuoc_sau' => $validated['so_m3_nuoc_sau'], 'so_nguoi' => $validated['so_nguoi'], 'dien_tieu_thu' => $dienTieuThu, 'nuoc_tieu_thu' => $nuocTieuThu, 'trang_thai_chot' => true]
            );

            $dichVuDien = $room->nhaTro->dichVus()->where('ten_dich_vu', 'Điện')->first();
            $dichVuNuoc = $room->nhaTro->dichVus()->where('ten_dich_vu', 'Nước')->first();
            $donGiaDien = $dichVuDien->pivot->don_gia ?? 3500;
            $donGiaNuoc = $dichVuNuoc->pivot->don_gia ?? 20000;
            $tienDien = $dienTieuThu * $donGiaDien;
            $tienNuoc = $nuocTieuThu * $donGiaNuoc;
            
            $cacDichVuKhac = $room->nhaTro->dichVus()->whereNotIn('ten_dich_vu', ['Điện', 'Nước'])->get();
            $chiTietDichVuKhac = [];
            $tongPhuPhi = 0;
            foreach ($cacDichVuKhac as $dv) {
                $thanhTien = ($dv->pivot->kieu_tinh == 'dau_nguoi') ? $dv->pivot->don_gia * $validated['so_nguoi'] : $dv->pivot->don_gia;
                $chiTietDichVuKhac[] = ['ten_dich_vu' => $dv->ten_dich_vu, 'don_gia' => $dv->pivot->don_gia, 'so_luong' => ($dv->pivot->kieu_tinh == 'dau_nguoi') ? $validated['so_nguoi'] : 1, 'kieu_tinh' => $dv->pivot->kieu_tinh, 'thanh_tien' => $thanhTien];
                $tongPhuPhi += $thanhTien;
            }

            $ngayKyTruoc = Carbon::create($nam, $thang, 1)->subMonth();
            $noKyTruoc = HoaDon::where('room_id', $room->id)->where('thang', $ngayKyTruoc->month)->where('nam', $ngayKyTruoc->year)->first()->con_no ?? 0;

            $tongTien = $hopDong->gia_thue + $tienDien + $tienNuoc + $tongPhuPhi;
            $maHoaDon = 'HD-' . $room->id . '-' . str_pad($thang, 2, '0', STR_PAD_LEFT) . $nam;
            
            $hoaDonMoi = HoaDon::create([
                'ma_hoa_don' => $maHoaDon, 'nha_tro_id' => $hopDong->nha_tro_id, 'room_id' => $room->id, 'user_id' => $hopDong->user_id, 'hop_dong_thue_phong_id' => $hopDong->id, 'thang' => $thang, 'nam' => $nam, 'ngay_tao_hoa_don' => now(), 'han_thanh_toan' => now()->addDays(10), 'tien_thue_phong' => $hopDong->gia_thue, 'tien_dien' => $tienDien, 'tien_nuoc' => $tienNuoc, 'chi_tiet_dich_vu_khac' => $chiTietDichVuKhac, 'tong_phu_phi' => $tongPhuPhi, 'tong_tien' => $tongTien, 'no_ky_truoc' => $noKyTruoc,
            ]);

            DB::commit();

            return redirect()->route('hoa-dons.show', $hoaDonMoi->id)->with('success', "Đã tạo thành công hóa đơn cho phòng {$room->ten_phong} tháng {$thang}/{$nam}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hiển thị chi tiết hóa đơn.
     */
    public function show(HoaDon $hoaDon)
    {
    //    dd($hoaDon->user);
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
