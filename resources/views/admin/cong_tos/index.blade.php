@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Công tơ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Công tơ</li>
            </ol>
        </nav>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách công tơ</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm dịch vụ'))
                            <a href="{{ route('admin.cong_tos.create') }}" class="btn btn-success rounded-pill">Thêm công
                                tơ</a>
                        @endif
                    </div>
                    <form method="GET" action="{{ route('admin.cong_tos.index') }}" class="row mb-3 align-items-end"
                        id="filter-form">
                        <div class="col-md-5">
                            <label for="nha_tro_id">Tòa nhà</label>
                            <select name="nha_tro_id" id="nha_tro_id" class="form-select">
                                <option value="">-- Tất cả --</option>
                                @foreach ($nhaTros as $nhaTro)
                                    <option value="{{ $nhaTro->id }}"
                                        {{ request('nha_tro_id') == $nhaTro->id ? 'selected' : '' }}>
                                        {{ $nhaTro->ten_toa_nha }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label for="room_id">Phòng</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">-- Tất cả --</option>
                                {{-- JS sẽ thêm các option phòng ở đây --}}
                            </select>
                        </div>

                        <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Xoá lọc</a>
                            </div>
                    </form>

                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Loại</th>
                                    <th>Chỉ số đầu</th>
                                    <th>Phòng</th>
                                    <th>Nhà trọ</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($congTos as $ct)
                                    <tr>
                                        <td>{{ $ct->id }}</td>
                                        <td>{{ ucfirst($ct->loai) }}</td>
                                        <td>{{ number_format($ct->chi_so_dau) }}</td>
                                        <td>{{ $ct->room->ten_phong ?? 'Chưa gán' }} - {{$ct->room->ma_phong ?? 'Chưa gán'}}</td>
                                        <td>{{ $ct->nhaTro->ten_toa_nha ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('admin.cong_tos.edit', $ct) }}"
                                                class="btn btn-sm btn-primary"><i class="bi bi-wrench"></i></a>
                                            <form action="{{ route('admin.cong_tos.destroy', $ct) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('bạn có chắc muốn xóa?')"><i
                                                                class="bi bi-trash text-white"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                               @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Không có dữ liệu công tơ.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>



                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $congTos->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nhaTroSelect = document.getElementById('nha_tro_id');
            const roomSelect = document.getElementById('room_id');

            const selectedRoomId = '{{ request('room_id') }}';

            function loadRooms(nhaTroId, selected = null) {
                roomSelect.innerHTML = '<option value="">-- Tất cả --</option>';

                if (!nhaTroId) return;

                fetch(`/api/rooms-by-nha-tro/${nhaTroId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(room => {
                            const opt = document.createElement('option');
                            opt.value = room.id;
                            opt.textContent = room.ten_phong;
                            if (selected && selected == room.id) {
                                opt.selected = true;
                            }
                            roomSelect.appendChild(opt);
                        });
                    });
            }

            // Khi thay đổi nhà trọ → cập nhật danh sách phòng
            nhaTroSelect.addEventListener('change', function() {
                loadRooms(this.value);
            });

            // Khi trang load lần đầu (nếu có sẵn nha_tro_id) → load danh sách phòng tương ứng
            if (nhaTroSelect.value) {
                loadRooms(nhaTroSelect.value, selectedRoomId);
            }
        });
    </script>
@endsection
