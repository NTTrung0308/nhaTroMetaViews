@extends('admin.index')
@section('contentadmin')
  



    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                 
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung Phòng trọ</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm phòng trọ'))
                            <a href="{{ route('rooms.create') }}" class="btn btn-success rounded-pill">Thêm phòng mới</a>
                        @endif
                    </div>
                    <div class="row">
                        <form method="GET" action="{{ route('rooms.index') }}" class="row align-items-end g-3 mb-4">
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
                        </form>


                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tòa nhà</th>
                                    <th>Tên phòng</th>
                                    <th>Mã phòng</th>
                                    <th>Diện tích (m²)</th>
                                    <th>Giá thuê</th>
                                    <th>Loại phòng</th>
                                    <th>Trạng thái</th>
                                    <th>Đã thuê</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $room)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $room->nhaTro->ten_toa_nha ?? 'N/A' }}</td>
                                        <td>{{ $room->ten_phong }}</td>
                                        <td>{{ $room->ma_phong }}</td>
                                        <td>{{ $room->dien_tich }} m²</td>
                                        <td>{{ number_format($room->gia_thue) }} VNĐ</td>
                                        <td>
                                            @if ($room->loai_phong == 'van_phong')
                                                Văn phòng
                                            @elseif($room->loai_phong == 'can_ho')
                                                Căn Hộ
                                            @elseif($room->loai_phong == 'phong_cho_thue')
                                                Phòng cho thuê
                                            @else
                                                Khác
                                            @endif





                                        <td>
                                            <span
                                                class="badge bg-{{ $room->status == 'trong' ? 'success' : 'secondary' }}">
                                                {{ $room->status == 'trong' ? 'Trống' : 'Đã thuê' }}
                                            </span>
                                        </td>
                                        <td>{{ $room->da_thue ? 'Có' : 'Không' }}</td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa phòng trọ'))
                                                <a href="{{ route('rooms.edit', $room->id) }}"
                                                    class="btn btn-sm btn-warning"><i class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa phòng trọ'))
                                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                                                    style="display:inline-block"
                                                    onsubmit="return confirm('Bạn có chắc muốn xoá phòng này không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif
                                            <button class="btn btn-sm btn-info btn-show-detail"
                                                data-id="{{ $room->id }}" data-ten-phong="{{ $room->ten_phong }}"
                                                data-ma-phong="{{ $room->ma_phong }}"
                                                data-nha-tro="{{ $room->nhaTro->ten_toa_nha ?? 'N/A' }}"
                                                data-dien-tich="{{ $room->dien_tich }}"
                                                data-gia-thue="{{ number_format($room->gia_thue) }}"
                                                data-loai-phong="{{ $room->loai_phong }}"
                                                data-ban-cong="{{ $room->bancong }}"
                                                data-trang-thai="{{ ucfirst($room->status) }}"
                                                data-da-thue="{{ $room->da_thue ? 'Có' : 'Không' }}">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">Không có phòng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $rooms->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal chi tiết -->
    <div class="modal fade" id="roomDetailModal" tabindex="-1" aria-labelledby="roomDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomDetailModalLabel">Chi tiết phòng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Tên phòng:</strong> <span id="modal-ten-phong"></span></li>
                        <li class="list-group-item"><strong>Mã phòng:</strong> <span id="modal-ma-phong"></span></li>
                        <li class="list-group-item"><strong>Nhà trọ:</strong> <span id="modal-nha-tro"></span></li>
                        <li class="list-group-item"><strong>Diện tích:</strong> <span id="modal-dien-tich"></span> m²</li>
                        <li class="list-group-item"><strong>Giá thuê:</strong> <span id="modal-gia-thue"></span> VNĐ</li>
                        <li class="list-group-item"><strong>Loại phòng:</strong> <span id="modal-loai-phong"></span></li>
                        <li class="list-group-item"><strong>Trạng thái:</strong> <span id="modal-trang-thai"></span></li>
                        <li class="list-group-item"><strong>Có ban công không:</strong> <span id="modal-ban-cong"></span></li>
                        <li class="list-group-item"><strong>Đã thuê:</strong> <span id="modal-da-thue"></span></li>
                    </ul>
                    <div id="roomImageCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-images">
                            {{-- Sẽ được render bằng JS --}}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomImageCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomImageCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailButtons = document.querySelectorAll('.btn-show-detail');
            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modal-ten-phong').textContent = this.dataset.tenPhong;
                    document.getElementById('modal-ma-phong').textContent = this.dataset.maPhong;
                    document.getElementById('modal-nha-tro').textContent = this.dataset.nhaTro;
                    document.getElementById('modal-dien-tich').textContent = this.dataset.dienTich;
                    document.getElementById('modal-gia-thue').textContent = this.dataset.giaThue;
                    document.getElementById('modal-loai-phong').textContent = convertLoaiPhong(this
                        .dataset.loaiPhong);
                    document.getElementById('modal-trang-thai').textContent = this.dataset
                        .trangThai;
                    document.getElementById('modal-da-thue').textContent = this.dataset.daThue;
                    document.getElementById('modal-ban-cong').textContent = this.dataset.banCong;


                    // Hiện modal
                    const modal = new bootstrap.Modal(document.getElementById('roomDetailModal'));
                    modal.show();
                });
            });

            function convertLoaiPhong(loai) {
                switch (loai) {
                    case 'van_phong':
                        return 'Văn phòng';
                    case 'can_ho':
                        return 'Căn Hộ';
                    case 'phong_cho_thue':
                        return 'Phòng cho thuê';
                    default:
                        return 'Khác';
                }
            }
        });
    </script>
@endsection
