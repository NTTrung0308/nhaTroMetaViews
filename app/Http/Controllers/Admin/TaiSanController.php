<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\TaiSan;
use Illuminate\Http\Request;

class TaiSanController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem tài sản')->only(['index']);
        $this->middleware('can:Thêm tài sản')->only(['create', 'store']);
        $this->middleware('can:Sửa tài sản')->only(['edit', 'update']);
        $this->middleware('can:Xóa tài sản')->only(['destroy']);
    }
    public function index(Request $request)
    {

        $query = TaiSan::query();

        if ($request->filled('ten_tai_san')) {
            $query->where('ten_tai_san', 'like', '%' . $request->ten_tai_san . '%');
        }

        if ($request->filled('tinh_trang')) {
            $query->where('tinh_trang', $request->tinh_trang);
        }

        $taiSans = $query->orderBy('created_at', 'desc')->paginate(10); // hoặc get() nếu không cần phân trang
        // Ghi log chi tiết kèm bộ lọc
        $logChiTiet = 'Xem danh sách tài sản';
        if ($request->filled('ten_tai_san') || $request->filled('tinh_trang')) {
            $filters = [];
            if ($request->filled('ten_tai_san')) {
                $filters[] = 'Tên tài sản chứa "' . $request->ten_tai_san . '"';
            }
            if ($request->filled('tinh_trang')) {
                $filters[] = 'Tình trạng là "' . $request->tinh_trang . '"';
            }
            $logChiTiet .= ' với bộ lọc: ' . implode(', ', $filters);
        }

        LogHelper::ghi($logChiTiet, 'Tài Sản', 'Xem danh sách tài sản trong quản trị viên');
        return view('admin.tai_sans.index', compact('taiSans'));
    }

    public function create()
    {
        $user = auth()->user();
        LogHelper::ghi(
            'Vào form tạo tài sản bởi ' . $user->name . ' (ID: ' . $user->id . ')',
            'Tài Sản',
            'Vào form tạo tài sản trong quản trị viên bởi ' . $user->name
        );
        return view('admin.tai_sans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_tai_san'   => 'required|unique:tai_sans,ma_tai_san',
            'ten_tai_san'  => 'required|string|max:255',
            'ngay_mua'     => 'required|date', // hoặc required nếu bắt buộc
            'gia_tri'      => 'required|numeric|min:1',
            'tinh_trang'   => 'nullable|string|max:255', // có thể đổi sang enum nếu bạn có danh sách tình trạng cố định
            'ghi_chu'      => 'nullable|string|max:1000',
        ], [
            'ma_tai_san.required'  => 'Mã tài sản là bắt buộc.',
            'ma_tai_san.unique'    => 'Mã tài sản đã tồn tại.',
            'ten_tai_san.required' => 'Tên tài sản là bắt buộc.',
            'ten_tai_san.string'   => 'Tên tài sản phải là chuỗi.',
            'ten_tai_san.max'      => 'Tên tài sản không được vượt quá 255 ký tự.',
            'ngay_mua.date'        => 'Ngày mua không hợp lệ.',
            'ngay_mua.required'    => 'Ngày mua là bắt buộc.',
            'gia_tri.required'     => 'Giá trị tài sản là bắt buộc.',
            'gia_tri.numeric'      => 'Giá trị phải là số.',
            'gia_tri.min'          => 'Giá trị phải lớn hơn 0.',
            'tinh_trang.string'    => 'Tình trạng phải là chuỗi ký tự.',
            'tinh_trang.max'       => 'Tình trạng không được vượt quá 255 ký tự.',
            'ghi_chu.string'       => 'Ghi chú phải là chuỗi ký tự.',
            'ghi_chu.max'          => 'Ghi chú không được vượt quá 1000 ký tự.',
        ]);

        $taiSan = TaiSan::create($request->only([
            'ma_tai_san',
            'ten_tai_san',
            'ngay_mua',
            'gia_tri',
            'tinh_trang',
            'ghi_chu'
        ]));

        LogHelper::ghi(
            'Thêm tài sản mới: ' . $taiSan->ten_tai_san . ' (ID: ' . $taiSan->id . ')',
            'Tài Sản',
            'Thêm tài sản mới trong quản trị viên bởi ' . auth()->user()->name
        );

        return redirect()->route('tai-sans.index')->with('success', 'Thêm tài sản thành công');
    }

    public function edit($id)
    {
        $taiSan = TaiSan::findOrFail($id);
        LogHelper::ghi(
            'Vào form sửa tài sản: ' . $taiSan->ten_tai_san . ' (ID: ' . $taiSan->id . ')',
            'Tài Sản',
            'Vào form sửa tài sản trong quản trị viên bởi ' . auth()->user()->name
        );

        return view('admin.tai_sans.edit', compact('taiSan'));
    }

    public function update(Request $request, $id)
    {
        $taiSan = TaiSan::findOrFail($id);

        $request->validate([
            'ma_tai_san'   => 'required|unique:tai_sans,ma_tai_san,' . $taiSan->id,
            'ten_tai_san'  => 'required|string|max:255',
            'ngay_mua'     => 'nullable|date',
            'gia_tri'      => 'required|numeric|min:1',
            'tinh_trang'   => 'nullable|string|max:255',
            'ghi_chu'      => 'nullable|string|max:1000',
        ], [
            'ma_tai_san.required'  => 'Mã tài sản là bắt buộc.',
            'ma_tai_san.unique'    => 'Mã tài sản đã tồn tại.',
            'ten_tai_san.required' => 'Tên tài sản là bắt buộc.',
            'ten_tai_san.string'   => 'Tên tài sản phải là chuỗi.',
            'ten_tai_san.max'      => 'Tên tài sản không được vượt quá 255 ký tự.',
            'ngay_mua.date'        => 'Ngày mua không hợp lệ.',
            'gia_tri.required'     => 'Giá trị tài sản là bắt buộc.',
            'gia_tri.numeric'      => 'Giá trị phải là số.',
            'gia_tri.min'          => 'Giá trị phải lớn hơn 0.',
            'tinh_trang.string'    => 'Tình trạng phải là chuỗi ký tự.',
            'tinh_trang.max'       => 'Tình trạng không được vượt quá 255 ký tự.',
            'ghi_chu.string'       => 'Ghi chú phải là chuỗi ký tự.',
            'ghi_chu.max'          => 'Ghi chú không được vượt quá 1000 ký tự.',
        ]);
        $taiSan->update($request->all());

        LogHelper::ghi(
            'Cập nhật tài sản: ' . $taiSan->ten_tai_san . ' (ID: ' . $taiSan->id . ')',
            'Tài Sản',
            'Cập nhật tài sản trong quản trị viên bởi ' . auth()->user()->name
        );
        return redirect()->route('tai-sans.index')->with('success', 'Cập nhật tài sản thành công');
    }

    public function destroy($id)
    {
        $taiSan = TaiSan::findOrFail($id);
        $taiSan->delete();

        LogHelper::ghi(
            'Xóa tài sản: ' . $taiSan->ten_tai_san . ' (ID: ' . $taiSan->id . ')',
            'Tài Sản',
            'Xóa tài sản trong quản trị viên bởi ' . auth()->user()->name
        );

        return redirect()->route('tai-sans.index')->with('success', 'Xóa tài sản thành công!');
    }
}