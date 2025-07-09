@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Hồ sơ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Hồ sơ</li>
            </ol>
        </nav>
    </div>

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
                                    aria-selected="false" tabindex="-1" role="tab">Change Password</button>
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

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
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
