<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenseKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class LicenseKeyController extends Controller
{
    /**
     * Trang tạo key mới (chỉ vào nếu đã xác thực internal key)
     */
    public function index()
{
    $licenseKeys = LicenseKey::with('user')->latest()->paginate(10);
    return view('admin.license.index', compact('licenseKeys'));
}

    public function create()
    {
        if (!session('internal_key_verified')) {
            return redirect()->route('licensekeys.internal_form')
                ->withErrors(['auth' => 'Bạn cần nhập internal key trước']);
        }

        return view('admin.license.create');
    }

    /**
     * Lưu key mới
     */
    public function store(Request $request)
    {
        if (!session('internal_key_verified')) {
            return redirect()->route('licensekeys.internal_form')
                ->withErrors(['auth' => 'Bạn cần nhập internal key trước']);
        }

        $request->validate([
            'max_rooms' => 'required|integer|min:0',
        ],[
            'max_rooms.required' => 'Số lượng phòng tối đa là bắt buộc.',
            'max_rooms.integer' => 'Số lượng phòng tối đa phải là một số nguyên.',
            'max_rooms.min' => 'Số lượng phòng tối đa phải lớn hơn hoặc bằng 0.',
        ]);

        LicenseKey::create([
            'key' => Str::random(32),
            'max_rooms' => $request->max_rooms,
        ]);

        return redirect()->route('license.index')->with('success', 'Tạo key thành công!');
    }
}
