<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\PhuongTien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhuongTienController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem phương tiện')->only(['index']);
        $this->middleware('can:Thêm phương tiện')->only(['create', 'store']);
        $this->middleware('can:Sửa phương tiện')->only(['edit', 'update']);
        $this->middleware('can:Xóa phương tiện')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $query = PhuongTien::with('user');
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'nguoi-thue-tro');
        })->get();
        // Lọc theo user_id nếu có
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $phuongTiens = $query->orderBy('created_at', 'desc')->paginate(20);
        $userId = $request->user_id ?? '';
        return view('admin.phuong_tien.index', compact('phuongTiens', 'userId', 'users'));
    }

    public function create(Request $request)
    {

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'nguoi-thue-tro');
        })->get();

        $selectedUserId = $request->user_id; // Nếu tạo từ link có user_id

        return view('admin.phuong_tien.form', compact('users', 'selectedUserId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bien_so' => 'required|unique:phuong_tiens,bien_so',
            'loai_phuong_tien' => 'required',
            'ten_chu_xe' => 'required',
            'user_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'Vui lòng nhập tên phương tiện.',
            'bien_so.required' => 'Vui lòng nhập biển số xe.',
            'bien_so.unique' => 'Biển số xe đã tồn tại.',
            'loai_phuong_tien.required' => 'Vui lòng chọn loại phương tiện.',
            'ten_chu_xe.required' => 'Vui lòng nhập tên chủ xe.',
            'user_id.required' => 'Vui lòng chọn người sở hữu.',
            'user_id.exists' => 'Người sở hữu không hợp lệ.',
        ]);

        $phuongTien = PhuongTien::create($request->all());

        // ✅ Ghi log
        LogHelper::ghi(
            'Thêm phương tiện: ' . $phuongTien->bien_so,
            'Phương Tiện',
            'Người dùng "' . Auth::user()->name . '" (ID: ' . Auth::user()->id . ') đã thêm phương tiện "' . $phuongTien->name . '" với biển số "' . $phuongTien->bien_so . '"'
        );

        return redirect()->route('admin.phuong_tiens.index')->with('success', 'Thêm phương tiện thành công!');
    }

    public function edit(PhuongTien $phuongTien)
    {
        $users = User::all();
        return view('admin.phuong_tien.form', compact('phuongTien', 'users'));
    }

    public function update(Request $request, PhuongTien $phuongTien)
    {
        $request->validate([
            'name' => 'required',
            'bien_so' => 'required|unique:phuong_tiens,bien_so,' . $phuongTien->id,
            'loai_phuong_tien' => 'required',
            'ten_chu_xe' => 'required',
            'user_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'Vui lòng nhập tên phương tiện.',
            'bien_so.required' => 'Vui lòng nhập biển số xe.',
            'bien_so.unique' => 'Biển số xe đã tồn tại.',
            'loai_phuong_tien.required' => 'Vui lòng chọn loại phương tiện.',
            'ten_chu_xe.required' => 'Vui lòng nhập tên chủ xe.',
            'user_id.required' => 'Vui lòng chọn người sở hữu.',
            'user_id.exists' => 'Người sở hữu không hợp lệ.',
        ]);

        $phuongTien->update($request->all());

        // ✅ Ghi log
        LogHelper::ghi(
            'Cập nhật phương tiện: ' . $phuongTien->bien_so,
            'Phương Tiện',
            'Người dùng "' . Auth::user()->name . '" (ID: ' . Auth::user()->id . ') đã cập nhật phương tiện "' . $phuongTien->name . '" với biển số "' . $phuongTien->bien_so . '"'
        );

        return redirect()->route('admin.phuong_tiens.index')->with('success', 'Cập nhật phương tiện thành công!');
    }

    public function destroy(PhuongTien $phuongTien)
    {
        $tenPhuongTien = $phuongTien->name;
        $bienSo = $phuongTien->bien_so;

        $phuongTien->delete();

        // ✅ Ghi log
        LogHelper::ghi(
            'Xóa phương tiện: ' . $bienSo,
            'Phương Tiện',
            'Người dùng "' . Auth::user()->name . '" (ID: ' . Auth::user()->id . ') đã xóa phương tiện "' . $tenPhuongTien . '" có biển số "' . $bienSo . '"'
        );
        return redirect()->route('admin.phuong_tiens.index')->with('success', 'Xóa phương tiện thành công!');
    }
}
