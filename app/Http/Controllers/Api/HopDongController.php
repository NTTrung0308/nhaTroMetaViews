<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HopDongThuePhong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class HopDongController extends Controller
{
     public function index()
    {
        // 1. Lấy user đã được xác thực qua API (thông qua token)
        $user = Auth::user();

        // 2. Khởi tạo query builder với các mối quan hệ cần tải
        // Eager loading để tránh vấn đề N+1 query
        $query = HopDongThuePhong::with(['user', 'room', 'nhaTro']);

        // 3. Áp dụng điều kiện lọc dựa trên quyền của user
        if ($user->can('nguoi-thue-tro')) {
            // Nếu user có quyền 'nguoi-thue-tro', chỉ lấy hợp đồng của chính họ
            $query->where('user_id', $user->id);
        }
        // Nếu không (là admin hoặc quyền khác), không cần thêm điều kiện 'where',
        // do đó query sẽ lấy tất cả hợp đồng.

        // 4. Sắp xếp kết quả mới nhất lên đầu và thực hiện phân trang
        $hopDongs = $query->latest()->paginate(10);

        // 5. Trả về kết quả dưới dạng JSON theo chuẩn API
        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách hợp đồng thành công.',
            'data' => $hopDongs
        ]);
    }
      public function show(HopDongThuePhong $hopDong)
    {
        // Lấy user đã được xác thực
        $user = Auth::user();

        // **Kiểm tra quyền truy cập (Authorization)**
        // Nếu user là 'nguoi-thue-tro' VÀ ID của họ không khớp với user_id trên hợp đồng
        if ($user->can('nguoi-thue-tro') && $hopDong->user_id !== $user->id) {
            // Trả về lỗi 403 Forbidden (Cấm truy cập)
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xem hợp đồng này.',
            ], 403);
        }

        // Nếu qua được vòng kiểm tra, tức là user có quyền
        // Load thêm các thông tin liên quan (user, room, nhaTro)
        $hopDong->load(['user', 'room', 'nhaTro']);

        // Trả về dữ liệu chi tiết của hợp đồng
        return response()->json([
            'success' => true,
            'message' => 'Lấy chi tiết hợp đồng thành công.',
            'data' => $hopDong
        ]);
    }
}
