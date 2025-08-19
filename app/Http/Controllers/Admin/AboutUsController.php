<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
     public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
       
        $this->middleware('can:Về chúng tôi')->only(['edit', 'update']);
      
    }
    public function edit()
    {
        $about = AboutUs::first();
        return view('admin.about_us.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutUs::first();

        // Validate dữ liệu
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'mission_title' => 'nullable|string|max:255',
            'mission' => 'nullable|string',
            'vision_title' => 'nullable|string|max:255',
            'vision' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'active' => 'required|boolean',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, hoặc svg.',
            'active.required' => 'Trạng thái hoạt động là bắt buộc.',
            'active.boolean' => 'Trạng thái hoạt động không hợp lệ.',
        ]);


        // Nếu có ảnh mới
        if ($request->hasFile('image')) {
            if (!empty($about->image) && file_exists(public_path($about->image))) {
                unlink(public_path($about->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/about_us'), $imageName);
            $validated['image'] = 'uploads/about_us/' . $imageName;
        }


        $about->update($validated);

        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }
}