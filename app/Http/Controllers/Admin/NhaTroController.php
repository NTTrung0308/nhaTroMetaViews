<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\DichVu;
use App\Models\NhaTros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NhaTroController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Xem nhà trọ')->only(['index']);
        $this->middleware('can:Thêm nhà trọ')->only(['create', 'store']);
        $this->middleware('can:Sửa nhà trọ')->only(['edit', 'update']);
        $this->middleware('can:Xóa nhà trọ')->only(['destroy']);
    }

    /**
     * Hiển thị danh sách nhà trọ
     */
    public function index(Request $request)
    {
        $query = NhaTros::query()->with('dichVus');

        if ($request->filled('ten_toa_nha')) {
            $query->where('ten_toa_nha', 'like', '%' . $request->ten_toa_nha . '%');
        }
        if ($request->filled('ma_toa_nha')) {
            $query->where('ma_toa_nha', 'like', '%' . $request->ma_toa_nha . '%');
        }
        if ($request->filled('dia_chi')) {
            $query->where('dia_chi', 'like', '%' . $request->dia_chi . '%');
        }
        if ($request->filled('quan')) {
            $query->where('quan', 'like', '%' . $request->quan . '%');
        }
        if ($request->filled('thanh_pho')) {
            $query->where('thanh_pho', 'like', '%' . $request->thanh_pho . '%');
        }

        $nhaTros = $query->latest()->paginate(10);
        LogHelper::ghi('Xem danh sách nhà trọ', 'Nhà Trọ', 'Xem danh sách nhà trọ trong quản trị viên');

        return view('admin.nha_tro.index', compact('nhaTros'));
    }

    /**
     * Hiển thị form tạo nhà trọ mới
     */
    public function create()
    {
        $dichVus = DichVu::all();
        LogHelper::ghi('Vào form tạo nhà trọ', 'Nhà Trọ', 'Vào form tạo nhà trọ trong quản trị viên');
        return view('admin.nha_tro.create', compact('dichVus'));
    }

    /**
     * Lưu nhà trọ mới vào database
     */
    public function store(Request $request)
    {
        // 1. Validation đã được sửa lại để xử lý cấu trúc dữ liệu mới
        $request->validate([
            'ten_toa_nha' => 'required|string|max:255',
            'ma_toa_nha' => 'required|string|max:255|unique:nha_tros,ma_toa_nha',
            'dia_chi' => 'required|string|max:255',
            'phuong' => 'required|string|max:255',
            'quan' => 'required|string|max:255',
            'thanh_pho' => 'required|string|max:255',
            'so_tang' => 'required|integer|min:0',
            'so_phong_tang' => 'required|integer|min:0',
            'dien_tich' => 'required|integer|min:0',
            'chu_so_huu' => 'required|string|max:255',
            'status' => 'required|in:Hoạt động,Ngưng hoạt động',
            
            // Validation cho dịch vụ
            'dich_vu_ids' => [
                'required', 'array',
                function ($attribute, $value, $fail) {
                    $dienId = DichVu::where('ma_dich_vu', 'dien_sinh_hoat')->value('id');
                    $nuocId = DichVu::where('ma_dich_vu', 'nuoc')->value('id');
                    if (!in_array($dienId, $value) || !in_array($nuocId, $value)) {
                        $fail('Dịch vụ Điện và Nước là bắt buộc.');
                    }
                },
            ],
            'dich_vu_data.*.don_gia' => 'required|numeric|min:0',
            'dich_vu_data.*.kieu_tinh' => 'required|string|in:cong_to,dau_nguoi,co_dinh',
        ], $this->messages());

        // 2. Tạo nhà trọ
        $nhaTro = NhaTros::create($request->except(['dich_vu_ids', 'dich_vu_data']));

        // 3. Xử lý dữ liệu dịch vụ đã được sửa lỗi
        $syncData = [];
        $allDichVuData = $request->input('dich_vu_data', []);
        
        if ($request->has('dich_vu_ids')) {
            foreach ($request->dich_vu_ids as $dichVuId) {
                if (isset($allDichVuData[$dichVuId])) {
                    $syncData[$dichVuId] = [
                        'don_gia'   => $allDichVuData[$dichVuId]['don_gia'],
                        'kieu_tinh' => $allDichVuData[$dichVuId]['kieu_tinh'],
                    ];
                }
            }
        }
        
        $nhaTro->dichVus()->sync($syncData);

        // 4. Ghi log và trả về
        LogHelper::ghi('Thêm nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Thêm nhà trọ mới');
        return redirect()->route('nha_tro.index')->with('success', 'Thêm nhà trọ thành công');
    }

    /**
     * Hiển thị form sửa nhà trọ
     */
    public function edit($id)
    {
        $nhaTro = NhaTros::with('dichVus')->findOrFail($id);
        $dichVus = DichVu::all();
        
        // Không cần truyền $pivotData nữa, logic đã được xử lý trong Blade
        LogHelper::ghi('Vào form sửa nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Truy cập form sửa nhà trọ');
        return view('admin.nha_tro.edit', compact('nhaTro', 'dichVus'));
    }

    /**
     * Cập nhật thông tin nhà trọ
     */
    public function update(Request $request, $id)
    {
        $nhaTro = NhaTros::findOrFail($id);

        // 1. Validation
        $request->validate([
            'ten_toa_nha' => 'required|string|max:255',
            'ma_toa_nha' => ['required', 'string', 'max:255', Rule::unique('nha_tros')->ignore($nhaTro->id)],
            'dia_chi' => 'required|string|max:255',
            'phuong' => 'required|string|max:255',
            'quan' => 'required|string|max:255',
            'thanh_pho' => 'required|string|max:255',
            'so_tang' => 'required|integer|min:0',
            'so_phong_tang' => 'required|integer|min:0',
            'dien_tich' => 'required|integer|min:0',
            'chu_so_huu' => 'required|string|max:255',
            'status' => 'required|in:Hoạt động,Ngưng hoạt động',
            
            // Validation cho dịch vụ
            'dich_vu_ids' => [
                'required', 'array',
                function ($attribute, $value, $fail) {
                    $dienId = DichVu::where('ma_dich_vu', 'dien_sinh_hoat')->value('id');
                    $nuocId = DichVu::where('ma_dich_vu', 'nuoc')->value('id');
                    if (!in_array($dienId, $value) || !in_array($nuocId, $value)) {
                        $fail('Dịch vụ Điện và Nước là bắt buộc.');
                    }
                },
            ],
            'dich_vu_data.*.don_gia' => 'required|numeric|min:0',
            'dich_vu_data.*.kieu_tinh' => 'required|string|in:cong_to,dau_nguoi,co_dinh',
        ], $this->messages());

        // 2. Cập nhật thông tin nhà trọ
        $nhaTro->update($request->except(['dich_vu_ids', 'dich_vu_data']));

        // 3. Đồng bộ lại các dịch vụ (Logic đã sửa lỗi)
        $syncData = [];
        $allDichVuData = $request->input('dich_vu_data', []);

        if ($request->has('dich_vu_ids')) {
            foreach ($request->dich_vu_ids as $dichVuId) {
                if (isset($allDichVuData[$dichVuId])) {
                    $syncData[$dichVuId] = [
                        'don_gia'   => $allDichVuData[$dichVuId]['don_gia'],
                        'kieu_tinh' => $allDichVuData[$dichVuId]['kieu_tinh'],
                    ];
                }
            }
        }
        $nhaTro->dichVus()->sync($syncData);

        // 4. Ghi log và trả về
        LogHelper::ghi('Cập nhật nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Cập nhật thông tin nhà trọ');
        return redirect()->route('nha_tro.index')->with('success', 'Cập nhật nhà trọ thành công');
    }

    /**
     * Xóa nhà trọ
     */
    public function destroy($id)
    {
        $nhaTro = NhaTros::findOrFail($id);
        LogHelper::ghi('Xóa nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Xóa nhà trọ');
        $nhaTro->delete();
        return redirect()->route('nha_tro.index')->with('success', 'Xóa nhà trọ thành công');
    }
   
    /**
     * Định nghĩa các thông báo lỗi tùy chỉnh
     */
    private function messages()
    {
        return [
            // Thông tin tòa nhà
            'ten_toa_nha.required' => 'Vui lòng nhập tên tòa nhà.',
            'ma_toa_nha.required' => 'Vui lòng nhập mã tòa nhà.',
            'ma_toa_nha.unique' => 'Mã tòa nhà đã tồn tại.',
            'dia_chi.required' => 'Vui lòng nhập địa chỉ.',
            'phuong.required' => 'Vui lòng nhập phường.',
            'quan.required' => 'Vui lòng nhập quận.',
            'thanh_pho.required' => 'Vui lòng nhập thành phố.',
            'so_tang.required' => 'Vui lòng nhập số tầng.',
            'so_phong_tang.required' => 'Vui lòng nhập số phòng mỗi tầng.',
            'dien_tich.required' => 'Vui lòng nhập diện tích.',
            'chu_so_huu.required' => 'Vui lòng nhập tên chủ sở hữu.',
            'status.required' => 'Vui lòng chọn trạng thái.',

            // Dịch vụ - Đã cập nhật
            'dich_vu_ids.required' => 'Vui lòng chọn ít nhất các dịch vụ bắt buộc (Điện, Nước).',
            'dich_vu_data.*.don_gia.required' => 'Đơn giá không được để trống.',
            'dich_vu_data.*.don_gia.numeric' => 'Đơn giá phải là số.',
            'dich_vu_data.*.don_gia.min' => 'Đơn giá không được nhỏ hơn 0.',
            'dich_vu_data.*.kieu_tinh.required' => 'Kiểu tính không được để trống.',
        ];
    }

}
