<!-- resources/views/admin/roles/index.blade.php -->
@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Quản lý tài khoản</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active">Tài khoản người dùng</li>
            </ol>
        </nav>
    </div>


    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="col-12 d-sm-flex justify-content-between align-items-center">
                            <h5 class="card-title">Quản lý vai trò web </h5>
                            @if (auth()->user()->hasPermissionTo('Thêm vai trò'))
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-success">

                                    <i class="bi bi-check-circle"></i>

                                    Tạo mới Vai trò</a>
                            @endif
                        </div>



                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table ">
                                <thead>
                                    <tr>

                                        <th>
                                            Tên vai trò
                                        </th>
                                        <th>Quyền</th>
                                        <th>Ngày tạo</th>

                                        <th colspan="2">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key => $role)
                                        <tr>
                                          
                                            <td>
                                                {{ $role->name }}
                                            </td>

                                           
                                            <td>
                                                @if ($role->permissions->isNotEmpty())
                                                @foreach ($role->permissions as $permission)
                                                        <span
                                                            class="badge rounded-pill bg-success">{{ $permission->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không có Quyền</span>
                                                @endif


                                            </td>
                                            <td>
                                                {{ $role->created_at->diffForHumans() }}
                                            </td>

                                            <td colspan="2">
                                                @if (auth()->user()->hasPermissionTo('Sửa vai trò'))
                                                    <a class="btn btn-warning"
                                                        href="{{ route('admin.roles.edit', $role->id) }}">Chỉnh sửa</a>
                                                @endif
                                                @if (auth()->user()->hasPermissionTo('Xóa vai trò'))
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">Xóa</button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class=" p-nav text-end d-flex justify-content-center">
                                {{ $roles->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <h1>Danh sách Vai trò</h1> --}}

{{-- @if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.roles.create') }}">Tạo vai trò mới</a>

<table border="1">
    <thead>
        <tr>
            <th>Tên Vai trò</th>
            <th>Quyền</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    @foreach ($role->permissions as $permission)
                        {{ $permission->name }} <br>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.roles.edit', $role->id) }}">Chỉnh sửa</a> |
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}
@endsection

