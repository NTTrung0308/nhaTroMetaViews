<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HoaDonResource;
use App\Models\HoaDon;   // <-- SỬA 1: Thêm use cho Model HoaDon
use App\Models\NhaTro;   // <-- SỬA 2: Sửa tên Model thành số ít (NhaTro)
use App\Models\NhaTros;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // <-- NÊN DÙNG: Type-hint rõ ràng cho response JSON
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HoaDonController extends Controller
{
    /**
     * Hiển thị danh sách hóa đơn.
     *
     * @param Request $request
     * @return JsonResponse // <-- SỬA 3: Thay đổi type-hint để phù hợp với response()
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // 1. Bắt đầu với câu truy vấn cơ sở
        $query = HoaDon::query()->with(['room.nhaTro', 'user']);

        // 2. Phân quyền và lọc dữ liệu (Logic của bạn đã đúng)
        if ($user->can('nguoi-thue-tro')) {
            $query->where('user_id', $user->id);
        } else {
            // Áp dụng các bộ lọc nếu có
            if ($request->filled('nha_tro_id')) {
                $query->where('nha_tro_id', $request->nha_tro_id);
            }
            if ($request->filled('room_id')) {
                $query->where('room_id', $request->room_id);
            }
            if ($request->filled('thang')) {
                $query->where('thang', $request->thang);
            }
            if ($request->filled('nam')) {
                $query->where('nam', $request->nam);
            }
            if ($request->filled('trang_thai')) {
                $query->where('trang_thai', $request->trang_thai);
            }
        }

        // 3. Lấy dữ liệu, sắp xếp và phân trang
        $perPage = $request->input('per_page', 15);
        $hoaDons = $query->latest()->paginate($perPage);

        // 4. Lấy dữ liệu cho các bộ lọc
        $filterData = [];
        if (!$user->can('nguoi-thue-tro')) {
            // Sửa NhaTros -> NhaTro
            $filterData['nha_tros'] = NhaTros::select('id', 'ten_toa_nha')->get();
        }
        $filterData['statuses'] = [
            ['value' => 'chua_thanh_toan', 'label' => 'Chưa thanh toán'],
            ['value' => 'da_thanh_toan', 'label' => 'Đã thanh toán'],
            ['value' => 'qua_han', 'label' => 'Quá hạn'],
            ['value' => 'da_huy', 'label' => 'Đã hủy'],
        ];

        // 5. Trả về response JSON hoàn chỉnh
        // SỬA 4: Đây là phần quan trọng nhất
        // Chúng ta sử dụng HoaDonResource::collection để biến đổi dữ liệu $hoaDons
        // và dùng ->additional() để thêm dữ liệu bộ lọc vào phần meta.
        $resourceCollection = HoaDonResource::collection($hoaDons)->additional([
            'meta' => [
                'filters' => $filterData
            ]
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách hóa đơn thành công.', // <-- SỬA 5: Message chính xác
            'data'    => $resourceCollection, // <-- Dữ liệu chính là collection đã biến đổi
        ]);
    }
}