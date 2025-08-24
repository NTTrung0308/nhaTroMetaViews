@extends('admin.index')
@section('contentadmin')
    

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                 <h5 class="card-header">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Cập nhật thanh toán cho Hóa đơn #{{ $hoaDon->ma_hoa_don }}</li>

                        </ol>
                    </nav>
                </h5>
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center mt-3 mb-3">
                        <h5 class="fs-6 ">Kỳ: Tháng {{ $hoaDon->thang }}/{{ $hoaDon->nam }} - Phòng:
                            {{ $hoaDon->room->ten_phong }}</h5>
                        <div class="no-print">
                            <a href="{{ route('hoa-dons.index') }}" class="btn btn-secondary"><i
                                    class="fa fa-arrow-left"></i> Quay
                                lại</a>

                        </div>

                    </div>
                    <form action="{{ route('hoa-dons.update', $hoaDon->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <dl class="row">
                            <dt class="col-sm-4">Tổng phải thanh toán:</dt>
                            <dd class="col-sm-8 h5 text-primary">
                                {{ number_format($hoaDon->tong_tien + $hoaDon->no_ky_truoc, 0) }}
                                VND</dd>
                            <dt class="col-sm-4">Số tiền còn nợ hiện tại:</dt>
                            <dd class="col-sm-8 h5 text-danger">{{ number_format($hoaDon->con_no, 0) }} VND</dd>
                        </dl>
                        <div class="mb-3">
                            <label for="da_thanh_toan" class="form-label">Số tiền đã thanh toán (Nhập tổng số tiền khách đã
                                trả
                                cho
                                hóa đơn này) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="da_thanh_toan" name="da_thanh_toan"
                                value="{{ old('da_thanh_toan', $hoaDon->da_thanh_toan) }}" required min="0">
                        </div>
                        <div class="mb-3">
                            <label for="trang_thai" class="form-label">Trạng thái hóa đơn <span
                                    class="text-danger">*</span></label>
                            <select name="trang_thai" id="trang_thai" class="form-select">
                                <option value="chua_thanh_toan"
                                    {{ old('trang_thai', $hoaDon->trang_thai) == 'chua_thanh_toan' ? 'selected' : '' }}>Chưa
                                    thanh
                                    toán</option>
                                <option value="da_thanh_toan"
                                    {{ old('trang_thai', $hoaDon->trang_thai) == 'da_thanh_toan' ? 'selected' : '' }}>Đã
                                    thanh toán
                                </option>
                                <option value="qua_han"
                                    {{ old('trang_thai', $hoaDon->trang_thai) == 'qua_han' ? 'selected' : '' }}>Quá hạn
                                </option>
                                <option value="da_huy"
                                    {{ old('trang_thai', $hoaDon->trang_thai) == 'da_huy' ? 'selected' : '' }}>
                                    Đã hủy</option>
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
        </div>
    </div>
  
@endsection
