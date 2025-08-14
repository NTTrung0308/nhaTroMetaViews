<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|max:255',
            'description' => 'nullable|max:255',
            'facebook'   => 'nullable|url',
            'google'     => 'nullable|url',
            'instagram'  => 'nullable|url',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ], [
            'name.required' => 'Tên không được để trống.',
            'facebook.url'  => 'Facebook phải là một URL hợp lệ.',
            'google.url'    => 'Google phải là một URL hợp lệ.',
            'instagram.url' => 'Instagram phải là một URL hợp lệ.',
        ]);
         $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/tin_tuc'), $imageName);
            $data['image'] = 'uploads/tin_tuc/' . $imageName;
        }
Member::create($data);

        return redirect()->route('admin.members.index')->with('success', 'Thêm thành viên thành công.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'       => 'required|max:255',
            'description' => 'nullable|max:255',
            'facebook'   => 'nullable|url',
            'google'     => 'nullable|url',
            'instagram'  => 'nullable|url',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ], [
            'name.required' => 'Tên không được để trống.',
            'facebook.url'  => 'Facebook phải là một URL hợp lệ.',
            'google.url'    => 'Google phải là một URL hợp lệ.',
            'instagram.url' => 'Instagram phải là một URL hợp lệ.',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($member->image && file_exists(public_path($member->image))) {
                unlink(public_path($member->image));
            }
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/members'), $fileName);
            $data['image'] = 'uploads/members/' . $fileName;
        }
         $member->update($data);

        return redirect()->route('admin.members.index')->with('success', 'Cập nhật thành viên thành công.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Xóa thành viên thành công.');
    }
}
