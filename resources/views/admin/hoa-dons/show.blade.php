@extends('admin.index')
@section('contentadmin')


    <div class="pagetitle">
        <h1>Hóa đơn tiền nhà</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Trang chủ</li>
                <li class="breadcrumb-item active">Hóa đơn tiền nhà</li>
            </ol>
        </nav>
    </div>
  <h3>Chi tiết Tiêu thụ Điện - Nước</h3>

{{-- Kiểm tra nếu có bản ghi điện nước --}}
@if ($hoaDon->dienNuoc)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 25%;">Hạng mục</th>
                <th style="width: 20%;">Chi tiết 1</th>
                <th style="width: 20%;">Chi tiết 2</th>
                <th style="width: 15%;">Tiêu thụ</th>
                <th style="width: 20%;">Thành tiền (từ hóa đơn)</th>
            </tr>
        </thead>
        <tbody>
            {{-- HÀNG DÀNH CHO TIỀN ĐIỆN --}}
            @if($dichVuDien)
                <tr>
                    <td><strong>Tiền điện</strong></td>
                    <td>Chỉ số cũ: {{ number_format($hoaDon->dienNuoc->chi_so_dien_truoc) }}</td>
                    <td>Chỉ số mới: {{ number_format($hoaDon->dienNuoc->chi_so_dien) }}</td>
                    <td>
                        <strong>{{ number_format($hoaDon->dienNuoc->dien_tieu_thu) }}</strong> kWh
                    </td>
                    <td>{{ number_format($hoaDon->tien_dien) }} VNĐ</td>
                </tr>
            @endif

            {{-- HÀNG DÀNH CHO TIỀN NƯỚC (Hiển thị động dựa trên kieu_tinh) --}}
            @if($dichVuNuoc)
                {{-- Truy cập kieu_tinh qua thuộc tính pivot --}}
                @if ($dichVuNuoc->pivot->kieu_tinh == 'dau_nguoi')
                    {{-- KỊCH BẢN 1: TÍNH THEO ĐẦU NGƯỜI --}}
                    <tr>
                        <td><strong>Tiền nước (theo đầu người)</strong></td>
                        <td>Số người: {{ $hoaDon->dienNuoc->so_nguoi }}</td>
                        <td>Đơn giá: {{ number_format($dichVuNuoc->pivot->don_gia) }} VNĐ/người</td>
                        <td>—</td> {{-- Không có số tiêu thụ --}}
                        <td>{{ number_format($hoaDon->tien_nuoc) }} VNĐ</td>
                    </tr>
                @elseif ($dichVuNuoc->pivot->kieu_tinh == 'co_dinh')
                    {{-- KỊCH BẢN 2: TÍNH THEO GIÁ CỐ ĐỊNH --}}
                     <tr>
                        <td><strong>Tiền nước (cố định)</strong></td>
                        <td colspan="2">Áp dụng mức phí cố định hàng tháng</td>
                        <td>—</td>
                        <td>{{ number_format($hoaDon->tien_nuoc) }} VNĐ</td>
                    </tr>
                @else
                    {{-- KỊCH BẢN 3: TÍNH THEO CÔNG TƠ (Mặc định) --}}
                    <tr>
                        <td><strong>Tiền nước (theo công tơ)</strong></td>
                        <td>Chỉ số cũ: {{ number_format($hoaDon->dienNuoc->so_m3_nuoc_truoc) }}</td>
                        <td>Chỉ số mới: {{ number_format($hoaDon->dienNuoc->so_m3_nuoc_sau) }}</td>
                        <td>
                            <strong>{{ number_format($hoaDon->dienNuoc->nuoc_tieu_thu) }}</strong> m³
                        </td>
                        <td>{{ number_format($hoaDon->tien_nuoc) }} VNĐ</td>
                    </tr>
                @endif
            @endif
        </tbody>
    </table>
@else
    <div class="alert alert-warning">
        Không tìm thấy bản ghi chốt số điện nước cho hóa đơn tháng {{ $hoaDon->thang }}/{{ $hoaDon->nam }}.
    </div>
@endif
    <div class="printable-area">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>HÓA ĐƠN TIỀN NHÀ THÁNG {{ $hoaDon->thang }}/{{ $hoaDon->nam }}</h3>
            <div class="no-print">
                <a href="{{ route('hoa-dons.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay
                    lại</a>
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
                        <p class="mb-1"><strong>Hạn thanh toán:</strong> {{ $hoaDon->han_thanh_toan->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="col-lg-6">
                        @if ($hoaDon->room->nhaTro->dichVus && $hoaDon->room->nhaTro->dichVus->isNotEmpty())
                            <ul>
                                @foreach ($hoaDon->room->nhaTro->dichVus as $dichVu)
                                    <li>
                                        {{ $dichVu->ten_dich_vu }}: {{ number_format($dichVu->don_gia) }} VNĐ
                                        @if ($dichVu->kieu_tinh == 'dau_nguoi')
                                            (Tính theo đầu người)
                                        @elseif ($dichVu->kieu_tinh == 'cong_to')
                                            (Tính theo công tơ)
                                        @else
                                            (Tính theo tháng)
                                        @endif

                                        {{-- Giả sử model DichVu có các cột 'ten_dich_vu' và 'gia' --}}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Nhà trọ này không có dịch vụ chung nào được cấu hình.</p>
                        @endif
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
                <a href="{{ route('hoa-dons.edit', $hoaDon->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Cập
                    nhật thanh toán</a>
            </div>
        </div>
    </div>
    {{-- Hiển thị thông báo từ session --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    @if ($hoaDon->con_no > 0)
        <div class="payment-gateway-section">
            <h4>Thanh toán trực tuyến</h4>
            <form action="{{ route('payment.vnpay.create', ['hoaDon' => $hoaDon->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <img src="https://vnpay.vn/s1/images/logo-vnpay.png" height="20" alt="VNPay Logo">
                    Thanh toán bằng VNPay QR
                </button>
            </form>
        </div>
    @else
        <div class="alert alert-success">Hóa đơn này đã được thanh toán đầy đủ.</div>
    @endif


    {{-- (Tùy chọn) Hiển thị lịch sử giao dịch liên quan đến hóa đơn này --}}
    <h3>Lịch sử Giao dịch</h3>
    @php
        // Bạn cần load relationship này trong controller: $hoaDon->load('transactions');
        $transactions = $hoaDon->transactions()->orderBy('created_at', 'desc')->get();
    @endphp

    @if ($transactions->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Phương thức</th>
                    <th>Số tiền</th>
                    <th>Trạng thái</th>
                    <th>Mã GD Cổng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $trans)
                    <tr>
                        <td>{{ $trans->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ strtoupper($trans->gateway) }}</td>
                        <td>{{ number_format($trans->amount) }} VNĐ</td>
                        <td>
                            @if ($trans->status == 'completed')
                                <span class="badge bg-success">Thành công</span>
                            @elseif($trans->status == 'pending')
                                <span class="badge bg-warning">Đang chờ</span>
                            @else
                                <span class="badge bg-danger">Thất bại</span>
                            @endif
                        </td>
                        <td>{{ $trans->gateway_transaction_code }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Chưa có giao dịch nào cho hóa đơn này.</p>
    @endif
@endsection
