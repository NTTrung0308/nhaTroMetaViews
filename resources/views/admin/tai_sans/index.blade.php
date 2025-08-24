@extends('admin.index')
@section('contentadmin')
  
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
               
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách tài sản</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm tài sản'))
                            <a href="{{ route('tai-sans.create') }}" class="btn btn-success rounded-pill">Thêm tài sản</a>
                        @endif
                    </div>
                    <hr>
                    <form method="GET" action="{{ route('tai-sans.index') }}" class="row align-items-end g-3 mb-4">
                        <div class="col-md-6">
                            <input type="text" name="ten_tai_san" class="form-control" placeholder="Tìm theo tên tài sản"
                                value="{{ request('ten_tai_san') }}">
                        </div>
                        <div class="col-md-5">
                            <select name="tinh_trang" class="form-control">
                                <option value="">-- Tất cả tình trạng --</option>
                                <option value="Mới" {{ request('tinh_trang') == 'Mới' ? 'selected' : '' }}>Mới</option>
                                <option value="Cũ" {{ request('tinh_trang') == 'Cũ' ? 'selected' : '' }}>Cũ</option>
                                <option value="Hỏng" {{ request('tinh_trang') == 'Hỏng' ? 'selected' : '' }}>Hỏng</option>
                            </select>
                        </div>
                        <div class="col-md-1 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Tên</th>
                                    <th>Ngày mua</th>
                                    <th>Giá trị</th>
                                    <th>Tình trạng</th>

                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($taiSans as $ts)
                                    <tr>
                                        <td>{{ $ts->ma_tai_san }}</td>
                                        <td>{{ $ts->ten_tai_san }}</td>
                                        <td>{{ $ts->ngay_mua }}</td>
                                        <td>{{ number_format($ts->gia_tri) }}</td>
                                        <td>{{ $ts->tinh_trang }}</td>

                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa tài sản'))
                                                <a href="{{ route('tai-sans.edit', $ts->id) }}"
                                                    class="btn btn-warning btn-sm"><i
                                                        class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa tài sản'))
                                                <form action="{{ route('tai-sans.destroy', $ts->id) }}" method="POST"
                                                    style="display:inline-block">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Xóa tài sản?')"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif

                                            <button class="btn btn-info btn-sm view-details" data-id="{{ $ts->id }}"
                                                data-ma="{{ $ts->ma_tai_san }}" data-ten="{{ $ts->ten_tai_san }}"
                                                data-ngay="{{ $ts->ngay_mua }}"
                                                data-gia="{{ number_format($ts->gia_tri) }}"
                                                data-tinhtrang="{{ $ts->tinh_trang }}" data-ghichu="{{ $ts->ghi_chu }}">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Không có dữ liệu tài sản.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $taiSans->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="taiSanModal" tabindex="-1" aria-labelledby="taiSanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taiSanModalLabel">Chi tiết tài sản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Mã tài sản:</strong> <span id="modal-ma"></span></p>
                    <p><strong>Tên tài sản:</strong> <span id="modal-ten"></span></p>
                    <p><strong>Ngày mua:</strong> <span id="modal-ngay"></span></p>
                    <p><strong>Giá trị:</strong> <span id="modal-gia"></span></p>
                    <p><strong>Tình trạng:</strong> <span id="modal-tinhtrang"></span></p>
                    <p><strong>Ghi chú:</strong> <span id="modal-ghichu"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('taiSanModal'));

            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modal-ma').innerText = this.dataset.ma;
                    document.getElementById('modal-ten').innerText = this.dataset.ten;
                    document.getElementById('modal-ngay').innerText = this.dataset.ngay;
                    document.getElementById('modal-gia').innerText = this.dataset.gia;
                    document.getElementById('modal-tinhtrang').innerText = this.dataset.tinhtrang;
                    document.getElementById('modal-ghichu').innerText = this.dataset.ghichu;

                    modal.show();
                });
            });
        });
    </script>
@endsection
