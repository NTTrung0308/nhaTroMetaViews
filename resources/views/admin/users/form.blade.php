@extends('admin.index')
@section('contentadmin')
    @php
        $isEdit = isset($user);
    @endphp
    

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ $isEdit ? 'Sửa khách hàng' : 'Thêm mới khách hàng' }}</h5>

                    </div>
                    <form method="POST"
                        action="{{ $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1"><span class="mb-1 false">Ảnh
                                            đại
                                            diện <!----></span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-avatar"
                                                    src="{{ $isEdit && $user->avatar ? asset($user->avatar) : '' }}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; {{ $isEdit && $user->avatar ? '' : 'display: none;' }}">
                                                <svg id="default-icon-avt" xmlns="http://www.w3.org/2000/svg" width="25px"
                                                    height="25px" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-image"
                                                    style="{{ $isEdit && $user->avatar ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </div>
                                            <input id="avatar" type="file" name="avatar"
                                                accept="image/png, image/jpg, image/jpeg" class="d-none">
                                            <div class="control-btns"><label for="avatar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg>
                                                </label><!---->
                                            </div>
                                        </div>
                                        <small class="text-danger"></small><!---->
                                    </div>
                                </span>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1">
                                        <span class="mb-1">CMND trước</span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-cmt-mt"
                                                    src="{{ $isEdit && $user->cmt_mat_truoc ? asset($user->cmt_mat_truoc) : '' }}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; {{ $isEdit && $user->cmt_mat_truoc ? '' : 'display: none;' }}">
                                                <svg id="default-icon-cmt-mt" xmlns="http://www.w3.org/2000/svg"
                                                    width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-image"
                                                    style="{{ $isEdit && $user->cmt_mat_truoc ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </div>
                                            <input id="cmt_mat_truoc" type="file" name="cmt_mat_truoc"
                                                accept="image/png, image/jpg, image/jpeg" class="d-none">
                                            <div class="control-btns">
                                                <label for="cmt_mat_truoc">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1">
                                        <span class="mb-1">CMND sau</span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-cmt-ms"
                                                    src="{{ $isEdit && $user->cmt_mat_sau ? asset($user->cmt_mat_sau) : '' }}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; {{ $isEdit && $user->cmt_mat_sau ? '' : 'display: none;' }}">
                                                <svg id="default-icon-cmt-ms" xmlns="http://www.w3.org/2000/svg"
                                                    width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-image"
                                                    style="{{ $isEdit && $user->cmt_mat_sau ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </div>
                                            <input id="cmt_mat_sau" type="file" name="cmt_mat_sau"
                                                accept="image/png, image/jpg, image/jpeg" class="d-none">
                                            <div class="control-btns">
                                                <label for="cmt_mat_sau">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1">
                                        <span class="mb-1">Hộ chiếu</span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-hc"
                                                    src="{{ $isEdit && $user->ho_chieu ? asset($user->ho_chieu) : '' }}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; {{ $isEdit && $user->ho_chieu ? '' : 'display: none;' }}">
                                                <svg id="default-icon-hc" xmlns="http://www.w3.org/2000/svg"
                                                    width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-image"
                                                    style="{{ $isEdit && $user->ho_chieu ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </div>
                                            <input id="ho_chieu" type="file" name="ho_chieu"
                                                accept="image/png, image/jpg, image/jpeg" class="d-none">
                                            <div class="control-btns">
                                                <label for="ho_chieu">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2">
                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label>Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label>Ngày sinh</label>
                                    <input type="date" name="birthday" class="form-control"
                                        value="{{ old('birthday', $user->birthday ?? '') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone ?? '') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mb-3">
                                    <label for="gioi_tinh">Giới tính</label>
                                    <select name="gioi_tinh" id="gioi_tinh" class="form-select">
                                        <option value="">-- Chọn giới tính --</option>
                                        <option value="Nam"
                                            {{ old('gioi_tinh', $user->gioi_tinh ?? '') == 'Nam' ? 'selected' : '' }}>Nam
                                        </option>
                                        <option value="Nữ"
                                            {{ old('gioi_tinh', $user->gioi_tinh ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ
                                        </option>
                                        <option value="Khác"
                                            {{ old('gioi_tinh', $user->gioi_tinh ?? '') == 'Khác' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email ?? '') }}" required>
                                </div>

                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Mật khẩu
                                        {!! $isEdit ? '(Để trống nếu không đổi)' : '<span class="text-danger">*</span>' !!}
                                    </label>

                                    <input type="password" name="password" class="form-control"
                                        {{ $isEdit ? '' : 'required' }}>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Kích hoạt</label>
                                    <select name="active" class="form-select">
                                        <option value="1"
                                            {{ old('active', $user->active ?? 1) == 1 ? 'selected' : '' }}>
                                            Có
                                        </option>
                                        <option value="0"
                                            {{ old('active', $user->active ?? 1) == 0 ? 'selected' : '' }}>
                                            Không</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>CMND</label>
                                    <input type="text" name="cmnd" class="form-control"
                                        value="{{ old('cmnd', $user->cmnd ?? '') }}">
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Ngày cấp CMND</label>
                                    <input type="text" name="ngay_cap_cmnd" class="form-control"
                                        value="{{ old('ngay_cap_cmnd', $user->ngay_cap_cmnd ?? '') }}">
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Nơi cấp CMND</label>
                                    <input type="text" name="noi_cap_cmnd" class="form-control"
                                        value="{{ old('noi_cap_cmnd', $user->noi_cap_cmnd ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-4">

                                <div class="form-group mb-3">
                                    <label>Thành phố/Tỉnh</label>
                                    <select name="thanh_pho" id="province-select" class="form-control"
                                        data-old="{{ old('thanh_pho', $user->thanh_pho ?? '') }}">
                                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">

                                <div class="form-group mb-3">
                                    <label>Quận/Huyện</label>
                                    <select name="huyen" id="district-select" class="form-control"
                                        data-old="{{ old('huyen', $user->huyen ?? '') }}" disabled>
                                        <option value="">-- Chọn Quận/Huyện --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">

                                <div class="form-group mb-3">
                                    <label>Phường/Xã</label>
                                    <select name="xa" id="ward-select" class="form-control"
                                        data-old="{{ old('xa', $user->xa ?? '') }}" disabled>
                                        <option value="">-- Chọn Phường/Xã --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $user->address ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>Số tài khoản</label>
                                    <input type="text" name="stk" class="form-control"
                                        value="{{ old('stk', $user->stk ?? '') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label>Ngân hàng</label>
                                    <input type="text" name="ngan_hang" class="form-control"
                                        value="{{ old('ngan_hang', $user->ngan_hang ?? '') }}">
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Nghề nghiệp</label>
                                    <input type="text" name="nghe_nghiep" class="form-control"
                                        value="{{ old('nghe_nghiep', $user->nghe_nghiep ?? '') }}">
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Nơi làm việc</label>
                                    <input type="text" name="noi_lam_viec" class="form-control"
                                        value="{{ old('noi_lam_viec', $user->noi_lam_viec ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label>Mã vân tay</label>
                                    <input type="text" name="ma_van_tay" class="form-control"
                                        value="{{ old('ma_van_tay', $user->ma_van_tay ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>Ghi chú</label>
                                    <textarea name="note" class="form-control">{{ old('note', $user->note ?? '') }}</textarea>
                                </div>
                            </div>


                        </div>
                        <div class="text-end"><button type="submit" class="btn btn-success">Lưu</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setupImagePreview(inputId, previewId, iconId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const icon = document.getElementById(iconId);

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (evt) => {
                        preview.src = evt.target.result;
                        preview.style.display = 'block';
                        icon.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        setupImagePreview('avatar', 'preview-avatar', 'default-icon-avt');
        setupImagePreview('cmt_mat_truoc', 'preview-cmt-mt', 'default-icon-cmt-mt');
        setupImagePreview('cmt_mat_sau', 'preview-cmt-ms', 'default-icon-cmt-ms');
        setupImagePreview('ho_chieu', 'preview-hc', 'default-icon-hc');
    </script>
@endsection
