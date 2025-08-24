@extends('admin.index')
@section('contentadmin')


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                 <h5 class="card-header">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Thành viên</li>

                        </ol>
                    </nav>
                </h5>
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thành viên</h5>
                        {{-- @if (auth()->user()->hasPermissionTo('Thêm phòng trọ')) --}}
                        <a href="{{ route('admin.members.create') }}" class="btn btn-success rounded-pill">Thêm thành viên</a>
                        {{-- @endif --}}
                    </div>
                    <hr>
                   
                        <form method="GET" action="{{ route('admin.members.index') }}" class="row align-items-end g-3 mb-4">
                          
                            <div class="col-md-10">
                                <input type="text" name="ten" class="form-control"
                                    value="{{ request('ten') }}" placeholder="Nhập tên thành viên">
                            </div>

                           
                          

                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                <a href="{{ route('admin.members.index') }}" class="btn btn-secondary w-100">Xoá lọc</a>
                            </div>
                        </form>


                 
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
                                        <td><a href="{{ $member->facebook }}" target="_blank">Đường dẫn Facebook</a>
                                        </td>
                                        <td><a href="{{ $member->google }}" target="_blank">Đường dẫn Google</a></td>
                                        <td><a href="{{ $member->instagram }}" target="_blank">Đường dẫn Instagram</a>
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
