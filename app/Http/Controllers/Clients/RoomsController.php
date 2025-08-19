<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Rooms;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
     public function index(Request $request)
    {
    // Bắt đầu câu truy vấn với Eager Loading để tối ưu
        $query = Rooms::with('nhaTro')->where('status', 'trong'); // Chỉ tìm phòng chưa thuê

        // 1. Lọc theo từ khóa (tên phòng hoặc địa chỉ nhà trọ)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ten_phong', 'like', "%{$keyword}%")
                  ->orWhereHas('nhaTro', function ($subQuery) use ($keyword) {
                      $subQuery->where('dia_chi', 'like', "%{$keyword}%");
                  });
            });
        }

        // 2. Lọc theo Quận/Huyện (trong bảng nha_tros)
        if ($request->filled('district')) {
            $district = $request->district;
            $query->whereHas('nhaTro', function ($q) use ($district) {
                $q->where('quan', $district);
            });
        }

        // 3. Lọc theo khoảng giá
        if ($request->filled('price')) {
            switch ($request->price) {
                case '1': // Dưới 3 triệu
                    $query->where('gia_thue', '<', 3000000);
                    break;
                case '2': // 3-5 triệu
                    $query->whereBetween('gia_thue', [3000000, 5000000]);
                    break;
                case '3': // 5-7 triệu
                    $query->whereBetween('gia_thue', [5000000, 7000000]);
                    break;
                case '4': // Trên 7 triệu
                    $query->where('gia_thue', '>', 7000000);
                    break;
            }
        }

        // 4. Lọc theo ban công
        if ($request->filled('balcony')) {
            $query->where('bancong', $request->balcony);
        }

        // 5. Lọc theo diện tích
        if ($request->filled('area')) {
            switch ($request->area) {
                case '20-30':
                    $query->whereBetween('dien_tich', [20, 30]);
                    break;
                case '30-50':
                    $query->whereBetween('dien_tich', [30, 50]);
                    break;
                case '50-70':
                    $query->whereBetween('dien_tich', [50, 70]);
                    break;
                case '70+':
                    $query->where('dien_tich', '>', 70);
                    break;
            }
        }

        // Sắp xếp và phân trang
        $rooms = $query->orderBy('created_at', 'desc')->paginate(2);

        // Trả về view cùng với dữ liệu phòng đã lọc
        return view('users.rooms.index', compact('rooms'));
    }
    public function detail($id)
    {
        // Tìm phòng theo ID và eager load nhà trọ
        $room = Rooms::with('nhaTro')->findOrFail($id);
 $relatedRooms = Rooms::where('id', '!=', $id)
        ->inRandomOrder()
        ->limit(6)
        ->get();
        // Trả về view chi tiết phòng
        return view('users.rooms.detail', compact('room','relatedRooms'));
    }
    
}
