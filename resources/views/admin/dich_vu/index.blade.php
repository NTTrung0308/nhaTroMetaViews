@extends('admin.index')
@section('contentadmin')
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung dịch vụ</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm dịch vụ'))
                            <a href="{{ route('dichvus.create') }}" class="btn btn-success rounded-pill">Thêm Dịch Vụ
                                Mới</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Tên dịch vụ</th>
                                    <th scope="col">Mã dịch vụ</th>
                                    <th scope="col">Đơn vị tính</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($dichVus as $dichvu)
                                    <tr>
                                        <td>{{ $dichvu->ten_dich_vu }}</td>
                                        <td>{{ $dichvu->ma_dich_vu }}</td>
                                        <td>{{ $dichvu->donViTinh ? $dichvu->donViTinh->ma_don_vi . ' - ' . $dichvu->donViTinh->ten_day_du : '-' }}
                                        </td>

                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa dịch vụ'))
                                                <a href="{{ route('dichvus.edit', $dichvu->id) }}"
                                                    class="btn btn-warning"><i class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa dịch vụ'))
                                                @php
                                                    $maKhongXoa = ['dien_sinh_hoat', 'nuoc', 'mang'];
                                                    $isDisabled = in_array($dichvu->ma_dich_vu, $maKhongXoa);
                                                @endphp

                                                <form action="{{ route('dichvus.destroy', $dichvu->id) }}" method="POST"
                                                    style="display:inline-block" class="btn btn-danger"
                                                    onsubmit="return {{ $isDisabled ? 'false' : 'confirm(\'Bạn có chắc muốn xóa dịch vụ này?\')' }};">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        {{ $isDisabled ? 'disabled title=Không thể xóa dịch vụ mặc định' : '' }}
                                                        style="background:none;border:none;{{ $isDisabled ? 'opacity:0.5;cursor:not-allowed;' : 'color:red;cursor:pointer;' }}padding:0;">
                                                        <i class="icon-base bx bx-trash text-white"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-info btn-xem-chi-tiet"
                                                data-ten="{{ $dichvu->ten_dich_vu }}" data-ma="{{ $dichvu->ma_dich_vu }}"
                                                data-donvi="{{ $dichvu->donViTinh ? $dichvu->donViTinh->ma_don_vi . ' - ' . $dichvu->donViTinh->ten_day_du : '-' }}"
                                                data-dongia="{{ number_format($dichvu->don_gia) }}"
                                                data-mota="{{ $dichvu->mo_ta }}" data-bs-toggle="modal"
                                                data-bs-target="#modalChiTiet">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Không có dữ liệu dịch vụ.</td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $dichVus->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalChiTiet" tabindex="-1" aria-labelledby="modalChiTietLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalChiTietLabel">Chi tiết dịch vụ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Tên dịch vụ:</strong> <span id="ct-ten"></span></p>
                            <p><strong>Mã dịch vụ:</strong> <span id="ct-ma"></span></p>
                            <p><strong>Đơn vị tính:</strong> <span id="ct-donvi"></span></p>
                            <p><strong>Mô tả:</strong> <span id="ct-mota"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
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
                    document.getElementById('ct-ma').textContent = this.dataset.ma;
                    document.getElementById('ct-donvi').textContent = this.dataset.donvi;
                    document.getElementById('ct-mota').textContent = this.dataset.mota;
                });
            });
        });
    </script>
@endsection
