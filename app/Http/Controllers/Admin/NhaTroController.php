<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\DichVu;
use App\Models\NhaTro; // SỬA: Dùng tên Model số ít, đúng chuẩn
use App\Models\NhaTros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            // Chuyển cả cột 'thanh_pho' và chuỗi tìm kiếm về chữ thường
            $query->where(DB::raw('LOWER(thanh_pho)'), 'like', '%' . mb_strtolower($request->thanh_pho, 'UTF-8') . '%');
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
        // Gọi hàm validation chung
        $validatedData = $request->validate($this->validationRules(), $this->messages());

        // Tạo nhà trọ chỉ với dữ liệu đã được validate
        $nhaTro = NhaTros::create($validatedData);

        // Đồng bộ dịch vụ bằng hàm private
        $this->syncServices($request, $nhaTro);

        LogHelper::ghi('Thêm nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Thêm nhà trọ mới');
        return redirect()->route('nha_tro.index')->with('success', 'Thêm nhà trọ thành công!');
    }

    /**
     * Hiển thị form sửa nhà trọ
     */
    public function edit(NhaTros $nhaTro) // SỬA: Dùng Route Model Binding
    {
        $nhaTro->load('dichVus'); // Đảm bảo đã load quan hệ
        $dichVus = DichVu::all();
        LogHelper::ghi('Vào form sửa nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Truy cập form sửa nhà trọ');
        return view('admin.nha_tro.edit', compact('nhaTro', 'dichVus'));
    }

    /**
     * Cập nhật thông tin nhà trọ
     */
    public function update(Request $request, NhaTros $nhaTro) // SỬA: Dùng Route Model Binding
    {
        // Gọi hàm validation chung, truyền vào ID để bỏ qua check unique
        $validatedData = $request->validate($this->validationRules($nhaTro->id), $this->messages());

        // Cập nhật thông tin nhà trọ
        $nhaTro->update($validatedData);

        // Đồng bộ lại các dịch vụ
        $this->syncServices($request, $nhaTro);

        LogHelper::ghi('Cập nhật nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Cập nhật thông tin');
        return redirect()->route('nha_tro.index')->with('success', 'Cập nhật nhà trọ thành công!');
    }

    /**
     * Xóa nhà trọ
     */
    public function destroy(NhaTros $nhaTro) // SỬA: Dùng Route Model Binding
    {
        LogHelper::ghi('Xóa nhà trọ: ' . $nhaTro->ten_toa_nha, 'Nhà Trọ', 'Xóa nhà trọ');
        $nhaTro->delete();
        return redirect()->route('nha_tro.index')->with('success', 'Xóa nhà trọ thành công');
    }

    /**
     * =============================================================
     * CÁC HÀM PRIVATE ĐỂ TÁI SỬ DỤNG CODE
     * =============================================================
     */

    /**
     * Hàm private để đồng bộ dịch vụ
     */
    private function syncServices(Request $request, NhaTros $nhaTro): void
    {
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
    }

    /**
     * Hàm private chứa các quy tắc validation
     */
    private function validationRules($id = null): array
    {
        $maToaNhaRule = ($id)
            ? Rule::unique('nha_tros')->ignore($id)
            : Rule::unique('nha_tros');

        return [
            // Các trường của bảng nha_tros
            'ten_toa_nha' => 'required|string|max:255',
            'ma_toa_nha' => ['required', 'string', 'max:255', $maToaNhaRule],
            'dia_chi' => 'required|string|max:255',
            'phuong' => 'required|string|max:255',
            'quan' => 'required|string|max:255',
            'thanh_pho' => 'required|string|max:255',
            'so_tang' => 'required|integer|min:0',
            'so_phong_tang' => 'required|integer|min:0',
            'dien_tich' => 'required|integer|min:0',
            'chu_so_huu' => 'required|string|max:255',
            'status' => 'required|in:Hoạt động,Ngưng hoạt động',
            'mo_ta' => 'nullable|string',
            'quoc_gia' => 'nullable|string|max:255',

            // Các trường ảo từ form để xử lý dịch vụ
            'dich_vu_ids' => ['required', 'array', function ($attribute, $value, $fail) {
                $requiredIds = DichVu::whereIn('ma_dich_vu', ['dien_sinh_hoat', 'nuoc'])->pluck('id')->toArray();
                if (count(array_intersect($requiredIds, $value)) < count($requiredIds)) {
                    $fail('Dịch vụ Điện và Nước là bắt buộc.');
                }
            }],
            'dich_vu_data' => 'required|array',
            'dich_vu_data.*.don_gia' => 'required|numeric|min:0',
            'dich_vu_data.*.kieu_tinh' => 'required|string|in:cong_to,dau_nguoi,co_dinh',
        ];
    }

    /**
     * Hàm private chứa các thông báo lỗi tùy chỉnh.
     */
    private function messages(): array
    {
        return [
            'ten_toa_nha.required' => 'Vui lòng nhập tên tòa nhà.',
            'ma_toa_nha.required' => 'Vui lòng nhập mã tòa nhà.',
            'ma_toa_nha.unique' => 'Mã tòa nhà đã tồn tại.',
            'dia_chi.required' => 'Vui lòng nhập địa chỉ.',
            'phuong.required' => 'Vui lòng nhập phường/xã.',
            'quan.required' => 'Vui lòng nhập quận/huyện.',
            'thanh_pho.required' => 'Vui lòng nhập tỉnh/thành phố.',
            'so_tang.required' => 'Vui lòng nhập số tầng.',
            'so_phong_tang.required' => 'Vui lòng nhập số phòng mỗi tầng.',
            'dien_tich.required' => 'Vui lòng nhập diện tích.',
            'chu_so_huu.required' => 'Vui lòng nhập tên chủ sở hữu.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'dich_vu_ids.required' => 'Vui lòng chọn ít nhất các dịch vụ bắt buộc (Điện, Nước).',
            'dich_vu_data.*.don_gia.required' => 'Đơn giá không được để trống.',
            'dich_vu_data.*.don_gia.numeric' => 'Đơn giá phải là một số.',
            'dich_vu_data.*.kieu_tinh.required' => 'Kiểu tính không được để trống.',
        ];
    }
}
