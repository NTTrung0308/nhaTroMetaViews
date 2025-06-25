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
        <select name="thanh_pho" id="province-select" class="form-select"
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
        <select name="quan" id="district-select" class="form-select"
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
        <select name="phuong" id="ward-select" class="form-select"
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
    <label class="form-label fw-bold">Dịch vụ áp dụng:</label>
    {{-- Vòng lặp này sẽ chạy qua tất cả các dịch vụ có trong hệ thống --}}
    @foreach ($dichVus as $dv)
        @php
            // 1. Mặc định các giá trị ban đầu
            $pivot = null;
            
            // 2. Chỉ kiểm tra dữ liệu cũ nếu đang ở trang SỬA
            //    (biến $nhaTro được truyền từ controller và có dữ liệu)
            if (isset($nhaTro)) {
                $dichVuDaLuu = $nhaTro->dichVus->find($dv->id);
                if ($dichVuDaLuu) {
                    $pivot = $dichVuDaLuu->pivot;
                }
            }

            // 3. Xác định các thông tin khác của dịch vụ
            $isDefault = in_array($dv->ma_dich_vu, ['nuoc', 'dien_sinh_hoat']);
            $isDien = $dv->ma_dich_vu === 'dien_sinh_hoat';
            $isNuoc = $dv->ma_dich_vu === 'nuoc';
            $defaultKieuTinh = $isDien || $isNuoc ? 'cong_to' : 'co_dinh';
            
            // 4. Lấy giá trị cuối cùng để hiển thị (an toàn tuyệt đối)
            //    Ưu tiên 1: Dữ liệu từ form submit lỗi (old())
            //    Ưu tiên 2: Dữ liệu đã lưu trong DB (khi edit)
            //    Ưu tiên 3: Giá trị mặc định là 0 (khi create)
            $donGia = old("dich_vu_data.{$dv->id}.don_gia", optional($pivot)->don_gia ?? 0);
            $kieuTinh = old("dich_vu_data.{$dv->id}.kieu_tinh", optional($pivot)->kieu_tinh ?? $defaultKieuTinh);
            
            // 5. Logic xác định checkbox được check
            $isChecked = false;
            if (is_array(old('dich_vu_ids'))) { // Có dữ liệu cũ từ form lỗi
                $isChecked = in_array($dv->id, old('dich_vu_ids'));
            } elseif (isset($nhaTro)) { // Đang ở trang edit và không có dữ liệu cũ
                $isChecked = (bool)$pivot; // Check nếu có pivot
            } else { // Đang ở trang create và không có dữ liệu cũ
                $isChecked = $isDefault; // Tự động check các dịch vụ mặc định
            }
        @endphp

        <div class="col-lg-6">
            <div class="border rounded p-3 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dich_vu_ids[]" value="{{ $dv->id }}"
                        id="dv{{ $dv->id }}"
                        {{ $isChecked ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="dv{{ $dv->id }}">
                        {{ $dv->ten_dich_vu }} @if ($isDefault)<small class="text-danger">* (Bắt buộc)</small>@endif
                    </label>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Đơn giá</label>
                        <input type="number" name="dich_vu_data[{{ $dv->id }}][don_gia]" class="form-control" value="{{ $donGia }}">
                        @error("dich_vu_data.{$dv->id}.don_gia") <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Kiểu tính</label>
                        @if ($isDien)
                            <select class="form-control" disabled> <option selected>Công tơ</option> </select>
                            <input type="hidden" name="dich_vu_data[{{ $dv->id }}][kieu_tinh]" value="cong_to">
                        @else
                            <select name="dich_vu_data[{{ $dv->id }}][kieu_tinh]" class="form-control">
                                @if ($isNuoc)
                                    <option value="cong_to" {{ $kieuTinh == 'cong_to' ? 'selected' : '' }}>Công tơ</option>
                                @endif
                                <option value="dau_nguoi" {{ $kieuTinh == 'dau_nguoi' ? 'selected' : '' }}>Đầu người</option>
                                <option value="co_dinh" {{ $kieuTinh == 'co_dinh' ? 'selected' : '' }}>Cố định</option>
                            </select>
                        @endif
                        @error("dich_vu_data.{$dv->id}.kieu_tinh") <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @error('dich_vu_ids') <div class="text-danger d-block mt-2">{{ $message }}</div> @enderror
</div>
