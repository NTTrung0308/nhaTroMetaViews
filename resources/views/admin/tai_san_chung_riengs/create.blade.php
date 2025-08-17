    @extends('admin.index')
    @section('contentadmin')
        <div class="pagetitle">
            <h1>Tài sản nhà trọ</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Thêm Tài sản nhà trọ</li>
                </ol>
            </nav>
        </div>


        <div class="row">

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="col-12 d-sm-flex justify-content-between align-items-center">
                            <h5 class="card-title">Thêm mới Tài sản nhà trọ</h5>

                        </div>
                        <form action="{{ route('tai_san_chung_riengs.store') }}" method="POST">
                            @csrf

                            {{-- Nhà trọ --}}
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label">Nhà trọ</label>
                                    <select name="nha_tro_id" id="nha_tro_id" class="form-select" required>
                                        <option value="">-- Chọn nhà trọ --</option>
                                        @foreach ($nhaTros as $nhaTro)
                                            <option value="{{ $nhaTro->id }}">{{ $nhaTro->ten_toa_nha }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Phòng trọ --}}
                                <div class="col-lg-6">
                                    <label class="form-label">Phòng trọ</label>
                                    <select name="room_id" id="room_id" class="form-select">
                                        <option value="">-- Chọn phòng --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Tài sản chung --}}
                            <hr>
                            <h4>Tài sản chung</h4>
                            <div class="row">
                                @forelse ($taiSans as $ts)
                                    <div class="col-lg-3">
                                        <div class="checkbox-wrapper-61">
                                            <input type="checkbox" class="check" name="tai_san_chung_ids[]"
                                                value="{{ $ts->id }}" id="tsc{{ $ts->id }}">
                                            <label for="tsc{{ $ts->id }}" class="label">
                                                <svg width="45" height="45" viewbox="0 0 95 95">
                                                    <rect x="30" y="20" width="50" height="50" stroke="black"
                                                        fill="none" />
                                                    <g transform="translate(0,-952.36222)">
                                                        <path
                                                            d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                            stroke="black" stroke-width="3" fill="none" class="path1" />
                                                    </g>
                                                </svg>
                                                <span>{{ $ts->ten_tai_san }}</span>
                                            </label>
                                            {{-- <label for="tsc{{ $ts->id }}">{{ $ts->ten_tai_san }}</label> --}}
                                        </div>
                                    </div>
                               @empty
                                   <div class="col-lg-12 text-center">
                                        <p>Không có tài sản nào</p>
                                    </div>
                                @endforelse
                            </div>


                            {{-- Tài sản riêng --}}
                            <hr>
                            <h4>Tài sản riêng</h4>
                            <div class="row">
                                @forelse ($taiSans as $ts)
                                    <div class="col-lg-3">
                                        <div class="checkbox-wrapper-61">
                                            <input type="checkbox" class="check" name="tai_san_rieng_ids[]"
                                                value="{{ $ts->id }}" id="tsr{{ $ts->id }}">
                                            <label for="tsr{{ $ts->id }}" class="label">
                                                <svg width="45" height="45" viewbox="0 0 95 95">
                                                    <rect x="30" y="20" width="50" height="50" stroke="black"
                                                        fill="none" />
                                                    <g transform="translate(0,-952.36222)">
                                                        <path
                                                            d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                            stroke="black" stroke-width="3" fill="none" class="path1" />
                                                    </g>
                                                </svg>
                                                <span>{{ $ts->ten_tai_san }}</span>
                                            </label>
                                            {{-- <label for="tsr{{ $ts->id }}">{{ $ts->ten_tai_san }}</label> --}}
                                        </div>
                                    </div>
                                 @empty
                                   <div class="col-lg-12 text-center">
                                        <p>Không có tài sản nào</p>
                                    </div>
                                @endforelse
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success">Lưu</button>
                            <a href="{{ route('tai_san_chung_riengs.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.getElementById('nha_tro_id').addEventListener('change', function() {
                const nhaTroId = this.value;
                const roomSelect = document.getElementById('room_id');
                roomSelect.innerHTML = '<option value="">-- Chọn phòng --</option>';

                if (nhaTroId) {
                    fetch(`/api/ajax/rooms-by-nhatro/${nhaTroId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(room => {
                                const option = document.createElement('option');
                                option.value = room.id;
                                option.textContent = room.ma_phong + (room.da_ton_tai ? ' (ĐÃ TỒN TẠI)' :
                                    '');
                                if (room.da_ton_tai) {
                                    option.disabled = true;
                                }
                                roomSelect.appendChild(option);
                            });
                        });
                }
            });
        </script>
    @endsection
