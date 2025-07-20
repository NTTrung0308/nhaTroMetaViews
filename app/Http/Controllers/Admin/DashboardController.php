<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use App\Models\NhaTros;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function index(){
      $user = Auth::user();
        
        // Chỉ lấy danh sách nhà trọ nếu user có quyền xem toàn bộ,
        // ngược lại, truyền một collection rỗng để view không bị lỗi.
        $nhaTros = $user->can('Xem toàn bộ thống kê') ? NhaTros::orderBy('ten_toa_nha')->get() : collect();
    return view('admin.dashboard.index', compact('nhaTros'));
   }
   /**
     * Cung cấp dữ liệu thống kê cho dashboard.
     * Logic phân quyền được xử lý tại đây.
     */
       /**
     * Lấy dữ liệu thống kê cho dashboard (API endpoint).
     * Đã được nâng cấp để xử lý các bộ lọc.
     */
    public function getStats(Request $request)
    {
        $user = auth()->user();

        // 1. TẠO CÂU TRUY VẤN CƠ SỞ (BASE QUERY)
        $baseHoaDonQuery = HoaDon::query();

        // 2. ÁP DỤNG BỘ LỌC PHÂN QUYỀN
        if ($user->cannot('Xem toàn bộ thống kê')) {
            $baseHoaDonQuery->where('user_id', $user->id);
        }

        // 3. ÁP DỤNG BỘ LỌC TỪ REQUEST
        // Chỉ áp dụng các bộ lọc này nếu người dùng là admin/quản lý
        if ($user->can('Xem toàn bộ thống kê')) {
            if ($request->filled('nha_tro_id')) {
                $baseHoaDonQuery->where('nha_tro_id', $request->nha_tro_id);
            }
            if ($request->filled('room_id')) {
                $baseHoaDonQuery->where('room_id', $request->room_id);
            }
        }
        // Bộ lọc tháng/năm áp dụng cho tất cả mọi người
        if ($request->filled('thang')) {
            $baseHoaDonQuery->where('thang', $request->thang);
        }
        if ($request->filled('nam')) {
            $baseHoaDonQuery->where('nam', $request->nam);
        }

        // --- TÍNH TOÁN CÁC CHỈ SỐ BẰNG CÁCH CLONE TRUY VẤN CƠ SỞ ---

        // 4. TÍNH TOÁN CÁC KPI CARDS
        // Doanh thu đã thanh toán dựa trên các hóa đơn đã được lọc
        $doanhThuDaThanhToan = (clone $baseHoaDonQuery)
            ->where('trang_thai', 'da_thanh_toan')
            ->sum('da_thanh_toan');

        $tongNoPhaiThu = (clone $baseHoaDonQuery)
            ->whereIn('trang_thai', ['chua_thanh_toan', 'qua_han'])
            ->sum('con_no');

        // Đếm số phòng duy nhất có trong các hóa đơn đã lọc
        $soPhongCoHoaDon = (clone $baseHoaDonQuery)
             ->distinct('room_id')
             ->count('room_id');

        $soHoaDonQuaHan = (clone $baseHoaDonQuery)
            ->where('trang_thai', 'qua_han')
            ->count();

        // 5. DỮ LIỆU BIỂU ĐỒ DOANH THU (LINH HOẠT THEO BỘ LỌC)
        $revenueQuery = (clone $baseHoaDonQuery)
            ->where('trang_thai', 'da_thanh_toan')
            ->select(
                DB::raw('nam as year'),
                DB::raw('thang as month'),
                DB::raw('SUM(da_thanh_toan) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')->orderBy('month', 'asc');
        
        // Nếu không có bộ lọc năm, mặc định lấy 12 tháng gần nhất
        if (!$request->filled('nam')) {
             $revenueQuery->where('ngay_tao_hoa_don', '>=', now()->subMonths(11)->startOfMonth());
        }
        
        $revenueData = $revenueQuery->get();
        $revenueLabels = $revenueData->map(fn($item) => "T{$item->month}/{$item->year}");
        $revenueValues = $revenueData->pluck('total');

        // 6. DỮ LIỆU BIỂU ĐỒ TRẠNG THÁI HÓA ĐƠN
        $statusData = (clone $baseHoaDonQuery)
            ->select('trang_thai', DB::raw('count(*) as count'))
            ->groupBy('trang_thai')
            ->pluck('count', 'trang_thai');

        $statusLabels = ['Chưa thanh toán', 'Đã thanh toán', 'Quá hạn', 'Đã hủy'];
        $statusKeys = ['chua_thanh_toan', 'da_thanh_toan', 'qua_han', 'da_huy'];
        $statusChartValues = collect($statusKeys)->map(fn ($key) => $statusData->get($key, 0));

        // 7. TRẢ VỀ JSON HOÀN CHỈNH
        return response()->json([
            'kpi' => [
                'doanhThuThangNay' => $doanhThuDaThanhToan,
                'tongNoPhaiThu' => $tongNoPhaiThu,
                'soPhongDangThue' => $soPhongCoHoaDon, // Sửa tên biến cho rõ nghĩa
                'soHoaDonQuaHan' => $soHoaDonQuaHan,
            ],
            'revenueChart' => ['labels' => $revenueLabels, 'data' => $revenueValues],
            'statusChart' => ['labels' => $statusLabels, 'data' => $statusChartValues]
        ]);
    }

    /**
     * Lấy danh sách phòng theo nhà trọ (API endpoint cho bộ lọc động).
     */
    public function getRoomsByNhaTro($nhaTroId)
    {
        $rooms = Rooms::where('nha_tro_id', $nhaTroId)
            ->orderBy('ten_phong')
            ->get();
        return response()->json($rooms);
    }
}
