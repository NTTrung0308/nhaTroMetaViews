<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalKeyController extends Controller
{
    public function showForm()
    {
        return view('admin.license.internal_key_form');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'internal_key' => 'required|string',
        ]);

        if ($request->input('internal_key') === env('INTERNAL_LICENSE_KEY')) {
            $request->session()->put('internal_key_verified', true);
            return redirect()->route('license.create')->with('success', 'Xác thực thành công!');
        }

        return back()->withErrors(['internal_key' => 'Sai key nội bộ!']);
    }
}
