@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Phương tiện</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Phương tiện</li>
            </ol>
        </nav>
    </div>




    <div class="row">


        <div class="card">
            <div class="card-body">
                <div class="col-12 d-sm-flex justify-content-between align-items-center">
                    <h5 class="card-title">Phương tiện</h5>
                    @if (auth()->user()->hasPermissionTo('Thêm phương tiện'))
                        <a href="{{ route('admin.phuong_tiens.create', ['user_id' => request('user_id')]) }}"
                            class="btn btn-success rounded-pill"> Thêm phương tiện</a>

                    @endif
                </div>
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('admin.phuong_tiens.index') }}" class="row align-items-end g-3 mb-4">
                        <div class="col-md-11">
                            <label class="form-label">Người dùng</label>
                            <select name="user_id" class="form-select select_ted">
                                <option value="">-- Tất cả --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tên xe</th>
                                <th>Biển số</th>
                                <th>Loại</th>
                                <th>Chủ xe</th>
                                <th>Khách hàng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($phuongTiens as $pt)
                                <tr>
                                    <td>{{ $pt->name }}</td>
                                    <td>{{ $pt->bien_so }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $pt->loai_phuong_tien)) }}</td>
                                    <td>{{ $pt->ten_chu_xe }}</td>
                                    <td>{{ $pt->user->name ?? 'Chưa gán' }}</td>
                                    <td>
                                        @if (auth()->user()->hasPermissionTo('Sửa phương tiện'))

                                            <a href="{{ route('admin.phuong_tiens.edit', $pt->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-wrench"></i></a>
                                        @endif
                                        @if (auth()->user()->hasPermissionTo('Xóa phương tiện'))

                                            <form action="{{ route('admin.phuong_tiens.destroy', $pt->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button onclick="return confirm('Xoá phương tiện này?')"
                                                    class="btn btn-danger btn-sm"><i
                                                        class="bi bi-trash text-white"></i></button>
                                            </form>
                                        @endif


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Không có dữ liệu.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class=" p-nav text-end d-flex justify-content-end">
                    {{ $phuongTiens->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
@endsection
