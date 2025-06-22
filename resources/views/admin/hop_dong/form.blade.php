@extends('admin.index')
@section('contentadmin')
    <h4>{{ isset($hopDong) ? 'Chỉnh sửa hợp đồng' : 'Thêm hợp đồng mới' }}</h4>
    <a href="{{ route('admin.hop_dong.index') }}" class="btn btn-secondary mb-3">← Quay lại</a>

    <form action="{{ isset($hopDong) ? route('admin.hop_dong.update', $hopDong) : route('admin.hop_dong.store') }}"
        method="POST">
        @csrf
        @if (isset($hopDong))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Người thuê</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Chọn người thuê --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        {{ old('user_id', $hopDong->user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Nhà trọ</label>
            <select name="nha_tro_id" id="nha_tro_id" class="form-select" required>
                <option value="">-- Chọn nhà trọ --</option>
                @foreach ($nhaTros as $nhaTro)
                    <option value="{{ $nhaTro->id }}"
                        {{ old('nha_tro_id', $hopDong->nha_tro_id ?? '') == $nhaTro->id ? 'selected' : '' }}>
                        {{ $nhaTro->ten_toa_nha }}
                    </option>
                @endforeach
            </select>
            @error('nha_tro_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Phòng trọ</label>
            <select name="room_id" id="room_id" class="form-select" required>
                <option value="">-- Chọn phòng --</option>
                {{-- Sẽ được đổ qua JS --}}
            </select>
            @error('room_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Ngày bắt đầu</label>
            <input type="date" name="ngay_bat_dau" class="form-control"
                value="{{ old('ngay_bat_dau', $hopDong->ngay_bat_dau ?? '') }}" required>
            @error('ngay_bat_dau')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Ngày hết hạn</label>
            <input type="date" name="ngay_het_han" class="form-control"
                value="{{ old('ngay_het_han', $hopDong->ngay_het_han ?? '') }}">
            @error('ngay_het_han')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Giá thuê (VNĐ)</label>
            <input type="number" name="gia_thue" id="gia_thue" class="form-control"
                value="{{ old('gia_thue', $hopDong->gia_thue ?? '') }}" required>
            @error('gia_thue')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label>Tiền cọc (VNĐ)</label>
            <input type="number" name="tien_coc" class="form-control"
                value="{{ old('tien_coc', $hopDong->tien_coc ?? '') }}">
            @error('tien_coc')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Ghi chú</label>
            <textarea name="ghi_chu" class="form-control">{{ old('ghi_chu', $hopDong->ghi_chu ?? '') }}</textarea>
            @error('ghi_chu')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="active" id="active"
                {{ old('active', $hopDong->active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Còn hiệu lực</label>
        </div>

        <button class="btn btn-primary">{{ isset($hopDong) ? 'Cập nhật' : 'Tạo mới' }}</button>
    </form>

    {{-- JS để load phòng theo nhà trọ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nhaTroSelect = document.getElementById('nha_tro_id');
            const roomSelect = document.getElementById('room_id');
            const giaThueInput = document.getElementById('gia_thue');
            const selectedRoomId = '{{ old('room_id', $hopDong->room_id ?? '') }}';

            function loadRooms(nhaTroId, selected = null) {
                roomSelect.innerHTML = '<option value="">-- Chọn phòng --</option>';

                if (!nhaTroId) return;

                fetch(`/api/rooms-by-nha-tro/${nhaTroId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(room => {
                            const opt = document.createElement('option');
                            opt.value = room.id;
                            opt.textContent = room.ten_phong;
                            opt.dataset.giaThue = room.gia_thue;

                            if (room.da_thue && room.id != selected) {
                                opt.disabled = true;
                                opt.textContent += ' - ĐÃ CÓ HỢP ĐỒNG';
                            }

                            if (selected && room.id == selected) {
                                opt.selected = true;
                                giaThueInput.value = room.gia_thue; // gán giá thuê khi load ban đầu
                            }

                            roomSelect.appendChild(opt);
                        });
                    });
            }

            roomSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption) {
                    const giaThue = selectedOption.dataset.giaThue || '';
                    giaThueInput.value = giaThue;
                }
            });

            nhaTroSelect.addEventListener('change', function() {
                loadRooms(this.value);
            });

            if (nhaTroSelect.value) {
                loadRooms(nhaTroSelect.value, selectedRoomId);
            }
        });
    </script>
@endsection
