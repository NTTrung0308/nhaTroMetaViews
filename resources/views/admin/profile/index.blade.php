@extends('admin.index')
@section('contentadmin')
    

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ asset($user->avatar ?? '/assets/img/default-avatar.png') }}" alt="Profile"
                            class="rounded-circle">
                        <h2>{{ $user->name ?? '' }}</h2>
                        <h3>{{ $user->username ?? '' }}</h3>
                        <div class="social-links mt-2">
                            @if ($user->twitter)
                                <a href="{{ $user->twitter }}" class="twitter"><i class="bi bi-twitter"></i></a>
                            @endif
                            @if ($user->facebook)
                                <a href="{{ $user->facebook }}" class="facebook"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if ($user->instar)
                                <a href="{{ $user->instar }}" class="instagram"><i class="bi bi-instagram"></i></a>
                            @endif
                            @if ($user->linkdin)
                                <a href="{{ $user->linkdin }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"
                                    aria-selected="true" role="tab">Tổng quan</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit"
                                    aria-selected="false" tabindex="-1" role="tab">Thông tin cá nhân</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings"
                                    aria-selected="false" tabindex="-1" role="tab">Thông tin khác</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"
                                    aria-selected="false" tabindex="-1" role="tab">Đổi mật khẩu</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-vehicles"
                                    aria-selected="false" tabindex="-1" role="tab">Phương tiện</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                                <h5 class="card-title">Giới thiệu</h5>
                                <p class="small fst-italic">{{ $user->note ?? 'Đang cập nhật...' }}</p>

                                <h5 class="card-title">Thông tin chi tiết</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Tên</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->name ?? 'Đang cập nhật...' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Địa chỉ</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->address ?? 'Đang cập nhật...' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Số điện thoại</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->phone ?? 'Đang cập nhật...' }}</div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email ?? 'Đang cập nhật...' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Ngày sinh</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->birthday ?? 'Đang cập nhật...' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Chứng minh nhân dân</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->cmnd ?? 'Đang cập nhật...' }}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">

                                <!-- Profile Edit Form -->
                                <form action="{{ route('admin.profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')


                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tên</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Tên Đầy đủ</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ old('username', $user->username) }}">
                                            @error('username')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if (auth()->user()->hasPermissionTo('Xem phòng trọ') ||
                                            auth()->user()->hasPermissionTo('Thêm phòng trọ') ||
                                            auth()->user()->hasPermissionTo('Sửa phòng trọ') ||
                                            auth()->user()->hasPermissionTo('Xóa phòng trọ'))
                                        <div class="row mb-3">
                                            <label for="license_key" class="col-md-4 col-lg-3 col-form-label">License
                                                Key</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" name="license_key" id="license_key"
                                                    class="form-control"
                                                    value="{{ old('license_key', $user->license_key) }}">
                                                @error('license_key')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mb-3">
                                        <label for="note" class="col-md-4 col-lg-3 col-form-label">Giới thiệu</label>
                                        <div class="col-md-8 col-lg-9">
                                            <textarea name="note" class="form-control" id="note" style="height: 100px">{{ old('note', $user->note) }}</textarea>
                                            @error('note')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Số điện
                                            thoại</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone"
                                                value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="birthday" class="col-md-4 col-lg-3 col-form-label">Ngày sinh</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="date" class="form-control" id="birthday" name="birthday"
                                                value="{{ old('birthday', $user->birthday) }}">
                                            @error('birthday')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="gioi_tinh" class="col-md-4 col-lg-3 col-form-label">Giới tính</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="gioi_tinh" id="gioi_tinh" class="form-control">
                                                <option value="Nam"
                                                    {{ old('gioi_tinh', $user->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam
                                                </option>
                                                <option value="Nữ"
                                                    {{ old('gioi_tinh', $user->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ
                                                </option>
                                                <option value="Khác"
                                                    {{ old('gioi_tinh', $user->gioi_tinh) == 'Khác' ? 'selected' : '' }}>
                                                    Khác</option>
                                            </select>
                                            @error('gioi_tinh')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="cmnd" class="col-md-4 col-lg-3 col-form-label">Chứng minh nhân
                                            dân</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="cmnd" type="number" min="0" class="form-control"
                                                id="cmnd" value="{{ old('number', $user->number) }}">
                                            @error('cmnd')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="twitter" type="text" class="form-control" id="twitter"
                                                value="{{ old('twitter', $user->twitter) }}">
                                            @error('twitter')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="facebook" type="text" class="form-control" id="facebook"
                                                value="{{ old('facebook', $user->facebook) }}">
                                            @error('facebook')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="instar" type="text" class="form-control" id="instar"
                                                value="{{ old('instar', $user->instar) }}">
                                            @error('instar')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="linkdin" type="text" class="form-control" id="linkdin"
                                                value="{{ old('linkdin', $user->linkdin) }}">
                                            @error('linkdin')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Zalo" class="col-md-4 col-lg-3 col-form-label">Zalo</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="zalo" type="text" class="form-control" id="zalo"
                                                value="{{ old('zalo', $user->zalo) }}">
                                            @error('zalo')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">

                                <!-- Settings Form -->
                                <form action="{{ route('admin.profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">



                                        <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                            <span>
                                                <div class="d-flex flex-column mb-1"><span class="mb-1 false">Ảnh
                                                        đại
                                                        diện <!----></span>
                                                    <div class="position-relative image-container-user mb-2">
                                                        <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                            class="mb-2 thumbnail">
                                                            <img id="preview-avatar"
                                                                src="{{ $user->avatar ? asset($user->avatar) : '' }}"
                                                                alt="Xem trước ảnh"
                                                                style="width: 100%; height: 100%; object-fit: cover; {{ $user->avatar ? '' : 'display: none;' }}">
                                                            <svg id="default-icon-avt" xmlns="http://www.w3.org/2000/svg"
                                                                width="25px" height="25px" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-image"
                                                                style="{{ $user->avatar ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                <rect x="3" y="3" width="18" height="18"
                                                                    rx="2" ry="2"></rect>
                                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                                <polyline points="21 15 16 10 5 21"></polyline>
                                                            </svg>
                                                        </div>
                                                        <input id="avatar" type="file" name="avatar"
                                                            accept="image/png, image/jpg, image/jpeg" class="d-none">
                                                        <div class="control-btns"><label for="avatar">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15px"
                                                                    height="15px" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
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
                                                                src="{{ $user->cmt_mat_truoc ? asset($user->cmt_mat_truoc) : '' }}"
                                                                alt="Xem trước ảnh"
                                                                style="width: 100%; height: 100%; object-fit: cover; {{ $user->cmt_mat_truoc ? '' : 'display: none;' }}">
                                                            <svg id="default-icon-cmt-mt"
                                                                xmlns="http://www.w3.org/2000/svg" width="25px"
                                                                height="25px" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-image"
                                                                style="{{ $user->cmt_mat_truoc ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                <rect x="3" y="3" width="18" height="18"
                                                                    rx="2" ry="2"></rect>
                                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                                <polyline points="21 15 16 10 5 21"></polyline>
                                                            </svg>
                                                        </div>
                                                        <input id="cmt_mat_truoc" type="file" name="cmt_mat_truoc"
                                                            accept="image/png, image/jpg, image/jpeg" class="d-none">
                                                        <div class="control-btns">
                                                            <label for="cmt_mat_truoc">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15px"
                                                                    height="15px" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
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
                                                                src="{{ $user->cmt_mat_sau ? asset($user->cmt_mat_sau) : '' }}"
                                                                alt="Xem trước ảnh"
                                                                style="width: 100%; height: 100%; object-fit: cover; {{ $user->cmt_mat_sau ? '' : 'display: none;' }}">
                                                            <svg id="default-icon-cmt-ms"
                                                                xmlns="http://www.w3.org/2000/svg" width="25px"
                                                                height="25px" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-image"
                                                                style="{{ $user->cmt_mat_sau ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                <rect x="3" y="3" width="18" height="18"
                                                                    rx="2" ry="2"></rect>
                                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                                <polyline points="21 15 16 10 5 21"></polyline>
                                                            </svg>
                                                        </div>
                                                        <input id="cmt_mat_sau" type="file" name="cmt_mat_sau"
                                                            accept="image/png, image/jpg, image/jpeg" class="d-none">
                                                        <div class="control-btns">
                                                            <label for="cmt_mat_sau">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15px"
                                                                    height="15px" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
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
                                                                src="{{ $user->ho_chieu ? asset($user->ho_chieu) : '' }}"
                                                                alt="Xem trước ảnh"
                                                                style="width: 100%; height: 100%; object-fit: cover; {{ $user->ho_chieu ? '' : 'display: none;' }}">
                                                            <svg id="default-icon-hc" xmlns="http://www.w3.org/2000/svg"
                                                                width="25px" height="25px" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-image"
                                                                style="{{ $user->ho_chieu ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                                <rect x="3" y="3" width="18" height="18"
                                                                    rx="2" ry="2"></rect>
                                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                                <polyline points="21 15 16 10 5 21"></polyline>
                                                            </svg>
                                                        </div>
                                                        <input id="ho_chieu" type="file" name="ho_chieu"
                                                            accept="image/png, image/jpg, image/jpeg" class="d-none">
                                                        <div class="control-btns">
                                                            <label for="ho_chieu">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15px"
                                                                    height="15px" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                    </path>
                                                                </svg>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="ngay_cap_cmnd" class="col-md-4 col-lg-3 col-form-label">Ngày cấp
                                                cmnd/cccd</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="ngay_cap_cmnd" type="date" class="form-control"
                                                    id="ngay_cap_cmnd"
                                                    value="{{ old('ngay_cap_cmnd', $user->ngay_cap_cmnd) }}">
                                                @error('ngay_cap_cmnd')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="noi_cap_cmnd" class="col-md-4 col-lg-3 col-form-label">Nơi cấp
                                                cmnd</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="noi_cap_cmnd" type="text" class="form-control"
                                                    id="noi_cap_cmnd"
                                                    value="{{ old('noi_cap_cmnd', $user->noi_cap_cmnd) }}">
                                                @error('noi_cap_cmnd')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
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
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label>Số tài khoản</label>
                                                <input type="text" name="stk" class="form-control"
                                                    value="{{ old('stk', $user->stk ?? '') }}">
                                                @error('stk')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label>Ngân hàng</label>
                                                <input type="text" name="ngan_hang" class="form-control"
                                                    value="{{ old('ngan_hang', $user->ngan_hang ?? '') }}">
                                                @error('ngan_hang')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label>Nghề nghiệp</label>
                                                <input type="text" name="nghe_nghiep" class="form-control"
                                                    value="{{ old('nghe_nghiep', $user->nghe_nghiep ?? '') }}">
                                                @error('nghe_nghiep')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label>Nơi làm việc</label>
                                                <input type="text" name="noi_lam_viec" class="form-control"
                                                    value="{{ old('noi_lam_viec', $user->noi_lam_viec ?? '') }}">
                                                @error('noi_lam_viec')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                                    </div>
                                </form><!-- End settings Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                                <!-- Change Password Form -->
                                <form action="{{ route('admin.profile.change_password') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu
                                            hiện tại</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                id="currentPassword">
                                            @error('current_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Mật khẩu
                                            mới</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="newPassword">
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Xác nhận mật
                                            khẩu</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_confirmation" type="password" class="form-control"
                                                id="renewPassword">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                    </div>
                                </form>
                            </div>
                            {{-- NỘI DUNG TAB PHƯƠNG TIỆN MỚI --}}
                            <div class="tab-pane fade pt-3" id="profile-vehicles" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Danh sách phương tiện</h5>
                                    <button type="button" class="btn btn-primary btn-sm" id="btn-add-vehicle">
                                        <i class="bi bi-plus-circle"></i> Thêm mới
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tên xe</th>
                                                <th scope="col">Biển số</th>
                                                <th scope="col">Loại xe</th>
                                                <th scope="col">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vehicles-table-body">
                                            {{-- Dữ liệu sẽ được load vào đây bằng JavaScript --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>

    </section> <!-- =================================================================== -->
    <!-- MODAL (POP-UP) ĐỂ THÊM/SỬA PHƯƠNG TIỆN -->
    <!-- =================================================================== -->
    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleModalLabel">Thêm mới phương tiện</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="vehicleForm" novalidate>
                        <input type="hidden" id="vehicle_id" name="vehicle_id">

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phương tiện</label>
                            <input type="text" class="form-control" id="namebienso" name="name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="bien_so" class="form-label">Biển số</label>
                            <input type="text" class="form-control" id="bien_so" name="bien_so" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- === THAY ĐỔI QUAN TRỌNG Ở ĐÂY === -->
                        <div class="mb-3">
                            <label for="loai_phuong_tien" class="form-label">Loại phương tiện</label>
                            <select class="form-select" id="loai_phuong_tien" name="loai_phuong_tien" required>
                                <option value="" selected disabled>-- Chọn loại phương tiện --</option>
                                <option value="o_to">Ô tô</option>
                                <option value="o_to_dien">Ô tô điện</option>
                                <option value="xe_may">Xe máy</option>
                                <option value="xe_may_dien">Xe máy điện</option>
                                <option value="xe_dap">Xe đạp</option>
                                <option value="xe_dap_dien">Xe đạp điện</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <!-- === KẾT THÚC THAY ĐỔI === -->

                        <div class="mb-3">
                            <label for="ten_chu_xe" class="form-label">Tên chủ xe</label>
                            <input type="text" class="form-control" id="ten_chu_xe" name="ten_chu_xe"
                                value="{{ $user->name }}" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" form="vehicleForm">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>
    <!-- =================================================================== -->
    <!-- JAVASCRIPT CHO TAB PHƯƠNG TIỆN - PHIÊN BẢN ĐÃ SỬA LỖI ROUTE -->
    <!-- =================================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vehicleModal = new bootstrap.Modal(document.getElementById('vehicleModal'));
            const vehicleForm = document.getElementById('vehicleForm');
            const vehiclesTableBody = document.getElementById('vehicles-table-body');
            const csrfToken = '{{ csrf_token() }}';

            // Hàm load danh sách phương tiện - Dùng route() nên tự động đúng
            async function loadVehicles() {
                try {
                    const response = await fetch(`{{ route('admin.profile.vehicles.index') }}`);
                    if (!response.ok) throw new Error('Lỗi mạng!');
                    const phuongTiens = await response.json();

                    vehiclesTableBody.innerHTML = '';
                    if (phuongTiens.length === 0) {
                        vehiclesTableBody.innerHTML =
                            '<tr><td colspan="5" class="text-center">Chưa có phương tiện nào.</td></tr>';
                    } else {
                        phuongTiens.forEach((pt, index) => {
                            const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${pt.name}</td>
                                <td>${pt.bien_so}</td>
                                <td>${pt.loai_phuong_tien}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit-vehicle" data-id="${pt.id}" title="Sửa"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-danger btn-sm btn-delete-vehicle" data-id="${pt.id}" title="Xóa"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        `;
                            vehiclesTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
                } catch (error) {
                    console.error('Lỗi khi tải danh sách phương tiện:', error);
                    vehiclesTableBody.innerHTML =
                        '<tr><td colspan="5" class="text-center text-danger">Không thể tải dữ liệu.</td></tr>';
                }
            }

            function resetForm() { // Hàm này không đổi
                vehicleForm.reset();
                document.getElementById('vehicle_id').value = '';
                document.getElementById('ten_chu_xe').value = '{{ $user->name }}';
                vehicleForm.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                    el.nextElementSibling.textContent = '';
                });
            }

            document.getElementById('btn-add-vehicle').addEventListener('click', function() { // Hàm này không đổi
                resetForm();
                document.getElementById('vehicleModalLabel').textContent = 'Thêm mới phương tiện';
                vehicleModal.show();
            });

            // Sự kiện khi submit form (Thêm hoặc Sửa)
            vehicleForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const vehicleId = document.getElementById('vehicle_id').value;

                // === THAY ĐỔI QUAN TRỌNG Ở ĐÂY ===
                // Cập nhật URL để khớp với prefix 'thong-tin-ca-nhan'
                const url = vehicleId ?
                    `{{ url('admin/thong-tin-ca-nhan/vehicles') }}/${vehicleId}` : // URL CẬP NHẬT
                    `{{ route('admin.profile.vehicles.store') }}`; // Dùng route() nên tự đúng

                const method = vehicleId ? 'PUT' : 'POST';

                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    // Xóa các lỗi cũ trước khi xử lý kết quả
                    vehicleForm.querySelectorAll('.is-invalid').forEach(el => {
                        el.classList.remove('is-invalid');
                        el.nextElementSibling.textContent = '';
                    });

                    if (!response.ok) {
                        if (response.status === 422) {
                            for (const field in result.errors) {
                                const input = document.getElementById(field);
                                if (input) {
                                    input.classList.add('is-invalid');
                                    input.nextElementSibling.textContent = result.errors[field][0];
                                }
                            }
                        } else {
                            alert(result.message || 'Có lỗi xảy ra!');
                        }
                        return; // Dừng lại không đóng modal nếu có lỗi
                    }

                    vehicleModal.hide();
                    loadVehicles();
                    alert(vehicleId ? 'Cập nhật thành công!' : 'Thêm mới thành công!');

                } catch (error) {
                    console.error('Lỗi khi lưu phương tiện:', error);
                    alert('Thao tác thất bại! Vui lòng kiểm tra console.');
                }
            });

            // Sự kiện khi nhấn nút Sửa hoặc Xóa
            vehiclesTableBody.addEventListener('click', async function(e) {
                const button = e.target.closest('button');
                if (!button) return;

                const vehicleId = button.dataset.id;
                // === THAY ĐỔI QUAN TRỌNG Ở ĐÂY ===
                // Cập nhật URL để khớp với prefix 'thong-tin-ca-nhan'
                const vehicleBaseUrl = `{{ url('admin/thong-tin-ca-nhan/vehicles') }}/${vehicleId}`;

                // Xử lý nút Sửa
                if (button.classList.contains('btn-edit-vehicle')) {
                    try {
                        const response = await fetch(vehicleBaseUrl); // URL CẬP NHẬT
                        if (!response.ok) throw new Error('Không tìm thấy phương tiện');
                        const pt = await response.json();

                        resetForm();
                        document.getElementById('vehicleModalLabel').textContent =
                            'Chỉnh sửa phương tiện';
                        document.getElementById('vehicle_id').value = pt.id;
                        document.getElementById('namebienso').value = pt.name;
                        document.getElementById('bien_so').value = pt.bien_so;
                        document.getElementById('loai_phuong_tien').value = pt.loai_phuong_tien;
                        document.getElementById('ten_chu_xe').value = pt.ten_chu_xe;

                        vehicleModal.show();
                    } catch (error) {
                        alert('Không thể lấy thông tin phương tiện.');
                    }
                }

                // Xử lý nút Xóa
                if (button.classList.contains('btn-delete-vehicle')) {
                    if (confirm('Bạn có chắc chắn muốn xóa phương tiện này?')) {
                        try {
                            const response = await fetch(vehicleBaseUrl, { // URL CẬP NHẬT
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            });
                            if (!response.ok) throw new Error('Xóa thất bại');

                            loadVehicles();
                            alert('Xóa thành công!');
                        } catch (error) {
                            alert('Xóa thất bại!');
                        }
                    }
                }
            });

            // Tải danh sách phương tiện lần đầu
            loadVehicles();
        });
    </script>
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
