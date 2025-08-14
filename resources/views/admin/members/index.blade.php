@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Thành viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Thành viên</li>
            </ol>
        </nav>
    </div>




    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thành viên</h5>
                        {{-- @if (auth()->user()->hasPermissionTo('Thêm phòng trọ')) --}}
                        <a href="{{ route('admin.members.create') }}" class="btn btn-success rounded-pill">Thêm phòng mới</a>
                        {{-- @endif --}}
                    </div>
                    <div class="row">
                        {{-- <form method="GET" action="{{ route('rooms.index') }}" class="row align-items-end g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Phòng trọ</label>
                                <select name="nha_tro_id" class="form-select select_ted">
                                    <option value="">-- Tất cả --</option>
                                    @foreach ($nhaTros as $nhaTro)
                                        <option value="{{ $nhaTro->id }}"
                                            {{ request('nha_tro_id') == $nhaTro->id ? 'selected' : '' }}>
                                            {{ $nhaTro->ten_toa_nha }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tên phòng</label>
                                <input type="text" name="ten_phong" class="form-control"
                                    value="{{ request('ten_phong') }}">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Loại phòng</label>
                                <select name="loai_phong" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="van_phong" {{ request('loai_phong') == 'van_phong' ? 'selected' : '' }}>
                                        Văn phòng</option>
                                    <option value="can_ho" {{ request('loai_phong') == 'can_ho' ? 'selected' : '' }}>Căn Hộ
                                    </option>
                                    <option value="phong_cho_thue"
                                        {{ request('loai_phong') == 'phong_cho_thue' ? 'selected' : '' }}>Phòng cho thuê
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="trong" {{ request('status') == 'trong' ? 'selected' : '' }}>Trống
                                    </option>
                                    <option value="da_thue" {{ request('status') == 'da_thue' ? 'selected' : '' }}>Đã thuê
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary w-100">Xoá lọc</a>
                            </div>
                        </form> --}}


                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Mô tả</th>
                                    <th>Facebook</th>
                                    <th>Google</th>
                                    <th>Instagram</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $member)
                                    <tr>
                                        <td><img src="{{ asset($member->image) }}" alt="" width="50" height="50"></td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->description }}</td>
                                        <td><a href="{{ $member->facebook }}" target="_blank">{{ $member->facebook }}</a>
                                        </td>
                                        <td><a href="{{ $member->google }}" target="_blank">{{ $member->google }}</a></td>
                                        <td><a href="{{ $member->instagram }}" target="_blank">{{ $member->instagram }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.members.edit', $member) }}"
                                                class="btn btn-warning btn-sm">Sửa</a>
                                            <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>


                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
