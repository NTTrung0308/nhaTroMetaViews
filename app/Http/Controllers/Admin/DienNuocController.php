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
   public function index(Request $request)
{
    $nhaTros = NhaTros::all();
    $selectedNhaTroId = $request->get('nha_tro_id');
    $thang = $request->get('thang');
    $nam = $request->get('nam');

    $dienNuocs = collect();
    $canTao = false;
    $kieuTinhNuoc = 'cong_to';

    if ($selectedNhaTroId && $thang && $nam) {
        $dienNuocs = DienNuocTheoPhong::where('nha_tro_id', $selectedNhaTroId)
            ->where('thang', $thang)
            ->where('nam', $nam)
            ->get();

        $canTao = $dienNuocs->isEmpty();

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
        $soNuoc = 0;

        if ($kieuTinhNuoc === 'cong_to') {
            $congTo = CongTo::where('room_id', $room->id)
                ->where('loai', 'nuoc')
                ->first();

            $soNuoc = $congTo->chi_so_dau ?? 0;
        } elseif ($kieuTinhNuoc === 'dau_nguoi') {
            $soNuoc = $room->so_khach ?? 1;
        } elseif ($kieuTinhNuoc === 'co_dinh') {
            $soNuoc = 1;
        }

        $dienThangTruoc = DienNuocTheoPhong::where('room_id', $room->id)
            ->where('thang', Carbon::create($request->nam, $request->thang, 1)->subMonth()->month)
            ->where('nam', Carbon::create($request->nam, $request->thang, 1)->subMonth()->year)
            ->first();

        $chiSoDienTruoc = $dienThangTruoc->chi_so_dien ?? 0;

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
        ]);
    }

    return redirect()->back()->with('success', 'Đã tạo dữ liệu điện nước cho tháng ' . $request->thang . '/' . $request->nam);
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
        'so_nguoi' => 'required|integer|min:0',
    ];

    if ($kieuTinhNuoc === 'cong_to') {
        $rules['so_m3_nuoc'] = 'required|numeric|min:0';
    }

    $request->validate($rules);

    $prev = Carbon::create($dienNuoc->nam, $dienNuoc->thang, 1)->subMonth();
    $dienTruoc = DienNuocTheoPhong::where('room_id', $dienNuoc->room_id)
        ->where('thang', $prev->month)
        ->where('nam', $prev->year)
        ->first();

    $chiSoDienTruoc = $dienTruoc->chi_so_dien ?? 0;
    $tieuThuDien = max(0, $request->chi_so_dien - $chiSoDienTruoc);

    $updateData = [
        'chi_so_dien' => $request->chi_so_dien,
        'tieu_thu_dien' => $tieuThuDien,
        'so_nguoi' => $request->so_nguoi,
    ];

    if ($kieuTinhNuoc === 'cong_to') {
        $updateData['so_m3_nuoc'] = $request->so_m3_nuoc;
        $updateData['tieu_thu_nuoc'] = $request->so_m3_nuoc;
    } elseif ($kieuTinhNuoc === 'dau_nguoi') {
        $updateData['so_m3_nuoc'] = $request->so_nguoi;
        $updateData['tieu_thu_nuoc'] = $request->so_nguoi;
    } elseif ($kieuTinhNuoc === 'co_dinh') {
        $updateData['so_m3_nuoc'] = 1;
        $updateData['tieu_thu_nuoc'] = 1;
    }

    $dienNuoc->update($updateData);

    return back()->with('success', 'Cập nhật thành công.');
}

}
