@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Công tơ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">{{ isset($congTo) ? 'Chỉnh sửa công tơ' : 'Thêm công tơ mới' }}</li>
            </ol>
        </nav>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ isset($congTo) ? 'Chỉnh sửa công tơ' : 'Thêm công tơ mới' }}</h5>

                    </div>
                    <div class="col-12">


                        <form
                            action="{{ isset($congTo) ? route('admin.cong_tos.dien.update', $congTo) : route('admin.cong_tos.dien.store') }}"
                            method="POST" class="row">
                            @csrf
                            @if (isset($congTo))
                                @method('PUT')
                            @endif

                            <div class="col-md-6 mb-3">
                                <label for="nha_tro_id" class="form-label">Tòa nhà <span
                                        class="text-danger">*</span></label></label>
                                <select name="nha_tro_id" id="nha_tro_id" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    @foreach ($nhaTros as $nhaTro)
                                        <option value="{{ $nhaTro->id }}"
                                            {{ old('nha_tro_id', $congTo->nha_tro_id ?? '') == $nhaTro->id ? 'selected' : '' }}>
                                            {{ $nhaTro->ten_toa_nha }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('nha_tro_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="room_id" class="form-label">Phòng <span
                                        class="text-danger">*</span></label></label>
                                <select name="room_id" id="room_id" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    {{-- Các option sẽ được JS thêm vào --}}
                                </select>
                                @error('room_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- <label class="form-label">Loại công tơ <span class="text-danger">*</span></label>
                            <div class="row">

                                @foreach (['dien' => 'Điện', 'nuoc' => 'Nước'] as $key => $label)
                                    <div class="col-lg-6">

                                        <div class="checkbox-wrapper-61">
                                            <input type="radio" class="check" name="loai" value="{{ $key }}"
                                                id="dv{{ $key }}"
                                                {{ old('loai', $congTo->loai ?? '') == $key ? 'checked' : '' }} required />
                                            <label for="dv{{ $key }}" class="label">
                                                <svg width="45" height="45" viewbox="0 0 95 95">
                                                    <rect x="30" y="20" width="50" height="50" stroke="black"
                                                        fill="none" />
                                                    <g transform="translate(0,-952.36222)">
                                                        <path
                                                            d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                            stroke="black" stroke-width="3" fill="none" class="path1" />
                                                    </g>
                                                </svg>
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                @error('loai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div> --}}




                            <div class="mb-3">
                                <label for="chi_so_dau" class="form-label">Chỉ số đầu <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="chi_so_dau" min="0"
                                    value="{{ old('chi_so_dau', $congTo->chi_so_dau ?? 0) }}">
                                @error('chi_so_dau')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($congTo) ? 'Cập nhật' : 'Tạo mới' }}
                                </button>
                            </div>
                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nhaTroSelect = document.getElementById('nha_tro_id');
        const roomSelect = document.getElementById('room_id');
        
        // Lấy room_id đã chọn trước đó (khi validation fail hoặc khi edit)
        const selectedRoomId = '{{ old('room_id', $congTo->room_id ?? '') }}';

        function loadRooms(nhaTroId, selectedRoom = null) {
            // Nếu không có tòa nhà nào được chọn, reset danh sách phòng và dừng lại
            if (!nhaTroId) {
                roomSelect.innerHTML = '<option value="">-- Chọn tòa nhà trước --</option>';
                return;
            }

            // Hiển thị trạng thái đang tải và vô hiệu hóa dropdown
            roomSelect.innerHTML = '<option value="">-- Đang tải danh sách phòng... --</option>';
            roomSelect.disabled = true;

            // Gọi API bằng fetch
            fetch(`/api/rooms-by-nha-tro/${nhaTroId}`)
                .then(response => {
                    if (!response.ok) {
                        // Nếu server trả về lỗi (4xx, 5xx), ném ra một lỗi để khối .catch() bắt được
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(rooms => {
                    // Xóa trạng thái đang tải
                    roomSelect.innerHTML = '<option value="">-- Chọn phòng --</option>';

                    if (rooms.length === 0) {
                        roomSelect.innerHTML = '<option value="">-- Tòa nhà này chưa có phòng --</option>';
                    } else {
                        // Lặp qua danh sách phòng và tạo các option
                        rooms.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                    
                            
                            // Hiển thị cả mã phòng và tên phòng cho dễ nhận biết
                            option.textContent = `Phòng ${room.ma_phong} (${room.ten_phong})`;

                            // Nếu có phòng được chọn sẵn, đánh dấu nó là selected
                            if (selectedRoom && selectedRoom == room.id) {
                                option.selected = true;
                            }
                            roomSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    // **BẮT LỖI VÀ HIỂN THỊ**
                    console.error('Lỗi khi tải danh sách phòng:', error);
                    roomSelect.innerHTML = '<option value="">-- Lỗi khi tải dữ liệu --</option>';
                })
                .finally(() => {
                    // Luôn luôn kích hoạt lại dropdown sau khi fetch xong (dù thành công hay thất bại)
                    roomSelect.disabled = false;
                });
        }

        // --- Gắn các sự kiện ---

        // 1. Khi người dùng thay đổi lựa chọn Tòa nhà
        nhaTroSelect.addEventListener('change', function() {
            // Gọi hàm loadRooms với giá trị mới, không cần truyền selectedRoomId
            loadRooms(this.value);
        });

        // 2. Khi trang tải lần đầu
        // Nếu đã có một tòa nhà được chọn sẵn (trường hợp edit hoặc validation fail)
        if (nhaTroSelect.value) {
            // Gọi hàm loadRooms và truyền vào cả selectedRoomId để tự động chọn lại phòng
            loadRooms(nhaTroSelect.value, selectedRoomId);
        } else {
             roomSelect.innerHTML = '<option value="">-- Chọn tòa nhà trước --</option>';
        }
    });
</script>
@endsection
