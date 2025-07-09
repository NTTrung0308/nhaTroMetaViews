<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\CongTo;
use App\Models\NhaTros;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CongtoDienController extends Controller
{
    private $loai = 'dien'; // Xác định loại công tơ cho controller này

    public function __construct()
    {
        // Cập nhật tên quyền cho phù hợp
        $this->middleware('can:Xem công tơ điện')->only(['index']);
        $this->middleware('can:Thêm công tơ điện')->only(['create', 'store']);
        $this->middleware('can:Sửa công tơ điện')->only(['edit', 'update']);
        $this->middleware('can:Xóa công tơ điện')->only(['destroy']);
    }

    public function index(Request $request)
    {
        // Tự động lọc theo loại 'dien'
        $query = CongTo::where('loai', $this->loai)->with('room', 'nhaTro')->latest();

        if ($request->filled('nha_tro_id')) {
            $query->where('nha_tro_id', $request->nha_tro_id);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        $congTos = $query->orderBy('created_at', 'desc')->paginate(10);

        $nhaTros = NhaTros::all();
        $rooms = Rooms::all();

        // Sử dụng view chung hoặc view riêng, ví dụ: 'admin.dien.index'
        return view('admin.cong_tos.dien.index', compact('congTos', 'nhaTros', 'rooms'));
    }

    public function create()
    {
        $nhaTros = NhaTros::all();
        $rooms = Rooms::all();
        $congTo = null;

        return view('admin.cong_tos.dien.form', compact('nhaTros', 'rooms', 'congTo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nha_tro_id' => 'required|exists:nha_tros,id',
            'room_id' => 'required|exists:rooms,id',
            'chi_so_dau' => 'required|integer|min:0',
        ], [
            'nha_tro_id.required' => 'Vui lòng chọn tòa nhà.',
            'nha_tro_id.exists'   => 'Tòa nhà không tồn tại trong hệ thống.',
            'room_id.required'    => 'Vui lòng chọn phòng.',
            'room_id.exists'      => 'Phòng không tồn tại trong hệ thống.',
            'chi_so_dau.required' => 'Vui lòng nhập chỉ số đầu.',
            'chi_so_dau.integer'  => 'Chỉ số đầu phải là số nguyên.',
            'chi_so_dau.min'      => 'Chỉ số đầu phải lớn hơn hoặc bằng 0.',
        ]);

        // Kiểm tra công tơ điện đã tồn tại chưa
        $exists = CongTo::where('room_id', $request->room_id)
            ->where('loai', $this->loai)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Phòng này đã có công tơ điện.');
        }

        CongTo::create([
            'nha_tro_id' => $request->nha_tro_id,
            'room_id' => $request->room_id,
            'loai' => $this->loai, // Tự động gán loại là 'dien'
            'chi_so_dau' => $request->chi_so_dau,
        ]);

        LogHelper::ghi('Thêm công tơ điện cho phòng ' . $request->room_id, 'Công tơ', 'Thêm công tơ điện bởi ' . Auth::user()->name);
        return redirect()->route('admin.cong_tos.dien.index')->with('success', 'Thêm công tơ điện thành công');
    }

    public function edit(CongTo $dien) // Sử dụng route model binding với tên biến mới
    {
        $nhaTros = NhaTros::all();
        $rooms = Rooms::all();
        return view('admin.cong_tos.dien.form', ['congTo' => $dien, 'nhaTros' => $nhaTros, 'rooms' => $rooms]);
    }

    public function update(Request $request, CongTo $dien)
    {
        $request->validate([
            'nha_tro_id'   => 'required|exists:nha_tros,id',
            'room_id'      => 'required|exists:rooms,id',
            'chi_so_dau'   => 'required|integer|min:0',
        ], [
            'nha_tro_id.required'   => 'Vui lòng chọn tòa nhà.',
            'room_id.required'      => 'Vui lòng chọn phòng.',
            'chi_so_dau.required'   => 'Vui lòng nhập chỉ số đầu.',
        ]);

        // Kiểm tra công tơ loại đó đã tồn tại chưa, ngoại trừ bản ghi hiện tại
        $exists = CongTo::where('room_id', $request->room_id)
            ->where('loai', $this->loai)
            ->where('id', '!=', $dien->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Phòng này đã có công tơ điện.');
        }

        $dien->update([
            'nha_tro_id' => $request->nha_tro_id,
            'room_id' => $request->room_id,
            'loai' => $this->loai, // Luôn đảm bảo đúng loại
            'chi_so_dau' => $request->chi_so_dau,
        ]);

        LogHelper::ghi('Sửa công tơ điện phòng ' . $request->room_id, 'Công tơ', 'Sửa công tơ điện bởi ' . Auth::user()->name);
        return redirect()->route('admin.cong_tos.dien.index')->with('success', 'Cập nhật công tơ điện thành công');
    }

    public function destroy(CongTo $dien)
    {
        $ten_phong = $dien->room->ten_phong;
        $dien->delete();
        LogHelper::ghi('Xóa công tơ điện phòng ' . $ten_phong, 'Công tơ', 'Xóa công tơ điện bởi ' . Auth::user()->name);

        return redirect()->route('admin.cong_tos.dien.index')->with('success', 'Xóa công tơ điện thành công');
    }
}
