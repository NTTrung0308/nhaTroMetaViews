<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhuongTien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            return view('admin.profile.index', compact('user'));
        } else {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập');
        }
    }



    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone'         => 'nullable|string|max:11',
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'birthday'      => 'nullable|date',
            'cmnd'          => 'nullable|string',
            'ho_chieu'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cmt_mat_truoc' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'cmt_mat_sau'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'gioi_tinh'     => 'nullable|string',
            'ngay_cap_cmnd' => 'nullable|date',
            'noi_cap_cmnd'  => 'nullable|string|max:255',
            'thanh_pho'     => 'nullable|string|max:255',
            'huyen'         => 'nullable|string|max:255',
            'xa'            => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'stk'           => 'nullable|string|max:50',
            'ngan_hang'     => 'nullable|string|max:255',
            'nghe_nghiep'   => 'nullable|string|max:255',
            'noi_lam_viec'  => 'nullable|string|max:255',
            'note'          => 'nullable|string',
            'facebook'      => 'nullable|string|max:255',
            'zalo'          => 'nullable|string|max:255',
            'instar'        => 'nullable|string|max:255',
            'twitter'       => 'nullable|string|max:255',
            'linkdin'       => 'nullable|string|max:255',
        ], [
           
            'phone.max' => 'Số điện thoại k hợp lệ',
            'username.required'     => 'Vui lòng nhập tên đăng nhập.',
            'username.unique'       => 'Tên đăng nhập đã tồn tại.',
            'email.email'           => 'Email không hợp lệ.',
            'email.unique'          => 'Email đã được sử dụng.',
            'avatar.image'          => 'Ảnh đại diện phải là tập tin hình ảnh.',
            'avatar.mimes'          => 'Ảnh đại diện chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg.',
            'birthday.date'         => 'Ngày sinh không hợp lệ.',
            'ho_chieu.image'        => 'Hộ chiếu phải là hình ảnh.',
            'ho_chieu.mimes'        => 'Hộ chiếu chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg.',
            'cmt_mat_truoc.image'   => 'CMND mặt trước phải là hình ảnh.',
            'cmt_mat_truoc.mimes'   => 'CMND mặt trước chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg.',
            'cmt_mat_sau.image'     => 'CMND mặt sau phải là hình ảnh.',
            'cmt_mat_sau.mimes'     => 'CMND mặt sau chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg.',
            'ngay_cap_cmnd.date'    => 'Ngày cấp CMND không hợp lệ.',
            'noi_cap_cmnd.max'      => 'Nơi cấp CMND không được vượt quá 255 ký tự.',
            'thanh_pho.max'         => 'Thành phố không được vượt quá 255 ký tự.',
            'huyen.max'             => 'Huyện không được vượt quá 255 ký tự.',
            'xa.max'                => 'Xã không được vượt quá 255 ký tự.',
            'address.max'           => 'Địa chỉ không được vượt quá 255 ký tự.',
            'stk.max'               => 'Số tài khoản không được vượt quá 50 ký tự.',
            'ngan_hang.max'         => 'Tên ngân hàng không được vượt quá 255 ký tự.',
            'nghe_nghiep.max'       => 'Nghề nghiệp không được vượt quá 255 ký tự.',
            'noi_lam_viec.max'      => 'Nơi làm việc không được vượt quá 255 ký tự.',
            'facebook.max'          => 'Facebook không được vượt quá 255 ký tự.',
            'zalo.max'              => 'Zalo không được vượt quá 255 ký tự.',
            'instar.max'            => 'Instagram không được vượt quá 255 ký tự.',
            'twitter.max'           => 'Twitter không được vượt quá 255 ký tự.',
            'linkdin.max'           => 'LinkedIn không được vượt quá 255 ký tự.',
        ]);






        // Bắt đầu xử lý dữ liệu sau khi đã validate thành công
        $data = $request->except(['avatar', 'ho_chieu', 'cmt_mat_truoc', 'cmt_mat_sau']);

        // Hàm trợ giúp để xử lý upload file
        $uploadFile = function ($fileKey, $user, $request) {
            if ($request->hasFile($fileKey)) {
                $destinationPath = 'uploads/' . $fileKey; // Ví dụ: uploads/avatar, uploads/ho_chieu

                // Xóa file cũ
                if ($user->$fileKey && File::exists(public_path($user->$fileKey))) {
                    File::delete(public_path($user->$fileKey));
                }

                // Upload file mới
                $file = $request->file($fileKey);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($destinationPath), $fileName);
                return $destinationPath . '/' . $fileName;
            }
            return $user->$fileKey; // Giữ lại giá trị cũ nếu không có file mới
        };

        // Xử lý upload cho từng file ảnh
        $data['avatar'] = $uploadFile('avatar', $user, $request);
        $data['ho_chieu'] = $uploadFile('ho_chieu', $user, $request);
        $data['cmt_mat_truoc'] = $uploadFile('cmt_mat_truoc', $user, $request);
        $data['cmt_mat_sau'] = $uploadFile('cmt_mat_sau', $user, $request);


        // Cập nhật thông tin người dùng
        $user->update($data);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }



    /**
     * Xử lý việc đổi mật khẩu.
     */
   public function updatePassword(Request $request)
    {
        // 1. Validate dữ liệu đầu vào với các thông báo tùy chỉnh
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required'         => 'Vui lòng nhập mật khẩu mới.',
            'password.min'              => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.confirmed'        => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user = Auth::user();

        // 2. Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            // Trả về trang trước với một lỗi cụ thể cho trường 'current_password'
            // View sẽ có thể bắt lỗi này bằng @error('current_password')
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // 3. Cập nhật mật khẩu mới nếu mọi thứ hợp lệ
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // 4. Trả về với thông báo thành công
        return back()->with('success', 'Đổi mật khẩu thành công!');
    }


     //==================================================================
    // CÁC PHƯƠNG THỨC XỬ LÝ AJAX CHO PHƯƠNG TIỆN - ĐÃ CẬP NHẬT
    //==================================================================

    public function getVehicles()
    {
        // THAY ĐỔI: Dùng đúng tên quan hệ đã định nghĩa ở User model
        $vehicles = Auth::user()->phuongTiens; 
        return response()->json($vehicles);
    }

    // THAY ĐỔI: Type-hint thành PhuongTien $phuongTien
    public function showVehicle(PhuongTien $phuongTien)
    {
        if ($phuongTien->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($phuongTien);
    }

    public function storeVehicle(Request $request)
    {
        // Danh sách các giá trị enum cho phép
        $loaiPhuongTienOptions = ['o_to', 'o_to_dien', 'xe_may', 'xe_may_dien', 'xe_dap', 'xe_dap_dien'];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bien_so' => 'required|string|max:20|unique:phuong_tiens,bien_so',
            // CẬP NHẬT VALIDATION: Phải là một trong các giá trị cho phép
            'loai_phuong_tien' => ['required', Rule::in($loaiPhuongTienOptions)],
            'ten_chu_xe' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $vehicle = PhuongTien::create($data);

        return response()->json($vehicle, 201);
    }

    public function updateVehicle(Request $request, PhuongTien $phuongTien)
    {
        if ($phuongTien->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Danh sách các giá trị enum cho phép
        $loaiPhuongTienOptions = ['o_to', 'o_to_dien', 'xe_may', 'xe_may_dien', 'xe_dap', 'xe_dap_dien'];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bien_so' => 'required|string|max:20|unique:phuong_tiens,bien_so,' . $phuongTien->id,
            // CẬP NHẬT VALIDATION: Phải là một trong các giá trị cho phép
            'loai_phuong_tien' => ['required', Rule::in($loaiPhuongTienOptions)],
            'ten_chu_xe' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $phuongTien->update($request->all());
        return response()->json($phuongTien);
    }

    // THAY ĐỔI: Type-hint thành PhuongTien $phuongTien
    public function destroyVehicle(PhuongTien $phuongTien)
    {
        if ($phuongTien->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // THAY ĐỔI: Xóa đối tượng $phuongTien
        $phuongTien->delete();
        return response()->json(['message' => 'Xóa phương tiện thành công!']);
    }
}
