@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Hợp đồng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">{{ isset($hopDong) ? 'Chỉnh sửa hợp đồng' : 'Thêm hợp đồng mới' }}</li>
            </ol>
        </nav>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ isset($hopDong) ? 'Chỉnh sửa hợp đồng' : 'Thêm hợp đồng mới' }}</h5>
                        <a href="{{ route('admin.hop_dong.index') }}" class="btn btn-secondary mb-3">← Quay lại</a>
                    </div>



                    <form
                        action="{{ isset($hopDong) ? route('admin.hop_dong.update', $hopDong) : route('admin.hop_dong.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($hopDong))
                            @method('PUT')
                        @endif
                        <div class="row">

                            <div class="col-lg-4">
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
                            </div>

                            <div class="col-lg-4">
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
                            </div>

                            <div class="col-lg-4">
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
                            </div>
{{-- THÔNG TIN BÊN CHO THUÊ (NHẬP TAY) --}}
                <h4 class="mb-3">II. Thông tin bên cho thuê</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên người cho thuê</label>
                        <input type="text" name="landlord_ho_ten" class="form-control"
                               value="{{ old('landlord_ho_ten', $hopDong->landlord_ho_ten ?? '') }}" required>
                        @error('landlord_ho_ten')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="landlord_sdt" class="form-control"
                               value="{{ old('landlord_sdt', $hopDong->landlord_sdt ?? '') }}" required>
                        @error('landlord_sdt')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Số CCCD</label>
                        <input type="text" name="landlord_cccd" class="form-control"
                               value="{{ old('landlord_cccd', $hopDong->landlord_cccd ?? '') }}" required>
                        @error('landlord_cccd')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ngày cấp</label>
                        <input type="date" name="landlord_cccd_ngay_cap" class="form-control"
                               value="{{ old('landlord_cccd_ngay_cap', optional($hopDong->landlord_cccd_ngay_cap ?? null)->format('Y-m-d')) }}" required>
                        @error('landlord_cccd_ngay_cap')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nơi cấp</label>
                        <input type="text" name="landlord_cccd_noi_cap" class="form-control"
                               value="{{ old('landlord_cccd_noi_cap', $hopDong->landlord_cccd_noi_cap ?? '') }}" required>
                        @error('landlord_cccd_noi_cap')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Hộ khẩu thường trú</label>
                        <textarea name="landlord_hktt" class="form-control" required>{{ old('landlord_hktt', $hopDong->landlord_hktt ?? '') }}</textarea>
                        @error('landlord_hktt')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
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
                            <div class="checkbox-wrapper-61">
                                <input type="checkbox" class="check" name="active" id="active"
                                    {{ old('active', $hopDong->active ?? true) ? 'checked' : '' }} required />
                                <label for="active" class="label">
                                    <svg width="45" height="45" viewbox="0 0 95 95">
                                        <rect x="30" y="20" width="50" height="50" stroke="black" fill="none" />
                                        <g transform="translate(0,-952.36222)">
                                            <path
                                                d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                stroke="black" stroke-width="3" fill="none" class="path1" />
                                        </g>
                                    </svg>
                                    Còn hiệu lực
                                </label>
                            </div>
                            {{-- <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="active" id="active"
                                    {{ old('active', $hopDong->active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Còn hiệu lực</label>
                            </div> --}}
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">{{ isset($hopDong) ? 'Cập nhật' : 'Tạo mới' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
