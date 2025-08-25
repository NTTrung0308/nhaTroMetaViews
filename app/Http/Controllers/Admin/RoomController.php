<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\CongTo;
use App\Models\LicenseKey;
use App\Models\NhaTros;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
class RoomController extends Controller
{
    public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem phòng trọ')->only(['index']);
        $this->middleware('can:Thêm phòng trọ')->only(['create', 'store']);
        $this->middleware('can:Sửa phòng trọ')->only(['edit', 'update']);
        $this->middleware('can:Xóa phòng trọ')->only(['destroy']);
    }
    public function index(Request $request)
    {
        $query = Rooms::query()->with('nhaTro');

        if ($request->filled('nha_tro_id')) {
            $query->where('nha_tro_id', $request->nha_tro_id);
        }

        if ($request->filled('ten_phong')) {
            $query->where('ten_phong', 'like', '%' . $request->ten_phong . '%');
        }

        if ($request->filled('loai_phong')) {
            $query->where('loai_phong', $request->loai_phong);
        }

        if ($request->filled('status')) {
            if ($request->status === 'da_thue') {
                $query->where('da_thue', true);
            } elseif ($request->status === 'trong') {
                $query->where('da_thue', false);
            }
        }

        $rooms = $query->orderBy('created_at', 'desc')->paginate(10);

        // Lấy danh sách nhà trọ để đưa vào form select
        $nhaTros = NhaTros::all();
        LogHelper::ghi('Xem danh sách phòng trọ', 'Phòng Trọ', 'Xem danh sách phòng trọ trong quản trị viên');

        return view('admin.phong_tro.index', compact('rooms', 'nhaTros'));
    }

    public function create()
    {
        $nhaTros = NhaTros::all();
        LogHelper::ghi(
            'Vào form tạo phòng trọ',
            'Phòng Trọ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã vào form tạo phòng trọ trong quản trị viên'
        );
        return view('admin.phong_tro.create', compact('nhaTros'));
    }

    public function store(Request $request)
    {
            $user = auth()->user();
    // Lấy license key gán cho user
    $license = LicenseKey::where('key', $user->license_key)
        ->where('is_active', true)
        ->first();

    if (!$license) {
        return redirect()->back()->with('error', 'Bạn chưa được cấp license key để tạo phòng.');
    }

    if ($license->max_rooms <= 0) {
        return redirect()->back()->with('error', 'Bạn đã hết lượt tạo phòng.');
    }

        $validated = $request->validate([
            'nha_tro_id' => 'required|exists:nha_tros,id',
            'ten_phong' => 'required|string|max:255',
            'bancong' => 'required',
            'ma_phong' => 'nullable|string|max:255',
            'dien_tich' => 'nullable|integer|min:0',
            'so_khach' => 'nullable|integer|min:1',
            'loai_phong' => 'required|in:van_phong,can_ho,phong_cho_thue,khac',
            'gia_thue' => 'nullable|integer|min:0',
            'status' => 'required|string',
            'da_thue' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg',
            'ghi_chu' => 'nullable|string',
        ], [
            // nhà trọ
            'nha_tro_id.required' => 'Vui lòng chọn nhà trọ.',
            'bancong.required' => 'Vui lòng chọn nhà trọ.',
            'nha_tro_id.exists' => 'Nhà trọ được chọn không tồn tại.',

            // tên phòng
            'ten_phong.required' => 'Tên phòng không được để trống.',
            'ten_phong.string' => 'Tên phòng phải là chuỗi.',
            'ten_phong.max' => 'Tên phòng không được vượt quá 255 ký tự.',

            // mã phòng
            'ma_phong.string' => 'Mã phòng phải là chuỗi.',
            'ma_phong.max' => 'Mã phòng không được vượt quá 255 ký tự.',

            // diện tích
            'dien_tich.integer' => 'Diện tích phải là số nguyên.',
            'dien_tich.min' => 'Diện tích không được nhỏ hơn 0.',

            // số khách
            'so_khach.integer' => 'Số khách phải là số nguyên.',
            'so_khach.min' => 'Số khách tối thiểu là 1.',

            // loại phòng
            'loai_phong.required' => 'Vui lòng chọn loại phòng.',
            'loai_phong.in' => 'Loại phòng không hợp lệ.',

            // giá thuê
            'gia_thue.integer' => 'Giá thuê phải là số nguyên.',
            'gia_thue.min' => 'Giá thuê không được nhỏ hơn 0.',

            // trạng thái
            'status.required' => 'Vui lòng nhập trạng thái.',
            'status.string' => 'Trạng thái phải là chuỗi.',

            // ảnh
            'images.array' => 'Trường ảnh phải là mảng.',
            'images.*.image' => 'Ảnh không đúng định dạng.',
            'images.*.mimes' => 'Ảnh phải có định dạng jpeg, png hoặc jpg.',

            // ghi chú
            'ghi_chu.string' => 'Ghi chú phải là chuỗi.',
        ]);

        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
               $fileName = uniqid() . '_' . time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('rooms'), $fileName);
                $images[] = 'rooms/' . $fileName;
            }
        }
//  CongTo::create([
//             'nha_tro_id' => $validated->nha_tro_id,
//             'room_id' => $validated->room_id,
//             'loai' => 'dien',
//             'chi_so_dau' => $request->chi_so_dau,
//         ]);
        $validated['images'] = json_encode($images);
        $room = Rooms::create($validated);
         CongTo::create([
            'nha_tro_id' => $validated['nha_tro_id'],
            'room_id' => $room->id,
            'loai' => 'dien',
            'chi_so_dau' => 0,
        ]);
         CongTo::create([
            'nha_tro_id' => $validated['nha_tro_id'],
            'room_id' => $room->id,
            'loai' => 'nuoc',
            'chi_so_dau' => 0,
        ]);
           $license->decrement('max_rooms');
        LogHelper::ghi(
            'Thêm phòng trọ mới: ' . $room->ten_phong,
            'Phòng Trọ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã thêm phòng trọ mới "' . $room->ten_phong . '" thuộc tòa nhà ID ' . $room->nha_tro_id
        );
        return redirect()->route('rooms.index')->with('success', 'Thêm phòng thành công.');
    }

    public function edit(Rooms $room)
    {
        $nhaTros = NhaTros::all();
        LogHelper::ghi(
            'Vào form sửa phòng trọ: ' . $room->ten_phong,
            'Phòng Trọ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã vào form sửa phòng trọ "' . $room->ten_phong . '" (ID: ' . $room->id . ')'
        );
        return view('admin.phong_tro.edit', compact('room', 'nhaTros'));
    }

    public function update(Request $request, Rooms $room)
    {
        $validated = $request->validate([
            'nha_tro_id' => 'required|exists:nha_tros,id',
            'ten_phong' => 'required|string|max:255',
            'bancong' => 'required',
            'ma_phong' => 'nullable|string|max:255',
            'dien_tich' => 'nullable|integer|min:0',
            'so_khach' => 'nullable|integer|min:1',
            'loai_phong' => 'required|in:van_phong,can_ho,phong_cho_thue,khac',
            'gia_thue' => 'nullable|integer|min:0',
            'da_thue' => 'required|string',
            'status' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg',
            'ghi_chu' => 'nullable|string',
        ], [
            // nhà trọ
            'nha_tro_id.required' => 'Vui lòng chọn nhà trọ.',
            'bancong.required' => 'Vui lòng chọn ban coong.',
            'nha_tro_id.exists' => 'Nhà trọ được chọn không tồn tại.',

            // tên phòng
            'ten_phong.required' => 'Tên phòng là bắt buộc.',
            'ten_phong.string' => 'Tên phòng phải là chuỗi ký tự.',
            'ten_phong.max' => 'Tên phòng không được vượt quá 255 ký tự.',

            // mã phòng
            'ma_phong.string' => 'Mã phòng phải là chuỗi.',
            'ma_phong.max' => 'Mã phòng không được vượt quá 255 ký tự.',

            // diện tích
            'dien_tich.integer' => 'Diện tích phải là số nguyên.',
            'dien_tich.min' => 'Diện tích không được nhỏ hơn 0.',

            // số khách
            'so_khach.integer' => 'Số khách phải là số nguyên.',
            'so_khach.min' => 'Số khách tối thiểu là 1 người.',

            // loại phòng
            'loai_phong.required' => 'Vui lòng chọn loại phòng.',
            'loai_phong.in' => 'Loại phòng không hợp lệ.',

            // giá thuê
            'gia_thue.integer' => 'Giá thuê phải là số nguyên.',
            'gia_thue.min' => 'Giá thuê không được âm.',

            // trạng thái
            'status.required' => 'Vui lòng nhập trạng thái.',
            'status.string' => 'Trạng thái phải là chuỗi ký tự.',

            // ảnh
            'images.array' => 'Trường ảnh không hợp lệ.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh chỉ được chấp nhận các định dạng: jpeg, png, jpg.',


            // ghi chú
            'ghi_chu.string' => 'Ghi chú phải là chuỗi văn bản.',
        ]);


        // Lấy danh sách ảnh cũ từ DB
        $currentImages = json_decode($room->images ?? '[]', true);

        // Lấy danh sách ảnh người dùng muốn giữ lại từ form
        $keepImages = $request->input('existing_images', []);
        $keepImages = is_array($keepImages) ? $keepImages : [];

        // Tìm ảnh cần xóa (có trong DB nhưng không còn trong danh sách giữ lại)
        $deletedImages = array_diff($currentImages, $keepImages);

        foreach ($deletedImages as $imgPath) {
            $fullPath = public_path($imgPath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        // Bắt đầu với danh sách ảnh giữ lại
        $images = $keepImages;

        // Thêm ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img->isValid()) {
                      $fileName = uniqid() . '_' . time() . '_' . $img->getClientOriginalName();
                    $img->move(public_path('rooms'), $fileName);
                    $images[] = 'rooms/' . $fileName;
                }
            }
        }

        // Gán lại vào dữ liệu
        $validated['images'] = json_encode($images);



        // $images = $request->input('existing_images', []);
        // $images = is_array($images) ? $images : [];

        // if ($request->hasFile('images')) {
        //     foreach ($request->file('images') as $img) {
        //         if ($img->isValid()) {
        //             $fileName = time() . '_' . $img->getClientOriginalName();
        //             $img->move(public_path('rooms'), $fileName);
        //             $images[] = 'rooms/' . $fileName;
        //         }
        //     }
        // }
        // $validated['images'] = json_encode($images); // nếu cột là TEXT hoặc JSON

        $room->update($validated);
        // Ghi lại log chi tiết
        LogHelper::ghi(
            'Cập nhật phòng trọ: ' . $room->ten_phong . ' (ID: ' . $room->id . ')',
            'Phòng Trọ',
            'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã cập nhật phòng trọ "' . $room->ten_phong . '" (ID: ' . $room->id . ')'
        );

        return redirect()->route('rooms.index')->with('success', 'Cập nhật phòng thành công.');
    }

   public function destroy(Rooms $room)
{
    try {
        // Bắt đầu một transaction để đảm bảo tất cả các thao tác đều thành công hoặc không thành công cùng nhau.
        // Điều này rất quan trọng: nếu xóa file ảnh thất bại, việc hoàn lại lượt tạo phòng cũng sẽ bị hủy.
        DB::transaction(function () use ($room) {
            
            // --- PHẦN LOGIC HOÀN LẠI LƯỢT TẠO PHÒNG ---

            // 1. Lấy user_id của chủ sở hữu phòng thông qua mối quan hệ với nhà trọ.
            // Điều này đảm bảo chúng ta hoàn lại lượt cho đúng người, ngay cả khi admin là người thực hiện thao tác xóa.
            // Cú pháp `?->` (optional chaining) sẽ tránh lỗi nếu `$room->nhaTro` không tồn tại.
            $ownerId = $room->nhaTro?->user_id;

            if ($ownerId) {
                // 2. Tìm license key ĐANG HOẠT ĐỘNG của chủ sở hữu.
                // Việc chỉ tìm key 'is_active' là hợp lý, vì người dùng chỉ có thể tạo phòng bằng key đang hoạt động.
                $license = LicenseKey::where('user_id', $ownerId)
                                     ->where('is_active', true)
                                     ->first();

                // 3. Nếu tìm thấy license, cộng lại 1 lượt tạo phòng.
                if ($license) {
                    $license->increment('max_rooms');
                }
            } else {
                // Ghi log nếu không tìm thấy chủ sở hữu. Đây là trường hợp bất thường và cần được kiểm tra.
                Log::warning('Không thể hoàn lại lượt tạo phòng khi xóa phòng ID: ' . $room->id . ' vì không tìm thấy chủ sở hữu (nhaTro hoặc user_id không tồn tại).');
            }

            // --- GIỮ NGUYÊN LOGIC XÓA CỦA BẠN ---

            // Lấy thông tin phòng trước khi xóa để ghi log
            $tenPhong = $room->ten_phong;
            $roomId = $room->id;

            // Xóa các công tơ liên quan đến phòng
            CongTo::where('room_id', $room->id)->delete();
            
            // Xóa các file ảnh vật lý liên quan đến phòng
            if (!empty($room->images)) {
                $images = json_decode($room->images, true);
                if (is_array($images)) {
                    foreach ($images as $imgPath) {
                        $fullPath = public_path($imgPath);
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                    }
                }
            }

            // Cuối cùng, xóa bản ghi phòng trọ khỏi database
            $room->delete();

            // Ghi log chi tiết về hành động
            LogHelper::ghi(
                'Xóa phòng trọ: ' . $tenPhong . ' (ID: ' . $roomId . ')',
                'Phòng Trọ',
                'Người dùng "' . auth()->user()->name . '" (ID: ' . auth()->id() . ') đã xóa phòng trọ "' . $tenPhong . '". Lượt tạo phòng đã được hoàn lại cho chủ sở hữu.'
            );
        });

    } catch (\Exception $e) {
        // Nếu có bất kỳ lỗi nào xảy ra trong transaction, tất cả sẽ được hoàn tác.
        Log::error('Lỗi khi xóa phòng ID ' . $room->id . ': ' . $e->getMessage());
        return back()->with('error', 'Xóa phòng thất bại. Đã có lỗi xảy ra.');
    }

    // Redirect về trang trước đó với thông báo thành công
    return back()->with('success', 'Xóa phòng thành công và đã hoàn lại 1 lượt tạo phòng.');
}
    // App\Http\Controllers\RoomController.php
    public function getUsedRoomCodes($nha_tro_id)
    {
        $usedCodes = Rooms::where('nha_tro_id', $nha_tro_id)->pluck('ma_phong');
        return response()->json($usedCodes);
    }
}
