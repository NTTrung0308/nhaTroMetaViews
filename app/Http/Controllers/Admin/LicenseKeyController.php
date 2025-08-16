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
        ]);

        LicenseKey::create([
            'key' => Str::random(32),
            'max_rooms' => $request->max_rooms,
        ]);

        return redirect()->route('admin.license.store')->with('success', 'Tạo key thành công!');
    }
}
