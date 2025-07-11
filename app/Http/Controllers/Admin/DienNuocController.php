<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CongTo;
use App\Models\DichVu;
use App\Models\DienNuocTheoPhong;
use App\Models\NhaTros;
use App\Models\Rooms;
use App\Models\ToaNhaDichVu;
use Illuminate\Http\Request;

class DienNuocController extends Controller
{
     public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem quản lý điện nước')->only(['index']);
        $this->middleware('can:Thêm quản lý điện nước')->only([ 'store']);
        $this->middleware('can:Sửa quản lý điện nước')->only([ 'update']);
        $this->middleware('can:Chốt quản lý điện nước')->only([ 'chot']);
      
    }
    public function index(Request $request)
    {
        $nhaTros = NhaTros::all();
        $selectedNhaTroId = $request->get('nha_tro_id');
      $thang = $request->input('thang', now()->month);
$nam = $request->input('nam', now()->year);

        $dienNuocs = collect();
        $canTao = false;
        $kieuTinhNuoc = 'cong_to';

        if ($selectedNhaTroId && $thang && $nam) {
            $dienNuocs = DienNuocTheoPhong::with('room.congTos')->where('nha_tro_id', $selectedNhaTroId)
                ->where('thang', $thang)
                ->where('nam', $nam)
                ->get();

            $canTao = $dienNuocs->isEmpty();

            // Gán chỉ số điện đầu vào từng dòng
            foreach ($dienNuocs as $dn) {
                $dn->setAttribute('chi_so_dien_dau', $this->getChiSoDienTruocOrFromCongTo(
                    $dn->room_id,
                    $selectedNhaTroId,
                    $thang,
                    $nam
                ));
                // Thêm chỉ số nước đầu kỳ nếu kiểu công tơ
            
                    $dn->setAttribute('chi_so_nuoc_dau', $this->getChiSoNuocDauKy(
                        $dn->room_id,
                        $selectedNhaTroId,
                        $thang,
                        $nam
                    ));
             
            }

            // Lấy kiểu tính nước của tòa nhà
            $dichVu = DichVu::where('ma_dich_vu', 'nuoc')->first();
            $toaNhaDichVu = ToaNhaDichVu::where('nha_tro_id', $selectedNhaTroId)
                ->where('dich_vu_id', $dichVu->id ?? 0)
                ->first();

            $kieuTinhNuoc = $toaNhaDichVu->kieu_tinh ?? 'cong_to';
        }

        return view('admin.diennuoc.index', compact(
            'nhaTros',
            'selectedNhaTroId',
            'thang',
            'nam',
            'dienNuocs',
            'canTao',
            'kieuTinhNuoc'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nha_tro_id' => 'required',
            'thang' => 'required|numeric',
            'nam' => 'required|numeric'
        ]);

        $rooms = Rooms::where('nha_tro_id', $request->nha_tro_id)->get();

        $dichVu = DichVu::where('ma_dich_vu', 'nuoc')->first();
        $toaNhaDichVu = ToaNhaDichVu::where('nha_tro_id', $request->nha_tro_id)
            ->where('dich_vu_id', $dichVu->id ?? 0)
            ->first();

        $kieuTinhNuoc = $toaNhaDichVu->kieu_tinh ?? 'cong_to';

        foreach ($rooms as $room) {
            $chiSoDienTruoc = $this->getChiSoDienTruocOrFromCongTo($room->id, $request->nha_tro_id, $request->thang, $request->nam);

            if ($kieuTinhNuoc === 'cong_to') {
                $congTo = CongTo::where('room_id', $room->id)->where('loai', 'nuoc')->first();
                $soNuoc = $congTo->chi_so_dau ?? 0;
            } elseif ($kieuTinhNuoc === 'dau_nguoi') {
                $soNuoc = $room->so_khach ?? 1;
            } else {
                $soNuoc = 1;
            }

            DienNuocTheoPhong::create([
                'nha_tro_id' => $request->nha_tro_id,
                'room_id' => $room->id,
                'thang' => $request->thang,
                'nam' => $request->nam,
                'chi_so_dien' => 0,
                'so_m3_nuoc' => $soNuoc,
                'so_nguoi' => $room->so_khach ?? 1,
                'tieu_thu_dien' => 0,
                'tieu_thu_nuoc' => $soNuoc,
                'chiSoDienTruoc' => $chiSoDienTruoc
            ]);
        }

        return back()->with('success', 'Đã tạo dữ liệu điện nước cho tháng ' . $request->thang . '/' . $request->nam);
    }

    public function update(Request $request, $id)
    {
        $dienNuoc = DienNuocTheoPhong::findOrFail($id);

        $dichVu = DichVu::where('ma_dich_vu', 'nuoc')->first();
        $toaNhaDichVu = ToaNhaDichVu::where('nha_tro_id', $dienNuoc->nha_tro_id)
            ->where('dich_vu_id', $dichVu->id ?? 0)
            ->first();

        $kieuTinhNuoc = $toaNhaDichVu->kieu_tinh ?? 'cong_to';

        $rules = [
            'chi_so_dien' => 'required|numeric|min:0',
            'so_nguoi'    => 'required|integer|min:0',
        ];

        if ($kieuTinhNuoc === 'cong_to') {
            $rules['so_m3_nuoc'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $chiSoDienTruoc = $this->getChiSoDienTruocOrFromCongTo(
            $dienNuoc->room_id,
            $dienNuoc->nha_tro_id,
            $dienNuoc->thang,
            $dienNuoc->nam
        );
        $chiSoNuocTruoc = $this->getChiSoNuocDauKy(
            $dienNuoc->room_id,
            $dienNuoc->nha_tro_id,
            $dienNuoc->thang,
            $dienNuoc->nam
        );
        $updateData = [
            'so_m3_nuoc_truoc' => $chiSoNuocTruoc,
            'chi_so_dien_truoc' => $chiSoDienTruoc,
            'chi_so_dien'   => $request->chi_so_dien,
            'dien_tieu_thu' => max(0, $request->chi_so_dien - $chiSoDienTruoc),
            'so_nguoi'      => $request->so_nguoi,
        ];

        if ($kieuTinhNuoc === 'cong_to') {
            $updateData['so_m3_nuoc_sau'] = $request->so_m3_nuoc;
            // $updateData['nuoc_tieu_thu'] = $request->so_m3_nuoc;
            $updateData['nuoc_tieu_thu'] = max(0, $request->so_m3_nuoc - $chiSoNuocTruoc);
        } elseif ($kieuTinhNuoc === 'dau_nguoi') {
            $updateData['so_m3_nuoc_sau'] = $request->so_nguoi;
            $updateData['nuoc_tieu_thu'] = 0;
        } else {
            $updateData['so_m3_nuoc_sau'] = 1;
            $updateData['nuoc_tieu_thu'] = 1;
        }

        $dienNuoc->update($updateData);

        return back()->with('success', 'Cập nhật thành công.');
    }

    private function getChiSoDienTruocOrFromCongTo($roomId, $nhaTroId, $thang, $nam)
    {
        $truoc = DienNuocTheoPhong::where('room_id', $roomId)
            ->where(function ($query) use ($nam, $thang) {
                $query->where('nam', '<', $nam)
                    ->orWhere(function ($q) use ($nam, $thang) {
                        $q->where('nam', $nam)->where('thang', '<', $thang);
                    });
            })
            ->orderByDesc('nam')->orderByDesc('thang')->first();

        if ($truoc) {
            return $truoc->chi_so_dien;
        }

        // Nếu không có bản ghi điện nước trước đó → fallback sang công tơ
        $congTo = CongTo::where('nha_tro_id', $nhaTroId)
            ->where('room_id', $roomId)
            ->where('loai', 'dien')
            ->first();

        return $congTo?->chi_so_dau ?? 0;
    }
    private function getChiSoNuocDauKy($roomId, $nhaTroId, $thang, $nam)
    {
        $truoc = DienNuocTheoPhong::where('room_id', $roomId)
            ->where(function ($query) use ($nam, $thang) {
                $query->where('nam', '<', $nam)
                    ->orWhere(function ($q) use ($nam, $thang) {
                        $q->where('nam', $nam)->where('thang', '<', $thang);
                    });
            })
            ->orderByDesc('nam')->orderByDesc('thang')->first();

        if ($truoc) {
            return $truoc->so_m3_nuoc_truoc;
        }

        $congTo = CongTo::where('nha_tro_id', $nhaTroId)
            ->where('room_id', $roomId)
            ->where('loai', 'nuoc')
            ->first();

        return $congTo?->chi_so_dau ?? 0;
    }
    public function chot($id)
{
    $dienNuoc = DienNuocTheoPhong::findOrFail($id);

    if ($dienNuoc->trang_thai_chot) {
        return back()->with('warning', 'Dữ liệu đã chốt trước đó.');
    }

    $dienNuoc->update(['trang_thai_chot' => true]);

    return back()->with('success', 'Đã chốt dữ liệu thành công.');
}

}
