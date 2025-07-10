<!-- resources/views/admin/roles/create.blade.php -->
@extends('admin.index')
@section('contentadmin')
 @php
        $protectedRoles = ['Super Admin', 'nguoi-thue-tro'];
        $isProtected = in_array($role->name, $protectedRoles);
    @endphp
    <div class="pagetitle">
        <h1>Quản lý quyền người dùng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item">Tài khoản quyền</li>
                <li class="breadcrumb-item active">Sửa quyền người dùng</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 d-sm-flex justify-content-between align-items-center">
                            <h5 class="card-title">Sửa quyền người dùng</h5>

                            <a href="{{ route('admin.roles.index') }}" class="btn btn-success">
                                <i class="bi bi-arrow-left-circle-fill"></i>
                                Trở lại danh sách Quyền</a>
                        </div>
                            @if ($isProtected)
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <strong>Cảnh báo:</strong> Đây là vai trò hệ thống. Bạn không thể thay đổi tên của quyền của vai trò này.
                            </div>
                        @endif

                        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $role->name }}" placeholder="Tên Vai trò"  {{ $isProtected ? 'disabled' : '' }}>
                                    <label for="name">Tên Vai trò</label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="roles">Vai trò</label>
                               <table class="table table-bordered table-hover">
    <tbody>
        {{-- Dùng @forelse để xử lý trường hợp không có quyền nào --}}
        @forelse ($permissions as $permission)
            {{-- 
                Mở một dòng mới <tr> khi:
                1. Đây là phần tử ĐẦU TIÊN của vòng lặp ($loop->first)
                2. Hoặc khi chỉ số của phần tử chia cho 4 có số dư là 1 (vd: phần tử thứ 5, 9, 13...)
                   ($loop->iteration là chỉ số bắt đầu từ 1)
            --}}
            @if ($loop->first || $loop->iteration % 4 == 1)
                <tr>
            @endif
            <td style="width: 25%;">
                <div class="checkbox-wrapper-61">
                    <input type="checkbox" name="permissions[]" class="check"
                        value="{{ $permission->id }}" id="perm-{{ $permission->id }}"
                        {{-- 
                            Logic kiểm tra `checked` này đã rất tốt và được giữ nguyên.
                            Nó xử lý cả khi tải trang lần đầu và khi validation thất bại.
                        --}}
                        @if(is_array(old('permissions')) && in_array($permission->id, old('permissions')))
                            checked
                        @elseif(!old('permissions') && $role->permissions->contains($permission->id))
                            checked
                        @endif
                        />
                    <label for="perm-{{ $permission->id }}" class="label">
                        <svg width="45" height="45" viewbox="0 0 95 95">
                            <rect x="30" y="20" width="50" height="50" stroke="black"
                                fill="none" />
                            <g transform="translate(0,-952.36222)">
                                <path
                                    d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                    stroke="black" stroke-width="3" fill="none" class="path1" />
                            </g>
                        </svg>
                        <span> {{ $permission->name }}</span>
                    </label>
                </div>
            </td>

            {{-- 
                Đóng thẻ </tr> khi:
                1. Chỉ số của phần tử chia hết cho 4 ($loop->iteration % 4 == 0)
                2. Hoặc khi đây là phần tử CUỐI CÙNG của vòng lặp ($loop->last)
                   (Điều này xử lý trường hợp tổng số quyền không chia hết cho 4)
            --}}
            @if ($loop->iteration % 4 == 0 || $loop->last)
                </tr>
            @endif

        @empty
            {{-- Hiển thị nếu không có quyền nào trong database --}}
            <tr>
                <td colspan="4" class="text-center">Không có quyền nào được định nghĩa.</td>
            </tr>
        @endforelse
    </tbody>
</table>
                                @error('permission')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Cập nhật vai trò</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- 
    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Correct the method to PUT for updating -->

        <label for="name">Tên Vai trò</label>
        <input type="text" name="name" id="name" value="{{ $role->name }}" required>
        <br>

        <label for="permissions">Quyền</label><br>
        @foreach ($permissions as $permission)
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
            <label>{{ $permission->name }}</label><br>
        @endforeach
        <br>

        <button type="submit">Cập nhật vai trò</button>
    </form> --}}

{{-- <a href="{{ route('admin.roles.index') }}">Trở lại danh sách vai trò</a> --}}
