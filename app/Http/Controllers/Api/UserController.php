<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // << Quan trọng: Thêm dòng này
class UserController extends Controller
{
    // * Lấy thông tin của người dùng đã xác thực.
    //  */
   public function profile(Request $request)
    {
        $user = $request->user();
        $user->load('phuongTiens');
        return new UserResource($user);
    }

    /**
     * Cập nhật thông tin của người dùng đã xác thực.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu gửi lên
        $validator = Validator::make($request->all(), [
            'name'          => 'nullable|string|max:255',
            'phone'         => 'nullable|string|max:11',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Thêm max size
            'birthday'      => 'nullable|date_format:Y-m-d', // Định dạng ngày cụ thể
            'cmnd'          => 'nullable|string|max:20',
            'ho_chieu'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cmt_mat_truoc' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cmt_mat_sau'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'gioi_tinh'     => 'nullable|string',
            'ngay_cap_cmnd' => 'nullable|date_format:Y-m-d',
            'noi_cap_cmnd'  => 'nullable|string|max:255',
            'thanh_pho'     => 'nullable|string|max:255',
            'huyen'         => 'nullable|string|max:255',
            'xa'            => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'stk'           => 'nullable|string|max:50',
            'ngan_hang'     => 'nullable|string|max:255',
            'nghe_nghiep'   => 'nullable|string|max:255',
            'noi_lam_viec'  => 'nullable|string|max:255',
            'note'          => 'nullable|string',
            'facebook'      => 'nullable|string|max:255',
            'zalo'          => 'nullable|string|max:255',
            'instar'        => 'nullable|string|max:255',
            'twitter'       => 'nullable|string|max:255',
            'linkdin'       => 'nullable|string|max:255',
        ]);

        // Nếu validate thất bại, trả về lỗi 422
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Lấy tất cả dữ liệu đã được validate
       $dataToUpdate = $request->except(['avatar', 'ho_chieu', 'cmt_mat_truoc', 'cmt_mat_sau']);

        // Hàm trợ giúp để xử lý upload file, y hệt logic của bạn
        $handleFileUpload = function ($fileKey) use ($request, $user) {
            if ($request->hasFile($fileKey)) {
                $destinationPath = 'uploads/' . $fileKey; // Ví dụ: public/uploads/avatar

                // 1. Xóa file cũ nếu tồn tại
                $oldFilePath = $user->$fileKey;
                if ($oldFilePath && File::exists(public_path($oldFilePath))) {
                    File::delete(public_path($oldFilePath));
                }

                // 2. Upload file mới
                $file = $request->file($fileKey);
                // Tạo tên file mới để tránh trùng lặp và các ký tự đặc biệt
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($destinationPath), $fileName);
                
                // 3. Trả về đường dẫn mới để lưu vào database
                return $destinationPath . '/' . $fileName;
            }
            // Nếu không có file mới, giữ lại đường dẫn cũ
            return $user->$fileKey;
        };
        // Xử lý upload cho từng file ảnh
     $dataToUpdate['avatar'] = $handleFileUpload('avatar');
        $dataToUpdate['ho_chieu'] = $handleFileUpload('ho_chieu');
        $dataToUpdate['cmt_mat_truoc'] = $handleFileUpload('cmt_mat_truoc');
        $dataToUpdate['cmt_mat_sau'] = $handleFileUpload('cmt_mat_sau');


        // Cập nhật thông tin người dùng
        $user->update($dataToUpdate);

        // Trả về response thành công cùng với dữ liệu user đã được cập nhật
        return response()->json([
            'message' => 'Cập nhật thông tin thành công!',
            'user' => new UserResource($user->fresh()) // Dùng fresh() để lấy dữ liệu mới nhất
        ], 200);
}
}
