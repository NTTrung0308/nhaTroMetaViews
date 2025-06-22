<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Policie;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem chính sách')->only(['index']);
        $this->middleware('can:Thêm chính sách')->only(['create', 'store']);
        $this->middleware('can:Sửa chính sách')->only(['edit', 'update']);
        $this->middleware('can:Xóa chính sách')->only(['destroy']);
    }
    public function index()
    {
        $policies = Policie::latest()->get();
        return view('admin.policies.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.policies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề chính sách.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung chính sách.',
        ]);

        $data = $request->only('title', 'content');
        $data['active'] = $request->has('active');

        $chinhSach = Policie::create($data);

        // ✅ Ghi log chi tiết
        LogHelper::ghi(
            'Thêm chính sách: ' . $chinhSach->title,
            'Chính sách',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã thêm chính sách mới với tiêu đề: "' . $chinhSach->title . '"'
        );
        return redirect()->route('policies.index')->with('success', 'Thêm chính sách thành công');
    }


    public function edit(Policie $policy)
    {
        return view('admin.policies.edit', compact('policy'));
    }

    public function update(Request $request, Policie $policy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề chính sách.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung chính sách.',
        ]);

        $data = $request->only('title', 'content');
        $data['active'] = $request->has('active');

        $policy->update($data);

        // ✅ Ghi log chi tiết
        LogHelper::ghi(
            'Cập nhật chính sách: ' . $policy->title,
            'Chính sách',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã cập nhật chính sách có ID: ' . $policy->id
        );


        return redirect()->route('policies.index')->with('success', 'Cập nhật chính sách thành công');
    }


    public function destroy(Policie $policy)
    {
        $policyTitle = $policy->title;
        $policyId = $policy->id;

        $policy->delete();

        // ✅ Ghi log chi tiết
        LogHelper::ghi(
            'Xóa chính sách: ' . $policyTitle,
            'Chính sách',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã xóa chính sách có ID: ' . $policyId
        );

        return redirect()->route('policies.index')->with('success', 'Xóa chính sách thành công');
    }
};
