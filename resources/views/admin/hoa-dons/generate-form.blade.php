@extends('admin.index')
@section('contentadmin')
    
  
    <div class="card">
         <h5 class="card-header">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Hóa đơn<</li>

                        </ol>
                    </nav>
                </h5>
        <div class="card-header">Chọn kỳ để tạo hóa đơn</div>
        <div class="card-body">
            <p class="text-muted">Hệ thống sẽ tự động tạo hóa đơn cho tất cả các hợp đồng đang hoạt động trong kỳ bạn chọn.
                Các hóa đơn đã tồn tại hoặc phòng chưa có chỉ số điện nước trong kỳ sẽ được bỏ qua.</p>
            <form action="{{ route('hoa-dons.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="thang" class="form-label">Tháng <span class="text-danger">*</span></label>
                        <select name="thang" id="thang" class="form-select" required>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>Tháng
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nam" class="form-label">Năm <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="nam" id="nam" value="{{ now()->year }}"
                            required>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('hoa-dons.index') }}" class="btn btn-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary">Bắt Đầu Tạo</button>
                </div>
            </form>
        </div>
    </div>
@endsection
