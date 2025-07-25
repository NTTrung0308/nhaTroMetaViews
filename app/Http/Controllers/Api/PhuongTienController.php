<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhuongTien; // Chỉ cần dùng Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhuongTienController extends Controller
{
       /**
     * Lấy danh sách phương tiện của người dùng hiện tại.
     * Trả về dữ liệu thô, không qua Resource.
     */
    public function index()
    {
        // Lấy dữ liệu và trả về trực tiếp. Laravel sẽ tự động chuyển nó thành JSON.
        return Auth::user()->phuongTiens()->latest()->get();
    }

    /**
     * Thêm một phương tiện mới.
     * Logic validation và xử lý nằm ngay trong phương thức.
     */
    public function store(Request $request)
    {
        $loaiPhuongTienEnum = ['o_to', 'o_to_dien', 'xe_may', 'xe_may_dien', 'xe_dap', 'xe_dap_dien'];

        // 1. Validation trực tiếp trong controller
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bien_so' => 'required|string|max:20|unique:phuong_tiens,bien_so',
            'loai_phuong_tien' => ['required', Rule::in($loaiPhuongTienEnum)],
            'ten_chu_xe' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Tạo bản ghi
        $phuongTien = Auth::user()->phuongTiens()->create($validator->validated());

        // 3. Trả về dữ liệu thô của bản ghi vừa tạo
        return response()->json($phuongTien, 201); // 201 Created
    }

    /**
     * Lấy thông tin chi tiết một phương tiện.
     */
    public function show($id)
    {
        $phuongTien = PhuongTien::find($id);

        if (!$phuongTien) {
            return response()->json(['message' => 'Không tìm thấy phương tiện.'], 404);
        }

        // Kiểm tra quyền sở hữu thủ công
        if ($phuongTien->user_id !== Auth::id()) {
            return response()->json(['message' => 'Bạn không có quyền xem phương tiện này.'], 403);
        }

        return response()->json($phuongTien);
    }

    /**
     * Cập nhật thông tin phương tiện.
     */
    public function update(Request $request, $id)
    {
        $phuongTien = PhuongTien::find($id);

        if (!$phuongTien) {
            return response()->json(['message' => 'Không tìm thấy phương tiện.'], 404);
        }

        // Kiểm tra quyền sở hữu thủ công
        if ($phuongTien->user_id !== Auth::id()) {
            return response()->json(['message' => 'Bạn không có quyền cập nhật phương tiện này.'], 403);
        }

        $loaiPhuongTienEnum = ['o_to', 'o_to_dien', 'xe_may', 'xe_may_dien', 'xe_dap', 'xe_dap_dien'];

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'bien_so' => ['sometimes', 'string', 'max:20', Rule::unique('phuong_tiens')->ignore($phuongTien->id)],
            'loai_phuong_tien' => ['sometimes', Rule::in($loaiPhuongTienEnum)],
            'ten_chu_xe' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $phuongTien->update($validator->validated());

        return response()->json($phuongTien);
    }

    /**
     * Xóa một phương tiện.
     */
    public function destroy($id)
    {
        $phuongTien = PhuongTien::find($id);

        if (!$phuongTien) {
            return response()->json(['message' => 'Không tìm thấy phương tiện.'], 404);
        }

        // Kiểm tra quyền sở hữu thủ công
        if ($phuongTien->user_id !== Auth::id()) {
            return response()->json(['message' => 'Bạn không có quyền xóa phương tiện này.'], 403);
        }

        $phuongTien->delete();

        return response()->json(['message' => 'Đã xóa phương tiện thành công.'], 200);
    }
    }
