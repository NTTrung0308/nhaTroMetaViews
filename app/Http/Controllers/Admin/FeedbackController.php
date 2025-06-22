<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem cảm nghĩ')->only(['index']);
        $this->middleware('can:Thêm cảm nghĩ')->only(['create', 'store']);
        $this->middleware('can:Sửa cảm nghĩ')->only(['edit', 'update']);
        $this->middleware('can:Xóa cảm nghĩ')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $query = Feedback::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }

        if ($request->filled('active')) {
            $query->where('active', $request->active == '1' ? 1 : 0);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(20); // phân trang

        return view('admin.feedbacks.index', compact('feedbacks'));
    }


    public function create()
    {
        return view('admin.feedbacks.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image',
            'active' => 'boolean',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'position.string' => 'Chức vụ phải là chuỗi.',
            'position.max' => 'Chức vụ không được vượt quá 255 ký tự.',

            'message.required' => 'Nội dung cảm nghĩ là bắt buộc.',
            'message.string' => 'Nội dung cảm nghĩ phải là chuỗi.',

            'image.image' => 'Tệp ảnh phải là hình ảnh hợp lệ.',

            'active.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/feedbacks'), $filename);
            $data['image'] = 'uploads/feedbacks/' . $filename;
        }

        $feedback = Feedback::create($data);
        // ✅ Ghi log chi tiết
        $admin = Auth::user();
        LogHelper::ghi(
            'Thêm cảm nghĩ mới',
            'Cảm nghĩ',
            'Người dùng "' . $admin->name . '" (ID: ' . $admin->id . ') đã thêm cảm nghĩ của "' . $feedback->name . '"' .
                ($feedback->position ? ' - Chức vụ: ' . $feedback->position : '') .
                ($feedback->image ? ' (có ảnh)' : ' (không ảnh)') .
                '.'
        );

        return redirect()->route('feedbacks.index')->with('success', 'Thêm cảm nghĩ thành công.');
    }

    public function edit(Feedback $feedback)
    {
        return view('admin.feedbacks.form', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image',
            'active' => 'boolean',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'position.string' => 'Chức vụ phải là chuỗi.',
            'position.max' => 'Chức vụ không được vượt quá 255 ký tự.',

            'message.required' => 'Nội dung cảm nghĩ là bắt buộc.',
            'message.string' => 'Nội dung cảm nghĩ phải là chuỗi.',

            'image.image' => 'Tệp ảnh phải là hình ảnh hợp lệ.',

            'active.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($feedback->image) && file_exists(public_path($feedback->image))) {
                unlink(public_path($feedback->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/feedbacks'), $filename);
            $data['image'] = 'uploads/feedbacks/' . $filename;
            $daThayAnh = true;
        }

        $feedback->update($data);


        // Ghi log chi tiết
        $admin = Auth::user();
        LogHelper::ghi(
            'Cập nhật cảm nghĩ: ' . $feedback->name,
            'Cảm nghĩ',
            'Người dùng "' . $admin->name . '" (ID: ' . $admin->id . ') đã cập nhật cảm nghĩ "' . $feedback->name . '"' .
                ($feedback->position ? ' - Chức vụ: ' . $feedback->position : '') .
                ($daThayAnh ? ' (có thay ảnh)' : ' (không thay ảnh)')
        );

        return redirect()->route('feedbacks.index')->with('success', 'Cập nhật cảm nghĩ thành công.');
    }


    public function destroy(Feedback $feedback)
    {
        $admin = Auth::user();
        $feedbackName = $feedback->name;

        // Xóa ảnh nếu có
        if (!empty($feedback->image) && file_exists(public_path($feedback->image))) {
            unlink(public_path($feedback->image));
        }

        $feedback->delete();

        // Ghi log
        LogHelper::ghi(
            'Xóa cảm nghĩ: ' . $feedbackName,
            'Cảm nghĩ',
            'Người dùng "' . $admin->name . '" (ID: ' . $admin->id . ') đã xóa cảm nghĩ "' . $feedbackName . '"'
        );

        return redirect()->route('feedbacks.index')->with('success', 'Xóa cảm nghĩ thành công.');
    }
}
