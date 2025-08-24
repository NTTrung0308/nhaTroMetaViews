@extends('admin.index')
@section('contentadmin')
   
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                 <h5 class="card-header">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Tài sản chung riêng nhà trọ</li>
                        </ol>
                    </nav>
                </h5>
                <div class="card-body">

                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách Tài sản chung riêng</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm tài sản trọ'))
                            <a href="{{ route('tai_san_chung_riengs.create') }}" class="btn btn-success rounded-pill">Thêm
                                mới</a>
                        @endif
                    </div>
                    <hr>
                    <form method="GET" action="{{ route('tai_san_chung_riengs.index') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="ten_toa_nha" class="form-control"
                                    placeholder="Tìm theo tên tòa nhà" value="{{ request('ten_toa_nha') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="ma_phong" class="form-control" placeholder="Tìm theo mã phòng"
                                    value="{{ request('ma_phong') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>



                    <div class="table-responsive">

                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nhà trọ</th>
                                    <th>Phòng trọ</th>
                                    <th>Tài sản chung</th>
                                    <th>Tài sản riêng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nhaTro->ten_toa_nha ?? 'Không rõ' }}</td>
                                        <td>{{ $item->room->ten_phong ?? 'Không có' }}
                                            ({{ $item->room->ma_phong ?? 'Không có' }})
                                        </td>
                                        <td>
                                            @foreach ($item->taiSanChungs as $tsc)
                                                {{ $tsc->taiSan->ten_tai_san }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($item->taiSanRiengs as $tsr)
                                                {{ $tsr->taiSan->ten_tai_san }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa tài sản trọ'))
                                                <a href="{{ route('tai_san_chung_riengs.edit', $item->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa tài sản trọ'))
                                                <form action="{{ route('tai_san_chung_riengs.destroy', $item->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif
                                            <button class="btn btn-sm btn-info btn-xem-chi-tiet"
                                                data-id="{{ $item->id }}"
                                                data-toa-nha="{{ $item->nhaTro->ten_toa_nha ?? 'Không rõ' }}"
                                                data-phong="{{ $item->room->ten_phong ?? 'Không có' }}"
                                                data-ma-phong="{{ $item->room->ma_phong ?? 'Không có' }}"
                                                data-ts-chung="{{ $item->taiSanChungs->pluck('taiSan.ten_tai_san')->implode(', ') }}"
                                                data-ts-rieng="{{ $item->taiSanRiengs->pluck('taiSan.ten_tai_san')->implode(', ') }}">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Không có dữ liệu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=" p-nav text-end d-flex justify-content-end">
                    {{ $list->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalChiTiet" tabindex="-1" aria-labelledby="modalChiTietLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalChiTietLabel">Chi tiết tài sản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">

                    <p><strong>Tòa nhà:</strong> <span id="ct-toa-nha"></span></p>
                    <p><strong>Phòng:</strong> <span id="ct-phong"></span></p>
                    <p><strong>Mã phòng:</strong> <span id="ct-ma-phong"></span></p>
                    <p><strong>Tài sản chung:</strong> <span id="ct-ts-chung"></span></p>
                    <p><strong>Tài sản riêng:</strong> <span id="ct-ts-rieng"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-xem-chi-tiet');

            buttons.forEach(button => {
                button.addEventListener('click', function() {

                    document.getElementById('ct-toa-nha').textContent = this.dataset.toaNha;
                    document.getElementById('ct-phong').textContent = this.dataset.phong;
                    document.getElementById('ct-ma-phong').textContent = this.dataset.maPhong;
                    document.getElementById('ct-ts-chung').textContent = this.dataset.tsChung;
                    document.getElementById('ct-ts-rieng').textContent = this.dataset.tsRieng;

                    const modal = new bootstrap.Modal(document.getElementById('modalChiTiet'));
                    modal.show();
                });
            });
        });
    </script>

@endsection
