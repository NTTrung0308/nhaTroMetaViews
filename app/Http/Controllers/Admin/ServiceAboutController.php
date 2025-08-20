<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\ServiceAbout;
use Illuminate\Http\Request;

class ServiceAboutController extends Controller
{
     public function __construct()
    {
        $this->middleware('can:Xem dịch vụ về chúng tôi')->only(['index']);
        $this->middleware('can:Thêm dịch vụ về chúng tôi')->only(['create', 'store']);
        $this->middleware('can:Sửa dịch vụ về chúng tôi')->only(['edit', 'update']);
        $this->middleware('can:Xóa dịch vụ về chúng tôi')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $query = ServiceAbout::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $serviceAbouts = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.service_about_home.index', compact('serviceAbouts'));
    }

    // Form tạo
    public function create()
    {
        return view('admin.service_about_home.create');
    }

    // Lưu mới
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $data = $request->only(['title', 'description', 'content']);
 $data['show_on_home'] = $request->has('show_on_home');
        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/service_abouts'), $fileName);
            $data['image'] = 'uploads/service_abouts/' . $fileName;
        }
        LogHelper::ghi(
            'Vào form thêm dịch vụ ngoài trang chủ ' . $request->title,
            'dịch vụ ngoài trang chủ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã vào thêm dịch vụ ngoài trang chủ trong quản trị viên'
        );
        ServiceAbout::create($data);

        return redirect()->route('admin.service_about_home.index')->with('success', 'Thêm thành công');
    }

    // Form sửa
    public function edit($id)
    {
        $serviceAbout = ServiceAbout::findOrFail($id);
        return view('admin.service_about_home.edit', compact('serviceAbout'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $item = ServiceAbout::findOrFail($id);

        $data = $request->only(['title', 'description', 'content']);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if (!empty($item->image) && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
            }

            $file     = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/service_abouts'), $fileName);
            $data['image'] = 'uploads/service_abouts/' . $fileName;
        }

        LogHelper::ghi(
            'Vào form sửa dịch vụ ngoài trang chủ ' . $item->title,
            'dịch vụ ngoài trang chủ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã vào sửa dịch vụ ngoài trang chủ trong quản trị viên'
        );
        $data['show_on_home'] = $request->has('show_on_home');
        $item->update($data);

        return redirect()->route('admin.service_about_home.index')->with('success', 'Cập nhật thành công');
    }

    // Xóa
    public function destroy($id)
    {
        $item = ServiceAbout::findOrFail($id);

        // Xóa ảnh
        if (!empty($item->image) && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }
        LogHelper::ghi(
            'Vào Xóa dịch vụ ngoài trang chủ ' . $item->title,
            'dịch vụ ngoài trang chủ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã vào Xóa dịch vụ ngoài trang chủ trong quản trị viên'
        );
        $item->delete();

        return redirect()->route('admin.service_about_home.index')->with('success', 'Xóa thành công');
    }
}