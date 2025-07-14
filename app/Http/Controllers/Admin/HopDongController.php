<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\HopDongThuePhong;
use App\Models\NhaTros;
use App\Models\Rooms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HopDongController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem hợp đồng')->only(['index']);
        $this->middleware('can:Thêm hợp đồng')->only(['create', 'store']);
        $this->middleware('can:Sửa hợp đồng')->only(['edit', 'update']);
        $this->middleware('can:Xóa hợp đồng')->only(['destroy']);
    }
    public function index()
{
    // Lấy user hiện tại
    $user = auth()->user();

    // Nếu user có quyền 'nguoi-thue-tro' => chỉ hiển thị hợp đồng của chính họ
    if ($user->can('nguoi-thue-tro')) {
        $hopDongs = HopDongThuePhong::with(['user', 'room', 'nhaTro'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);
    } else {
        // Nếu không thì là admin hoặc người có quyền cao hơn => xem tất cả
        $hopDongs = HopDongThuePhong::with(['user', 'room', 'nhaTro'])
            ->latest()
            ->paginate(10);
    }

    return view('admin.hop_dong.index', compact('hopDongs'));
}

    public function create()
    {
        $users = User::role('nguoi-thue-tro')->get();
        $nhaTros = NhaTros::all();
        return view('admin.hop_dong.form', [
            'hopDong' => null,
            'users' => $users,
            'nhaTros' => $nhaTros,
            'rooms' => [], // sẽ đổ qua JS khi chọn nhà trọ
        ]);
    }

    public function store(Request $request)
    {
          // Gộp validation cho cả 2 phương thức store và update
        $validatedData = $this->validateHopDong($request);
        
        // Thêm dữ liệu vào mảng validated
        $validatedData['active'] = $request->has('active');

        // Tạo hợp đồng
        $hopDong = HopDongThuePhong::create($validatedData);

        // $hopDong = HopDongThuePhong::create([
        //     'user_id' => $request->user_id,
        //     'room_id' => $request->room_id,
        //     'nha_tro_id' => $request->nha_tro_id,
        //     'ngay_bat_dau' => $request->ngay_bat_dau,
        //     'ngay_het_han' => $request->ngay_het_han,
        //     'gia_thue' => $request->gia_thue,
        //     'tien_coc' => $request->tien_coc,
        //     'ghi_chu' => $request->ghi_chu,
        //     'active' => $request->has('active'),
        // ]);
      $room = Rooms::findOrFail($hopDong->room_id);

        // Cập nhật trạng thái phòng
        $room->update([
            'da_thue' => true,
            'status' => 'da_thue',
        ]);
        LogHelper::ghi(
            'Thêm hợp đồng thuê phòng',
            'Hợp đồng',
            'Người dùng "' . Auth::user()->name . '" đã tạo hợp đồng cho phòng ' . $room->ma_phong .
                ' (ID phòng: ' . $room->id . ') thuộc tòa nhà ID ' . $request->nha_tro_id .
                ' với người thuê ID ' . $request->user_id
        );

        return redirect()->route('admin.hop_dong.index')->with('success', 'Tạo hợp đồng thành công');
    }

    public function edit(HopDongThuePhong $hopDong)
    {
        $users = User::role('nguoi-thue-tro')->get();
        $nhaTros = NhaTros::all();
        $rooms = Rooms::where('nha_tro_id', $hopDong->nha_tro_id)->get();

        return view('admin.hop_dong.form', compact('hopDong', 'users', 'nhaTros', 'rooms'));
    }

    public function update(Request $request, HopDongThuePhong $hopDong)
    {
         // Sử dụng lại hàm validate
        $validatedData = $this->validateHopDong($request);
        
        $validatedData['active'] = $request->has('active');

        // Cập nhật hợp đồng
        $hopDong->update($validatedData);

        // $hopDong->update([
        //     'user_id' => $request->user_id,
        //     'room_id' => $request->room_id,
        //     'nha_tro_id' => $request->nha_tro_id,
        //     'ngay_bat_dau' => $request->ngay_bat_dau,
        //     'ngay_het_han' => $request->ngay_het_han,
        //     'gia_thue' => $request->gia_thue,
        //     'tien_coc' => $request->tien_coc,
        //     'ghi_chu' => $request->ghi_chu,
        //     'active' => $request->has('active'),
        // ]);

        // Cập nhật lại trạng thái phòng
        $hopDong->room->update([
            'da_thue' => true,
            'status' => 'da_thue',
        ]);
        // Lấy thêm thông tin để log
        $room     = Rooms::find($request->room_id);
        $nhaTro   = NhaTros::find($request->nha_tro_id);
        $userThue = User::find($request->user_id);
        $admin    = Auth::user();

        // Ghi log
        LogHelper::ghi(
            'Cập nhật hợp đồng thuê phòng',
            'Hợp đồng',
            'Người dùng "' . $admin->name . '" (ID: ' . $admin->id . ') đã cập nhật hợp đồng cho phòng ' . ($room->ma_phong ?? 'N/A') .
                ' thuộc tòa nhà ' . ($nhaTro->ten_toa_nha ?? 'N/A') . ' với người thuê "' . ($userThue->name ?? 'N/A') .
                '" (ID: ' . $userThue->id . ').'
        );
        return redirect()->route('admin.hop_dong.index')->with('success', 'Cập nhật hợp đồng thành công');
    }

    public function destroy(HopDongThuePhong $hopDong)
    {
        $room     = $hopDong->room;
        $nhaTro   = $hopDong->nhaTro;
        $userThue = $hopDong->user;
        $admin    = Auth::user();

        // Xóa hợp đồng
        $hopDong->delete();

        // Trả phòng về trạng thái trống
        $room->update([
            'da_thue' => false,
            'status'  => 'trong',
        ]);

        // Ghi log
        LogHelper::ghi(
            'Xóa hợp đồng thuê phòng',
            'Hợp đồng',
            'Người dùng "' . $admin->name . '" (ID: ' . $admin->id . ') đã xóa hợp đồng phòng "' . ($room->ma_phong ?? 'N/A') .
                '" thuộc tòa nhà "' . ($nhaTro->ten_toa_nha ?? 'N/A') . '", người thuê là "' . ($userThue->name ?? 'N/A') .
                '" (ID: ' . $userThue->id . ').'
        );

        return redirect()->route('admin.hop_dong.index')->with('success', 'Xoá hợp đồng thành công');
    }
       private function validateHopDong(Request $request)
    {
        return $request->validate([
            // --- Thông tin chung ---
            'tenant_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'nha_tro_id' => 'required|exists:nha_tros,id',

            // --- Thông tin bên cho thuê ---
            'landlord_ho_ten' => 'required|string|max:255',
            'landlord_sdt' => 'required|string|max:15',
            'landlord_cccd' => 'required|string|size:12',
            'landlord_cccd_ngay_cap' => 'required|date',
            'landlord_cccd_noi_cap' => 'required|string|max:255',
            'landlord_hktt' => 'required|string',

            // --- Chi tiết hợp đồng ---
            'ngay_bat_dau' => 'required|date',
            'ngay_het_han' => 'nullable|date|after_or_equal:ngay_bat_dau',
            'gia_thue' => 'required|integer|min:0',
            'tien_coc' => 'nullable|integer|min:0',
            'ghi_chu' => 'nullable|string',
        ], [
            // Custom messages
            'tenant_id.required' => 'Vui lòng chọn người thuê.',
            'landlord_ho_ten.required' => 'Vui lòng nhập họ tên người cho thuê.',
            'landlord_cccd.size' => 'Số CCCD phải có đúng 12 ký tự.',
            'ngay_het_han.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu.',
            // Thêm các message khác nếu cần
        ]);
    }
}
