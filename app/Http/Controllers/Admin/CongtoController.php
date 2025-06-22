<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\CongTo;
use App\Models\NhaTro;
use App\Models\NhaTros;
use App\Models\Room;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CongtoController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem công tơ')->only(['index']);
        $this->middleware('can:Thêm công tơ')->only(['create', 'store']);
        $this->middleware('can:Sửa công tơ')->only(['edit', 'update']);
        $this->middleware('can:Xóa công tơ')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $query = CongTo::with('room', 'nhaTro')->latest();

        if ($request->filled('nha_tro_id')) {
            $query->where('nha_tro_id', $request->nha_tro_id);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        $congTos = $query->orderBy('created_at', 'desc')->paginate(10);

        // Dữ liệu để render ô lọc
        $nhaTros = NhaTros::all();
        $rooms = Rooms::all();

        return view('admin.cong_tos.index', compact('congTos', 'nhaTros', 'rooms'));
    }

    public function create()
    {
        $nhaTros = NhaTros::all();
        $rooms = Rooms::all();
        $congTo = null;

        return view('admin.cong_tos.form', compact('nhaTros', 'rooms', 'congTo'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nha_tro_id' => 'required|exists:nha_tros,id',
            'room_id' => 'required|exists:rooms,id',
            'loai' => 'required|in:nuoc,dien',
            'chi_so_dau' => 'required|integer|min:0',
        ], [
            'nha_tro_id.required' => 'Vui lòng chọn tòa nhà.',
            'nha_tro_id.exists'   => 'Tòa nhà không tồn tại trong hệ thống.',

            'room_id.required'    => 'Vui lòng chọn phòng.',
            'room_id.exists'      => 'Phòng không tồn tại trong hệ thống.',

            'loai.required'       => 'Vui lòng chọn loại công tơ.',
            'loai.in'             => 'Loại công tơ không hợp lệ. Chỉ chấp nhận điện hoặc nước.',

            'chi_so_dau.required' => 'Vui lòng nhập chỉ số đầu.',
            'chi_so_dau.integer'  => 'Chỉ số đầu phải là số nguyên.',
            'chi_so_dau.min'      => 'Chỉ số đầu phải lớn hơn hoặc bằng 0.',
        ]);

        
      

        // Kiểm tra công tơ đã tồn tại chưa
        $exists = CongTo::where('room_id', $request->room_id)
            ->where('loai', $request->loai)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Phòng đã có công tơ ' . $request->loai);
        }

        CongTo::create([
            'nha_tro_id' => $request->nha_tro_id,
            'room_id' => $request->room_id,
            'loai' => $request->loai,
            'chi_so_dau' => $request->chi_so_dau,
        ]);
        LogHelper::ghi('Thêm công tơ loại ' . $request->loai . ' trong phòng ' . $request->room_id, 'Công tơ', 'Thêm công tơ loại ' . $request->loai . ' trong quản trị viên bởi' . Auth::user()->name);
        return redirect()->route('admin.cong_tos.index')->with('success', 'Thêm công tơ thành công');
    }

    public function edit(CongTo $congTo)
    {
        $nhaTros = NhaTros::all();
        $rooms = Rooms::all();
        return view('admin.cong_tos.form', compact('congTo', 'nhaTros', 'rooms'));
    }

    public function update(Request $request, CongTo $congTo)
    {
        $request->validate([
            'nha_tro_id'   => 'required|exists:nha_tros,id',
            'room_id'      => 'required|exists:rooms,id',
            'loai'         => 'required|in:nuoc,dien',
            'chi_so_dau'   => 'required|integer|min:0',
        ], [
            'nha_tro_id.required'   => 'Vui lòng chọn tòa nhà.',
            'nha_tro_id.exists'     => 'Tòa nhà không tồn tại.',

            'room_id.required'      => 'Vui lòng chọn phòng.',
            'room_id.exists'        => 'Phòng không tồn tại.',

            'loai.required'         => 'Vui lòng chọn loại công tơ.',
            'loai.in'               => 'Loại công tơ không hợp lệ. Chỉ chấp nhận "nước" hoặc "điện".',

            'chi_so_dau.required'   => 'Vui lòng nhập chỉ số đầu.',
            'chi_so_dau.integer'    => 'Chỉ số đầu phải là số nguyên.',
            'chi_so_dau.min'        => 'Chỉ số đầu phải lớn hơn hoặc bằng 0.',
        ]);

        
        // Kiểm tra công tơ loại đó đã tồn tại chưa, ngoại trừ bản ghi hiện tại
        $exists = CongTo::where('room_id', $request->room_id)
            ->where('loai', $request->loai)
            ->where('id', '!=', $congTo->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Phòng đã có công tơ ' . $request->loai);
        }

        $congTo->update([
            'nha_tro_id' => $request->nha_tro_id,
            'room_id' => $request->room_id,
            'loai' => $request->loai,
            'chi_so_dau' => $request->chi_so_dau,
        ]);
        LogHelper::ghi('Sửa công tơ loại ' . $request->loai . ' trong phòng ' . $request->room_id, 'Công tơ', 'Sửa công tơ loại ' . $request->loai  . ' trong quản trị viên bởi' . Auth::user()->name);
        return redirect()->route('admin.cong_tos.index')->with('success', 'Cập nhật công tơ thành công');
    }

    public function destroy(CongTo $congTo)
    {
        $congTo->delete();
        LogHelper::ghi('Xóa công tơ ' . $congTo->room->ten_phong, 'Công tơ', 'Xóa công tơ ' . $congTo->room->ten_phong . ' trong quản trị viên bởi' . Auth::user()->name);

        return redirect()->route('admin.cong_tos.index')->with('success', 'Xóa công tơ thành công');
    }
}
