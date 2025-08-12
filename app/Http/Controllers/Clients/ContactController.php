<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\LienHe;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     public function index(){
        return view('users.contact.index');
     }
        public function store(Request $request)
    {
        $request->validate([
            'ten'           => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'so_dien_thoai' => 'required|regex:/^[0-9]{9,11}$/',
            'noi_dung'      => 'required|string',
        ], [
            'ten.required'           => 'Vui lòng nhập họ và tên.',
            'ten.string'             => 'Họ và tên phải là chuỗi ký tự.',
            'ten.max'                => 'Họ và tên không được vượt quá 255 ký tự.',
            
            'email.required'         => 'Vui lòng nhập địa chỉ email.',
            'email.email'            => 'Email không đúng định dạng.',
            'email.max'              => 'Email không được vượt quá 255 ký tự.',

            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
            'so_dien_thoai.regex'    => 'Số điện thoại phải từ 9 đến 11 số.',

            'noi_dung.required'      => 'Vui lòng nhập nội dung liên hệ.',
            'noi_dung.string'        => 'Nội dung liên hệ phải là văn bản.',
        ]);

        $data = $request->only(['ten', 'email', 'so_dien_thoai', 'noi_dung']);
        LienHe::create($data);
        return redirect()->route('contact.users.index')->with('success', 'Chúng tôi sẽ liên hệ lại với bạn sớm nhất.');
    }
}
