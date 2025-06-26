<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request){
        if (auth()->check()) {
           $user = auth()->user();
           return view('admin.profile.index', compact('user'));
        } else {
           return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập');
        }
        
    }
}
