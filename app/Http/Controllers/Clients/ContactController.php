<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\LienHe;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
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
    public function storecotact(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'ten' => 'required|string|max:255',
            'so_dien_thoai' => ['required', 'string', 'regex:/^(0[0-9]{9})$/'], // Regex cho SĐT 10 số của VN
            'email' => 'required|email|max:255',
            'noi_dung' => 'required|string', // 'message' là tên từ request
        ]);

        // Nếu validation thất bại, Laravel sẽ tự động trả về response 422
        // với cấu trúc lỗi mà JS phía client đã được viết để xử lý.
        // Tuy nhiên, chúng ta có thể tự bắt lỗi để log hoặc tùy chỉnh.
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Lưu dữ liệu vào database
            LienHe::create([
                'ten'    => $request->input('ten'),
                'so_dien_thoai'   => $request->input('so_dien_thoai'),
                'email'   => $request->input('email'),
                'noi_dung' => $request->input('noi_dung'), // Ánh xạ 'message' từ form vào cột 'content'
            ]);

            // 3. Trả về response thành công
            return response()->json([
                'success' => true,
                'message' => 'Yêu cầu của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ lại sớm.'
            ]);

        } catch (\Exception $e) {
            // Ghi lại lỗi để debug
            \Log::error('Lỗi khi lưu liên hệ: ' . $e->getMessage());

            // 4. Trả về response lỗi chung nếu có vấn đề (VD: lỗi kết nối DB)
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra phía máy chủ. Vui lòng thử lại sau.'
            ], 500); // 500 Internal Server Error
        }
    }
}
