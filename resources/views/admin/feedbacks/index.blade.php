@extends('admin.index')
@section('contentadmin')
   
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
               
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách cảm nghĩ</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm cảm nghĩ'))
                            <a href="{{ route('feedbacks.create') }}" class="btn btn-success rounded-pill">Thêm cảm nghĩ</a>
                        @endif
                    </div>
                    <form method="GET" action="{{ route('feedbacks.index') }}" class="row mb-4">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control" placeholder="Tìm theo tên"
                                value="{{ request('name') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="position" class="form-control" placeholder="Tìm theo chức vụ"
                                value="{{ request('position') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="active" class="form-select">
                                <option value="">-- Trạng thái --</option>
                                <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Tìm kiếm</button>
                            <a href="{{ route('feedbacks.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>

                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên</th>
                                    <th>Chức vụ</th>
                                    <th>Hình ảnh</th>
                                    {{-- <th>Nội dung</th> --}}
                                    <th>Hiển thị</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($feedbacks as $fb)
                                    <tr>
                                        <td>{{ $fb->name }}</td>
                                        <td>{{ $fb->position }}</td>
                                        <td>
                                            @if ($fb->image)
                                                <img src="{{ asset($fb->image) }}" height="60">
                                            @endif
                                        </td>
                                        {{-- <td>{{ Str::limit($fb->message, 60) }}</td> --}}
                                        <td>{{ $fb->active ? '✔️ Có' : '❌ Không' }}</td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa cảm nghĩ'))
                                                <a href="{{ route('feedbacks.edit', $fb) }}"
                                                    class="btn btn-sm btn-warning"><i class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa cảm nghĩ'))
                                                <form action="{{ route('feedbacks.destroy', $fb) }}" method="POST"
                                                    class="d-inline-block" onsubmit="return confirm('Xóa cảm nghĩ này?')">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-info btn-sm btn-xem-chi-tiet"
                                                data-bs-toggle="modal" data-bs-target="#modalChiTiet"
                                                data-ten="{{ $fb->name }}" data-chucvu="{{ $fb->position }}"
                                                data-noidung="{{ $fb->message }}"
                                                data-anh="{{ $fb->image ? asset($fb->image) : '' }}">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Không có dữ liệu cảm nghĩ.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal chi tiết cảm nghĩ -->
        <div class="modal fade" id="modalChiTiet" tabindex="-1" aria-labelledby="modalChiTietLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-start flex-wrap">
                            <div class="me-4 mb-3">
                                <img id="ct-anh" src="" alt="Ảnh" class="rounded-circle"
                                    style="width: 160px; height: 160px; object-fit: cover;">
                            </div>
                            <div style="flex: 1 1 300px;">
                                <h5 class="text-danger fw-bold" id="ct-ten">Tên</h5>
                                <p class="text-primary fw-semibold" id="ct-chucvu">Chức vụ</p>
                                <p id="ct-noidung" class="text-justify"></p>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.btn-xem-chi-tiet');

                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        document.getElementById('ct-ten').textContent = this.dataset.ten;
                        document.getElementById('ct-chucvu').textContent = this.dataset.chucvu ||
                            '(Không có)';
                        document.getElementById('ct-noidung').textContent = this.dataset.noidung;

                        const anh = this.dataset.anh;
                        document.getElementById('ct-anh').src = anh ||
                            'https://via.placeholder.com/160?text=No+Image';
                    });
                });
            });
        </script>
    </div>
@endsection
