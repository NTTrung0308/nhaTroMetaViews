<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // 2. Thử xác thực người dùng
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Sai thông tin đăng nhập (email hoặc mật khẩu).',
            ], 401); // 401 Unauthorized
        }

        // 3. Lấy thông tin user đã được xác thực
        $user = Auth::user();

        // 4. Tạo token cho user
        // 'api-token' là tên của token, bạn có thể đặt tên bất kỳ
        $token = $user->createToken('api-token')->plainTextToken;

        // 5. Trả về thông tin user và token
        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thành công.',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
     public function logout(Request $request)
    {
        // Lấy người dùng đã được xác thực qua token
        $user = $request->user();

        // Xóa token đang được sử dụng để xác thực request này
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đã đăng xuất thành công.'
        ], 200);
    }
}
