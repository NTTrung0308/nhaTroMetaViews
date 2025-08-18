<div class="mb-3">
    <label>Mã tài sản</label>
    <input type="text" name="ma_tai_san" class="form-control" value="{{ old('ma_tai_san', $taiSan->ma_tai_san ?? '') }}">
    @error('ma_tai_san')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Tên tài sản</label>
    <input type="text" name="ten_tai_san" class="form-control"
        value="{{ old('ten_tai_san', $taiSan->ten_tai_san ?? '') }}">
    @error('ten_tai_san')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Ngày mua</label>
    <input type="date" name="ngay_mua" class="form-control" value="{{ old('ngay_mua', $taiSan->ngay_mua ?? '') }}">
    @error('ngay_mua')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Giá trị</label>
    <input type="number" name="gia_tri" class="form-control" value="{{ old('gia_tri', $taiSan->gia_tri ?? 0) }}">
    @error('gia_tri')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label>Tình trạng</label>
    <select name="tinh_trang" class="form-select">
        @php
            $tinhTrang = old('tinh_trang', $taiSan->tinh_trang ?? 'Đang sử dụng');
        @endphp
        <option {{ $tinhTrang == 'Mới' ? 'selected' : '' }}>Mới</option>
        <option {{ $tinhTrang == 'Đang sử dụng' ? 'selected' : '' }}>Đang sử dụng</option>
        <option {{ $tinhTrang == 'Hỏng' ? 'selected' : '' }}>Hỏng</option>
        <option {{ $tinhTrang == 'Thanh lý' ? 'selected' : '' }}>Thanh lý</option>
    </select>
</div>

<div class="mb-3">
    <label>Ghi chú</label>
    <textarea name="ghi_chu" class="form-control">{{ old('ghi_chu', $taiSan->ghi_chu ?? '') }}</textarea>
</div>

<div class="text-end">
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('tai-sans.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
