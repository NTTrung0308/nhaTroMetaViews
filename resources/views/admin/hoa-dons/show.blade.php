@extends('admin.index')
@section('contentadmin')
<div class="printable-area">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>HÓA ĐƠN TIỀN NHÀ THÁNG {{ $hoaDon->thang }}/{{ $hoaDon->nam }}</h3>
        <div class="no-print">
            <a href="{{ route('hoa-dons.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
            <button onclick="window.print()" class="btn btn-info"><i class="fa fa-print"></i> In hóa đơn</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <div class="row mb-4">
               
                <div class="col-md-6 text-md-end">
                    <h5>Bên thuê (Khách hàng):</h5>
                    <p class="mb-1"><strong>Khách thuê:</strong> {{ $hoaDon->user->name }}</p>
                    <p class="mb-1"><strong>Phòng:</strong> {{ $hoaDon->room->ten_phong }}</p>
                    <p class="mb-1"><strong>Mã hóa đơn:</strong> {{ $hoaDon->ma_hoa_don }}</p>
                    <p class="mb-1"><strong>Ngày tạo:</strong> {{ $hoaDon->ngay_tao_hoa_don->format('d/m/Y') }}</p>
                    <p class="mb-1"><strong>Hạn thanh toán:</strong> {{ $hoaDon->han_thanh_toan->format('d/m/Y') }}</p>
                </div>
            </div>

            <h5>Chi tiết các khoản phí:</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nội dung</th>
                        <th class="text-end">Thành tiền (VND)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Tiền thuê phòng tháng {{ $hoaDon->thang }}/{{ $hoaDon->nam }}</td>
                        <td class="text-end">{{ number_format($hoaDon->tien_thue_phong, 0) }}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Tiền điện</td>
                        <td class="text-end">{{ number_format($hoaDon->tien_dien, 0) }}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tiền nước</td>
                        <td class="text-end">{{ number_format($hoaDon->tien_nuoc, 0) }}</td>
                    </tr>
                    @foreach ($hoaDon->chi_tiet_dich_vu_khac ?? [] as $index => $dichVu)
                    <tr>
                        <td>{{ 4 + $index }}</td>
                        <td>{{ $dichVu['ten_dich_vu'] }}</td>
                        <td class="text-end">{{ number_format($dichVu['thanh_tien'], 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Tổng tiền dịch vụ kỳ này:</th>
                        <th class="text-end">{{ number_format($hoaDon->tong_tien, 0) }}</th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-end">Nợ từ kỳ trước chuyển sang:</th>
                        <th class="text-end">{{ number_format($hoaDon->no_ky_truoc, 0) }}</th>
                    </tr>
                    <tr class="table-primary">
                        <th colspan="2" class="text-end">TỔNG CỘNG PHẢI THANH TOÁN:</th>
                        <th class="text-end h5">{{ number_format($hoaDon->tong_tien + $hoaDon->no_ky_truoc, 0) }}</th>
                    </tr>
                     <tr>
                        <th colspan="2" class="text-end">Đã thanh toán:</th>
                        <th class="text-end">{{ number_format($hoaDon->da_thanh_toan, 0) }}</th>
                    </tr>
                     <tr class="table-success">
                        <th colspan="2" class="text-end">SỐ TIỀN CÒN LẠI:</th>
                        <th class="text-end h5">{{ number_format($hoaDon->con_no, 0) }}</th>
                    </tr>
                </tfoot>
            </table>
            
            <div class="mt-3">
                <strong>Ghi chú:</strong> {{ $hoaDon->ghi_chu ?? 'Không có' }}
            </div>
        </div>
        <div class="card-footer text-end no-print">
            <a href="{{ route('hoa-dons.edit', $hoaDon->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Cập nhật thanh toán</a>
        </div>
    </div>
</div>
@endsection