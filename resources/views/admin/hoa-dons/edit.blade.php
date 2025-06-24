@extends('admin.index')
@section('contentadmin')
<h1>Cập nhật thanh toán cho Hóa đơn #{{ $hoaDon->ma_hoa_don }}</h1>
<p>Kỳ: Tháng {{ $hoaDon->thang }}/{{ $hoaDon->nam }} - Phòng: {{ $hoaDon->room->ten_phong }}</p>

<div class="card">
    <div class="card-body">
        <form action="{{ route('hoa-dons.update', $hoaDon->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <dl class="row">
                <dt class="col-sm-4">Tổng phải thanh toán:</dt>
                <dd class="col-sm-8 h5 text-primary">{{ number_format($hoaDon->tong_tien + $hoaDon->no_ky_truoc, 0) }} VND</dd>
                <dt class="col-sm-4">Số tiền còn nợ hiện tại:</dt>
                <dd class="col-sm-8 h5 text-danger">{{ number_format($hoaDon->con_no, 0) }} VND</dd>
            </dl>
            <hr>

            <div class="mb-3">
                <label for="da_thanh_toan" class="form-label">Số tiền đã thanh toán (Nhập tổng số tiền khách đã trả cho hóa đơn này) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="da_thanh_toan" name="da_thanh_toan" 
                       value="{{ old('da_thanh_toan', $hoaDon->da_thanh_toan) }}" required min="0">
            </div>

            <div class="mb-3">
                <label for="trang_thai" class="form-label">Trạng thái hóa đơn <span class="text-danger">*</span></label>
                <select name="trang_thai" id="trang_thai" class="form-select">
                    <option value="chua_thanh_toan" {{ old('trang_thai', $hoaDon->trang_thai) == 'chua_thanh_toan' ? 'selected' : '' }}>Chưa thanh toán</option>
                    <option value="da_thanh_toan" {{ old('trang_thai', $hoaDon->trang_thai) == 'da_thanh_toan' ? 'selected' : '' }}>Đã thanh toán</option>
                    <option value="qua_han" {{ old('trang_thai', $hoaDon->trang_thai) == 'qua_han' ? 'selected' : '' }}>Quá hạn</option>
                    <option value="da_huy" {{ old('trang_thai', $hoaDon->trang_thai) == 'da_huy' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="ghi_chu" class="form-label">Ghi chú của chủ nhà</label>
                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3">{{ old('ghi_chu', $hoaDon->ghi_chu) }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('hoa-dons.show', $hoaDon->id) }}" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Cập Nhật Thanh Toán</button>
            </div>
        </form>
    </div>
</div>
@endsection