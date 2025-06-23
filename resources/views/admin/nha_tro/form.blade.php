<div class="row">
    <div class="mb-3 col-lg-6">
        <label>Tên tòa nhà</label>
        <input type="text" name="ten_toa_nha" value="{{ old('ten_toa_nha', optional($nhaTro)->ten_toa_nha) }}"
            class="form-control" required>
        @error('ten_toa_nha')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 col-lg-6">
        <label>Mã tòa nhà</label>
        <input type="text" name="ma_toa_nha" value="{{ old('ma_toa_nha', optional($nhaTro)->ma_toa_nha) }}"
            class="form-control">
        @error('ma_toa_nha')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label>Địa chỉ</label>
    <input type="text" name="dia_chi" value="{{ old('dia_chi', optional($nhaTro)->dia_chi) }}" class="form-control">
    @error('dia_chi')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="row mb-3">
    <div class="col">
        <label>Thành phố</label>
        <select name="thanh_pho" id="province-select" class="form-control"
            data-old="{{ old('thanh_pho', $nhaTro->thanh_pho ?? '') }}">
            <option value="">-- Chọn Tỉnh/Thành phố --</option>
        </select>
        {{-- <input type="text" name="thanh_pho" value="{{ old('thanh_pho', optional($nhaTro)->thanh_pho) }}"
            class="form-control"> --}}
        @error('thanh_pho')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col">
        <label>Quận</label>
        <select name="quan" id="district-select" class="form-control"
            data-old="{{ old('quan', $nhaTro->quan ?? '') }}" disabled>
            <option value="">-- Chọn Quận/Huyện --</option>
        </select>
        {{-- <input type="text" name="quan" value="{{ old('quan', optional($nhaTro)->quan) }}" class="form-control"> --}}
        @error('quan')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col">
        <label>Phường</label>
        <select name="phuong" id="ward-select" class="form-control"
            data-old="{{ old('phuong', $nhaTro->phuong ?? '') }}" disabled>
            <option value="">-- Chọn Phường/Xã --</option>
        </select>
        {{-- <input type="text" name="phuong" value="{{ old('phuong', optional($nhaTro)->phuong) }}"
            class="form-control"> --}}
        @error('phuong')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>


</div>

<div class="row mb-3">
    <div class="col">
        <label>Số tầng</label>
        <input type="number" name="so_tang" value="{{ old('so_tang', optional($nhaTro)->so_tang) }}"
            class="form-control">
        @error('so_tang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col">
        <label>Số Phòng/ tầng</label>
        <input type="number" name="so_phong_tang" value="{{ old('so_phong_tang', optional($nhaTro)->so_phong_tang) }}"
            class="form-control">
        @error('so_phong_tang')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col">
        <label>Diện tích (m2)</label>
        <input type="number" name="dien_tich" value="{{ old('dien_tich', optional($nhaTro)->dien_tich) }}"
            class="form-control">
        @error('dien_tich')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col">
        <label>Chủ sở hữu</label>
        <input type="text" name="chu_so_huu" value="{{ old('chu_so_huu', optional($nhaTro)->chu_so_huu) }}"
            class="form-control">
        @error('chu_so_huu')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label>Mô tả</label>
    <textarea name="mo_ta" class="form-control">{{ old('mo_ta', optional($nhaTro)->mo_ta) }}</textarea>
    @error('mo_ta')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="mb-3  col-lg-6">
        <label>Trạng thái</label>
        <select name="status" class="form-control">
            <option value="Hoạt động" {{ old('status', optional($nhaTro)->status) == 'Hoạt động' ? 'selected' : '' }}>
                Hoạt
                động</option>
            <option value="Ngưng hoạt động"
                {{ old('status', optional($nhaTro)->status) == 'Ngưng hoạt động' ? 'selected' : '' }}>Ngưng hoạt động
            </option>
        </select>
        @error('status')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 col-lg-6">
        <label>Quốc gia</label>
        <input type="text" name="quoc_gia" value="{{ old('quoc_gia', optional($nhaTro)->quoc_gia ?? 'Việt Nam') }}"
            class="form-control">
        @error('quoc_gia')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3 row g-3">

    <label>Dịch vụ áp dụng:</label>
    @foreach ($dichVus as $index => $dv)
        @php
            $pivot = $pivotData[$dv->id] ?? null;
            $isDefault = in_array($dv->ma_dich_vu, ['nuoc', 'dien_sinh_hoat', 'mang']);
            $donGia = old("don_gia.$index", $pivot['don_gia'] ?? 0);
            $kieuTinh = old("kieu_tinh.$index", $pivot['kieu_tinh'] ?? 'cong_to');
                $isDien = $dv->ma_dich_vu === 'dien_sinh_hoat';
        @endphp
        <div class="col-lg-6">
            <div class="border rounded p-3 mb-2 ">

                <div class="checkbox-wrapper-61">
                    <input type="checkbox" class="check" name="dich_vu_ids[]" value="{{ $dv->id }}"
                        id="dv{{ $dv->id }}"
                        {{ (optional($nhaTro)->dichVus ?? collect())->contains($dv->id) || (is_array(old('dich_vu_ids')) && in_array($dv->id, old('dich_vu_ids', []))) ? 'checked' : '' }} />
                    <label for="dv{{ $dv->id }}" class="label">
                        <svg width="45" height="45" viewbox="0 0 95 95">
                            <rect x="30" y="20" width="50" height="50" stroke="black" fill="none" />
                            <g transform="translate(0,-952.36222)">
                                <path
                                    d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                    stroke="black" stroke-width="3" fill="none" class="path1" />
                            </g>
                        </svg>
                        <span>{{ $dv->ten_dich_vu }} @if ($isDefault)
                                <small class="text-danger">*</small>
                            @endif
                        </span>
                    </label>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Đơn giá</label>
                        <input type="number" name="don_gia[]" class="form-control" value="{{ $donGia }}">
                        @error("don_gia.$index")
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                   <div class="col-md-6">
    <label>Kiểu tính</label>
    @if ($isDien)
        <select class="form-control" disabled>
            <option value="cong_to" selected>Công tơ</option>
        </select>
        <input type="hidden" name="kieu_tinh[]" value="cong_to">
    @else
        <select name="kieu_tinh[]" class="form-control">
            <option value="cong_to" {{ $kieuTinh == 'cong_to' ? 'selected' : '' }}>Công tơ</option>
            <option value="dau_nguoi" {{ $kieuTinh == 'dau_nguoi' ? 'selected' : '' }}>Đầu người</option>
            <option value="co_dinh" {{ $kieuTinh == 'co_dinh' ? 'selected' : '' }}>Cố định</option>
        </select>
    @endif

    @error("kieu_tinh.$index")
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

                </div>
            </div>
        </div>
    @endforeach



    @error('dich_vu_ids')
        <div class="text-danger d-block mt-2">{{ $message }}</div>
    @enderror


</div>
