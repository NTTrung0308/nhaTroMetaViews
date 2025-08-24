    @extends('admin.index')
    @section('contentadmin')



        <div class="row">

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="col-12 d-sm-flex justify-content-between align-items-center">
                            <h5 class="card-title">Thêm mới Tài sản nhà trọ</h5>

                        </div>

                        <form action="{{ route('tai_san_chung_riengs.update', $taiSanChungRieng->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="nha_tro_id" class="form-label">Nhà trọ</label>
                                    <select name="nha_tro_id" id="nha_tro_id" class="form-select" required>
                                        <option value="">Chọn nhà trọ</option>
                                        @foreach ($nhaTros as $nhaTro)
                                            <option value="{{ $nhaTro->id }}"
                                                {{ (old('nha_tro_id') ?? $taiSanChungRieng->nha_tro_id) == $nhaTro->id ? 'selected' : '' }}>
                                                {{ $nhaTro->ten_toa_nha }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nha_tro_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="room_id" class="form-label">Phòng trọ</label>
                                    <select name="room_id" id="room_id" class="form-select">
                                        <option value="">Không chọn phòng</option>
                                        {{-- Các option sẽ được load JS --}}
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h4>Chọn tài sản chung</h4>
                            <div class="mb-3">
                                <div class="row">
                                    @foreach ($taiSans as $taiSan)
                                        <div class="col-lg-3">
                                            <div class="checkbox-wrapper-61">
                                                <input type="checkbox" class="check" name="tai_san_chung_ids[]"
                                                    value="{{ $taiSan->id }}" id="tsc{{ $taiSan->id }}"
                                                    {{ (is_array(old('tai_san_chung_ids')) ? in_array($taiSan->id, old('tai_san_chung_ids')) : $taiSanChungRieng->taiSanChungs->pluck('tai_san_id')->contains($taiSan->id)) ? 'checked' : '' }}>
                                                <label for="tsc{{ $taiSan->id }}" class="label">
                                                    <svg width="45" height="45" viewbox="0 0 95 95">
                                                        <rect x="30" y="20" width="50" height="50" stroke="black"
                                                            fill="none" />
                                                        <g transform="translate(0,-952.36222)">
                                                            <path
                                                                d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                                stroke="black" stroke-width="3" fill="none"
                                                                class="path1" />
                                                        </g>
                                                    </svg>
                                                    <span>{{ $taiSan->ten_tai_san }}</span>
                                                </label>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                 @error('tai_san_chung_ids[]')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>

                            <hr>
                            <h4>Chọn tài sản riêng</h4>
                            <div class="mb-3">
                                <div class="row">

                                    @foreach ($taiSans as $taiSan)
                                        <div class="col-lg-3">
                                            <div class="checkbox-wrapper-61">
                                                <input type="checkbox" class="check" name="tai_san_rieng_ids[]"
                                                    value="{{ $taiSan->id }}" id="tsr{{ $taiSan->id }}"
                                                    {{ (is_array(old('tai_san_rieng_ids')) ? in_array($taiSan->id, old('tai_san_rieng_ids')) : $taiSanChungRieng->taiSanRiengs->pluck('tai_san_id')->contains($taiSan->id)) ? 'checked' : '' }}>
                                                <label for="tsr{{ $taiSan->id }}" class="label">
                                                    <svg width="45" height="45" viewbox="0 0 95 95">
                                                        <rect x="30" y="20" width="50" height="50" stroke="black"
                                                            fill="none" />
                                                        <g transform="translate(0,-952.36222)">
                                                            <path
                                                                d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                                stroke="black" stroke-width="3" fill="none"
                                                                class="path1" />
                                                        </g>
                                                    </svg>
                                                    <span>{{ $taiSan->ten_tai_san }}</span>
                                                </label>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('tai_san_rieng_ids[]')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="{{ route('tai_san_chung_riengs.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const nhaTroSelect = document.getElementById('nha_tro_id');
            const roomSelect = document.getElementById('room_id');
            const oldRoomId = "{{ old('room_id', $taiSanChungRieng->room_id) }}";

            function loadRooms(nhaTroId, selectedRoomId = null) {
                roomSelect.innerHTML = '<option value="">Không chọn phòng</option>';

                if (!nhaTroId) return;

                fetch(`/api/ajax/rooms-by-nhatro/${nhaTroId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                            option.textContent = room.ma_phong + (room.da_ton_tai ? ' (Đã tồn tại)' : '');
                            if (room.da_ton_tai) {
                                option.disabled = true; // disable option nếu đã tồn tại
                            }
                            if (selectedRoomId && selectedRoomId == room.id) {
                                option.selected = true;
                                if (room.da_ton_tai) {
                                    option.disabled = false; // cho phép chọn lại phòng đang dùng trong edit
                                }
                            }
                            roomSelect.appendChild(option);
                        });
                    });

            }

            // Load phòng khi trang load lần đầu với nhà trọ đang chọn
            document.addEventListener('DOMContentLoaded', function() {
                loadRooms(nhaTroSelect.value, oldRoomId);
            });

            // Load phòng khi thay đổi nhà trọ
            nhaTroSelect.addEventListener('change', function() {
                loadRooms(this.value);
            });
        </script>
    @endsection
