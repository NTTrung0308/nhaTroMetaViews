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
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem nhà trọ')->only(['index']);
        $this->middleware('can:Thêm nhà trọ')->only(['create', 'store']);
        $this->middleware('can:Sửa nhà trọ')->only(['edit', 'update']);
        $this->middleware('can:Xóa nhà trọ')->only(['destroy']);
    }
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

    public function create()
    {
        $dichVus = DichVu::all();
        LogHelper::ghi('Vào form tạo nhà trọ', 'Nhà Trọ', 'Vào form tạo nhà trọ trong quản trị viên');
        return view('admin.nha_tro.create', compact('dichVus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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
            'mo_ta' => 'nullable|string',
            'status' => 'required|in:Hoạt động,Ngưng hoạt động',
            'quoc_gia' => 'required|string|max:255',
            'dich_vu_ids' => 'required|array',
            'dich_vu_ids.*' => 'exists:dich_vus,id',
            'don_gia.*' => 'required|numeric|min:0',
            'kieu_tinh.*' => 'required|in:cong_to,dau_nguoi,co_dinh',
        ], $this->messages());
        $defaultServiceCodes = ['nuoc', 'dien_sinh_hoat', 'mang'];
        $defaultServiceIds = DichVu::whereIn('ma_dich_vu', $defaultServiceCodes)->pluck('id')->toArray();

        // Nếu thiếu bất kỳ dịch vụ bắt buộc nào => trả lỗi
        $selectedServiceIds = $request->input('dich_vu_ids', []);

        $missingDefaults = array_diff($defaultServiceIds, $selectedServiceIds);

        if (!empty($missingDefaults)) {
            return back()->with('error', 'Vui lòng không bỏ chọn dịch vụ mặc định (Điện, Nước, Mạng)');
        }
        $nhaTro = NhaTros::create([
            'ten_toa_nha' => $request->ten_toa_nha,
            'ma_toa_nha' => $request->ma_toa_nha,
            'dia_chi' => $request->dia_chi,
            'phuong' => $request->phuong,
            'quan' => $request->quan,
            'thanh_pho' => $request->thanh_pho,
            'status' => $request->status ?? 'Hoạt động',
            'quoc_gia' => $request->quoc_gia ?? 'Việt Nam',
            'so_tang' => $request->so_tang,
            'so_phong_tang' => $request->so_phong_tang,
            'dien_tich' => $request->dien_tich,
            'chu_so_huu' => $request->chu_so_huu,
            'mo_ta' => $request->mo_ta,
        ]);


        if ($request->has('dich_vu_ids')) {
            $syncData = [];

            foreach ($request->dich_vu_ids as $dichVuId) {
                $syncData[$dichVuId] = [
                    'kieu_tinh' => $request->kieu_tinh[$dichVuId] ?? 'cong_to',
                    'don_gia' => $request->don_gia[$dichVuId] ?? 0,
                ];
            }

            $nhaTro->dichVus()->attach($syncData);
        }
        // Ghi log chi tiết
        $user = Auth::user();
        LogHelper::ghi(
            'Thêm nhà trọ: ' . $nhaTro->ten_toa_nha,
            'Nhà Trọ',
            'Người dùng "' . $user->name . '" (ID: ' . $user->id . ') đã thêm nhà trọ "' . $nhaTro->ten_toa_nha . '" với mã "' . $nhaTro->ma_toa_nha . '"'
        );



        return redirect()->route('nha_tro.index')->with('success', 'Thêm nhà trọ thành công');
    }

    public function edit($id)
    {
        $nhaTro = NhaTros::with('dichVus')->findOrFail($id); // ID nhà trọ đang sửa
        $dichVus = DichVu::all(); // Hiển thị tất cả dịch vụ

        // Tạo mảng pivot theo dịch vụ ID
        $pivotData = $nhaTro->dichVus->mapWithKeys(function ($item) {
            return [$item->id => [
                'don_gia' => $item->pivot->don_gia,
                'kieu_tinh' => $item->pivot->kieu_tinh,
            ]];
        });
        // Ghi log chi tiết
        $user = Auth::user();
        LogHelper::ghi(
            'Vào form sửa nhà trọ: ' . $nhaTro->ten_toa_nha,
            'Nhà Trọ',
            'Người dùng "' . $user->name . '" (ID: ' . $user->id . ') đã truy cập form sửa nhà trọ "' . $nhaTro->ten_toa_nha . '" (Mã: ' . $nhaTro->ma_toa_nha . ')'
        );
        return view('admin.nha_tro.edit', compact('nhaTro', 'dichVus', 'pivotData'));
    }

    public function update(Request $request, $id)
    {
        $nhaTro = NhaTros::findOrFail($id);

        $validatedData = $request->validate([
            'ten_toa_nha' => 'required|string|max:255',
            'ma_toa_nha' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nha_tros', 'ma_toa_nha')->ignore($nhaTro->id),
            ],
            'dia_chi' => 'required|string|max:255',
            'phuong' => 'required|string|max:255',
            'quan' => 'required|string|max:255',
            'thanh_pho' => 'required|string|max:255',
            'so_tang' => 'required|integer|min:0',
            'so_phong_tang' => 'required|integer|min:0',
            'dien_tich' => 'required|integer|min:0',
            'chu_so_huu' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'status' => 'required|in:Hoạt động,Ngưng hoạt động',
            'quoc_gia' => 'required|string|max:255',
            'dich_vu_ids' => 'required|array',
            'dich_vu_ids.*' => 'exists:dich_vus,id',
            'don_gia.*' => 'required|numeric|min:0',
            'kieu_tinh.*' => 'required|in:cong_to,dau_nguoi,co_dinh',
        ], $this->messages());
        $defaultServiceCodes = ['nuoc', 'dien_sinh_hoat', 'mang'];
        $defaultServiceIds = DichVu::whereIn('ma_dich_vu', $defaultServiceCodes)->pluck('id')->toArray();

        // Nếu thiếu bất kỳ dịch vụ bắt buộc nào => trả lỗi
        $selectedServiceIds = $request->input('dich_vu_ids', []);

        $missingDefaults = array_diff($defaultServiceIds, $selectedServiceIds);

        if (!empty($missingDefaults)) {
            return back()->with('error', 'Vui lòng không bỏ chọn dịch vụ mặc định (Điện, Nước, Mạng)');
        }
        $nhaTro->update([
            'ten_toa_nha' => $request->ten_toa_nha,
            'ma_toa_nha' => $request->ma_toa_nha,
            'dia_chi' => $request->dia_chi,
            'phuong' => $request->phuong,
            'quan' => $request->quan,
            'thanh_pho' => $request->thanh_pho,
            'status' => $request->status ?? 'Hoạt động',
            'quoc_gia' => $request->quoc_gia ?? 'Việt Nam',
            'so_tang' => $request->so_tang,
            'so_phong_tang' => $request->so_phong_tang,
            'dien_tich' => $request->dien_tich,
            'chu_so_huu' => $request->chu_so_huu,
            'mo_ta' => $request->mo_ta,
        ]);

        // Đồng bộ lại các dịch vụ
        $syncData = [];
        if ($request->has('dich_vu_ids')) {
            foreach ($request->dich_vu_ids as $index => $dichVuId) {
                $syncData[$dichVuId] = [
                    'don_gia' => $request->don_gia[$index] ?? 0,
                    'kieu_tinh' => $request->kieu_tinh[$index] ?? 'cong_to',
                ];
            }
        }
        $nhaTro->dichVus()->sync($syncData);
        LogHelper::ghi('Cập nhật nhà trọ với id ' . $nhaTro->id . 'thành ' . $request->ten_toa_nha , 'Nhà Trọ', 'Cập nhật thông tin nhà trọ trong quản trị viên');
        return redirect()->route('nha_tro.index')->with('success', 'Cập nhật nhà trọ thành công');
    }

    public function destroy($id)
    {
        $nhaTro = NhaTros::findOrFail($id);
        $nhaTro->delete();
        LogHelper::ghi('Xóa nhà trọ với id ' . $nhaTro->id, 'Nhà Trọ', 'Xóa nhà trọ trong quản trị viên');
        return redirect()->route('nha_tro.index')->with('success', 'Xóa nhà trọ thành công');
    }
   private function messages()
{
    return [
        // Thông tin tòa nhà
        'ten_toa_nha.required' => 'Vui lòng nhập tên tòa nhà.',
        'ten_toa_nha.max' => 'Tên tòa nhà không được vượt quá 255 ký tự.',

        'ma_toa_nha.required' => 'Vui lòng nhập mã tòa nhà.',
        'ma_toa_nha.max' => 'Mã tòa nhà không được vượt quá 255 ký tự.',
        'ma_toa_nha.unique' => 'Mã tòa nhà đã tồn tại trong hệ thống.',

        'dia_chi.required' => 'Vui lòng nhập địa chỉ.',
        'dia_chi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        'phuong.required' => 'Vui lòng nhập phường.',
        'phuong.max' => 'Phường không được vượt quá 255 ký tự.',
        'quan.required' => 'Vui lòng nhập quận.',
        'quan.max' => 'Quận không được vượt quá 255 ký tự.',
        'thanh_pho.required' => 'Vui lòng nhập thành phố.',
        'thanh_pho.max' => 'Thành phố không được vượt quá 255 ký tự.',
        'quoc_gia.required' => 'Vui lòng nhập quốc gia.',
        'quoc_gia.max' => 'Quốc gia không được vượt quá 255 ký tự.',

        // Thông số kỹ thuật
        'so_tang.required' => 'Vui lòng nhập số tầng.',
        'so_tang.integer' => 'Số tầng phải là số nguyên.',
        'so_tang.min' => 'Số tầng không được nhỏ hơn 0.',

        'so_phong_tang.required' => 'Vui lòng nhập số phòng mỗi tầng.',
        'so_phong_tang.integer' => 'Số phòng mỗi tầng phải là số nguyên.',
        'so_phong_tang.min' => 'Số phòng mỗi tầng không được nhỏ hơn 0.',

        'dien_tich.required' => 'Vui lòng nhập diện tích.',
        'dien_tich.integer' => 'Diện tích phải là số nguyên.',
        'dien_tich.min' => 'Diện tích không được nhỏ hơn 0.',

        'chu_so_huu.required' => 'Vui lòng nhập tên chủ sở hữu.',
        'chu_so_huu.max' => 'Tên chủ sở hữu không được vượt quá 255 ký tự.',

        // Trạng thái
        'status.required' => 'Vui lòng chọn trạng thái.',
        'status.in' => 'Trạng thái không hợp lệ. Chỉ chấp nhận: Hoạt động hoặc Ngưng hoạt động.',

        // Dịch vụ
        'dich_vu_ids.required' => 'Vui lòng chọn ít nhất một dịch vụ.',
        'dich_vu_ids.array' => 'Danh sách dịch vụ không hợp lệ.',
        'dich_vu_ids.*.exists' => 'Dịch vụ được chọn không tồn tại trong hệ thống.',

        // Đơn giá & kiểu tính
        'don_gia.*.required' => 'Vui lòng nhập đơn giá cho từng dịch vụ.',
        'don_gia.*.numeric' => 'Đơn giá phải là một số.',
        'don_gia.*.min' => 'Đơn giá không được nhỏ hơn 0.',

        'kieu_tinh.*.required' => 'Vui lòng chọn kiểu tính cho từng dịch vụ.',
        'kieu_tinh.*.in' => 'Kiểu tính không hợp lệ. Chỉ chấp nhận: công tơ, đầu người hoặc cố định.',
    ];
}

}
