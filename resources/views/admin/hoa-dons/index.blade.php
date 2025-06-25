@extends('admin.index')
@section('contentadmin')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh Sách Hóa Đơn</h1>
        <a href="{{ route('hoa-dons.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-file-invoice-dollar"></i> Tạo Hóa Đơn Hàng Loạt
        </a>
    </div>
    <form method="GET" action="{{ route('hoa-dons.index') }}" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="nha_tro_id" class="form-label">Nhà trọ</label>
            <select name="nha_tro_id" id="nha_tro_id" class="form-select">
                <option value="">-- Tất cả nhà trọ --</option>
                @foreach ($nhaTros as $nhaTro)
                    <option value="{{ $nhaTro->id }}" {{ request('nha_tro_id') == $nhaTro->id ? 'selected' : '' }}>
                        {{ $nhaTro->ten_toa_nha }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="room_id" class="form-label">Phòng</label>
            <select name="room_id" id="room_id" class="form-select" {{ !request('nha_tro_id') ? 'disabled' : '' }}>
                <option value="">-- Chọn nhà trọ trước --</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="thang" class="form-label">Tháng</label>
            <input type="number" name="thang" id="thang" class="form-control" value="{{ request('thang') }}"
                placeholder="VD: 7">
        </div>

        <div class="col-md-2">
            <label for="nam" class="form-label">Năm</label>
            <input type="number" name="nam" id="nam" class="form-control" value="{{ request('nam') }}"
                placeholder="VD: 2023">
        </div>

        <div class="col-md-2">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select name="trang_thai" id="trang_thai" class="form-select">
                <option value="">-- Tất cả --</option>
                @foreach ($statuses as $key => $value)
                    <option value="{{ $key }}" {{ request('trang_thai') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 mt-3 text-end">
            <button type="submit" class="btn btn-info">
                <i class="fa fa-search"></i> Lọc
            </button>
            <a href="{{ route('hoa-dons.index') }}" class="btn btn-secondary">
                <i class="fa fa-times"></i> Xóa bộ lọc
            </a>
        </div>
    </form>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Mã HĐ</th>
                        <th>Phòng</th>
                        <th>Người Thuê</th>
                        <th>Kỳ HĐ</th>
                        <th class="text-end">Tổng Phải Trả</th>
                        <th class="text-end">Còn Nợ</th>
                        <th class="text-center">Trạng Thái</th>
                        <th class="text-end">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hoaDons as $hd)
                        <tr>
                            <td>{{ $hd->ma_hoa_don }}</td>
                            <td>{{ $hd->room->ten_phong ?? 'N/A' }}</td>
                            <td>{{ $hd->user->name ?? 'N/A' }}</td>
                            <td>Tháng {{ $hd->thang }}/{{ $hd->nam }}</td>
                            <td class="text-end">{{ number_format($hd->tong_tien + $hd->no_ky_truoc, 0) }} đ</td>
                            <td class="text-end fw-bold {{ $hd->con_no > 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($hd->con_no, 0) }} đ</td>
                            <td class="text-center">
                                @if ($hd->trang_thai == 'da_thanh_toan')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @elseif($hd->trang_thai == 'qua_han')
                                    <span class="badge bg-danger">Quá hạn</span>
                                @elseif($hd->trang_thai == 'da_huy')
                                    <span class="badge bg-secondary">Đã hủy</span>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('hoa-dons.destroy', $hd->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?');">
                                    <a href="{{ route('hoa-dons.show', $hd->id) }}" class="btn btn-sm btn-info"
                                        title="Xem"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('hoa-dons.edit', $hd->id) }}" class="btn btn-sm btn-warning"
                                        title="Cập nhật thanh toán"><i class="fa fa-dollar-sign"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Chưa có hóa đơn nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class=" p-nav text-end d-flex justify-content-end">
            {{ $hoaDons->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nhaTroSelect = document.getElementById('nha_tro_id');
            const roomSelect = document.getElementById('room_id');
            const oldRoomId = '{{ request('room_id') }}'; // Lấy ID phòng đã lọc trước đó

            function fetchRooms(nhaTroId, selectedRoomId = null) {
                if (!nhaTroId) {
                    roomSelect.innerHTML = '<option value="">-- Chọn nhà trọ trước --</option>';
                    roomSelect.disabled = true;
                    return;
                }

                // Gọi API để lấy danh sách phòng
                fetch(`/api/rooms-by-nha-tro/${nhaTroId}`)
                    .then(response => response.json())
                    .then(data => {
                        roomSelect.innerHTML = '<option value="">-- Tất cả phòng --</option>';
                        data.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                            option.textContent = room.ten_phong;
                            if (room.id == selectedRoomId) {
                                option.selected = true;
                            }
                            roomSelect.appendChild(option);
                        });
                        roomSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy danh sách phòng:', error);
                        roomSelect.disabled = true;
                    });
            }

            // Sự kiện khi thay đổi nhà trọ
            nhaTroSelect.addEventListener('change', function() {
                fetchRooms(this.value);
            });

            // Xử lý khi tải lại trang (để giữ lại giá trị phòng đã lọc)
            if (nhaTroSelect.value) {
                fetchRooms(nhaTroSelect.value, oldRoomId);
            }
        });
    </script>
@endsection
