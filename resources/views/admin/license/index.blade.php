@extends('admin.index')

@section('contentadmin')
   



    <div class="row">

        <div class="col-lg-12">

            <div class="card">
               
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách License Keys</h5>
                        {{-- @if (auth()->user()->hasPermissionTo('Thêm phòng trọ')) --}}
                        <a href="{{ route('license.create') }}" class="btn btn-success rounded-pill">Thêm mới key</a>
                        {{-- @endif --}}
                    </div>
                  
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>License Key</th>
                                    <th>Người dùng</th>
                                    <th>Số phòng tối đa</th>
                                    <th>Trạng thái</th>
                                    <th>Đã sử dụng</th>
                                    <th>Ngày tạo</th>
                                    {{-- <th width="150">Hành động</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($licenseKeys as $key)
                                    <tr>
                                        <td>{{ $key->id }}</td>
                                        <td>
                                            <span class="badge bg-dark">{{ $key->key }}</span>
                                        </td>
                                        <td>
                                            @if ($key->user)
                                                {{ $key->user->name }} (ID: {{ $key->user->id }})
                                            @else
                                                <span class="text-muted">Chưa gán</span>
                                            @endif
                                        </td>
                                        <td>{{ $key->max_rooms }}</td>
                                        <td>
                                            @if ($key->is_active)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-danger">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($key->is_used)
                                                <span class="badge bg-warning text-dark">Đã dùng</span>
                                            @else
                                                <span class="badge bg-secondary">Chưa dùng</span>
                                            @endif
                                        </td>
                                        <td>{{ $key->created_at->format('d/m/Y H:i') }}</td>
                                        {{-- <td>
                                <a href="{{ route('admin.license.edit', $key->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.license.destroy', $key->id) }}" method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa key này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Chưa có License Key nào</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                {{ $licenseKeys->appends(request()->query())->links('pagination::bootstrap-4') }}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
