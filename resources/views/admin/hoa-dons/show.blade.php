@extends('admin.index')
@section('contentadmin')


   
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                 <h5 class="card-header">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Hóa đơn tiền nhà</li>

                        </ol>
                    </nav>
                </h5>
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center mt-3 mb-3">
                        <h5 class="fs-6 ">HÓA ĐƠN TIỀN NHÀ THÁNG {{ $hoaDon->thang }}/{{ $hoaDon->nam }}</h5>
                        <div class="no-print">
                            <a href="{{ route('hoa-dons.index') }}" class="btn btn-secondary"><i
                                    class="fa fa-arrow-left"></i> Quay
                                lại</a>
                            <button onclick="window.print()" class="btn btn-info"><i class="fa fa-print"></i> In hóa
                                đơn</button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <h6><b>Bên thuê (Khách hàng):</b></h6>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Khách thuê:</strong> {{ $hoaDon->user->name }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Phòng:</strong> {{ $hoaDon->room->ten_phong }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Mã hóa đơn:</strong> {{ $hoaDon->ma_hoa_don }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Ngày tạo:</strong>
                                                {{ $hoaDon->ngay_tao_hoa_don->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="mb-1"><strong>Hạn thanh toán:</strong>
                                                {{ $hoaDon->han_thanh_toan->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <h6><b>Bên cho thuê (Chủ nhà):</b></h6>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Tên chủ trọ:</strong>
                                                {{ $hoaDon->hopDong->landlord_ho_ten }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Số điện thoại:</strong>
                                                {{ $hoaDon->hopDong->landlord_so_dien_thoai }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Chưng minh nhân dân:</strong>
                                                {{ $hoaDon->hopDong->landlord_cmnd }}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="mb-1"><strong>Ngày cấp:</strong>
                                                {{ $hoaDon->hopDong->landlord_cccd_ngay_cap }}</p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p class="mb-1"><strong>Hộ khẩu:</strong>
                                                {{ $hoaDon->hopDong->landlord_hktt }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-chitietPhi" tabindex="-1"
                            aria-labelledby="exampleModal-chitietPhiLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModal-chitietPhiLabel">Chi tiết các khoản
                                            phí</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($hoaDon->room->nhaTro->dichVus && $hoaDon->room->nhaTro->dichVus->isNotEmpty())
                                            <ul>
                                                @foreach ($hoaDon->room->nhaTro->dichVus as $dichVu)
                                                    <li>
                                                        {{ $dichVu->ten_dich_vu }}: {{ number_format($dichVu->don_gia) }}
                                                        VNĐ
                                                        @if ($dichVu->kieu_tinh == 'dau_nguoi')
                                                            (Tính theo đầu người)
                                                        @elseif ($dichVu->kieu_tinh == 'cong_to')
                                                            (Tính theo công tơ)
                                                        @else
                                                            (Tính theo tháng)
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>Nhà trọ này không có dịch vụ chung nào được cấu hình.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 d-sm-flex justify-content-between align-items-center mb-3">
                        <!-- Nút này vẫn giữ nguyên vị trí -->
                        <button type="button" class="btn btn-outline-secondary mb-2 mb-sm-0" data-bs-toggle="modal"
                            data-bs-target="#exampleModal-chitietPhi">
                            Chi tiết các khoản phí:
                        </button>


                        <div class="no-print d-flex align-items-center gap-2">
                            @if ($hoaDon->con_no > 0)
                                <div class="payment-gateway-section">
                                    <form action="{{ route('payment.vnpay.create', ['hoaDon' => $hoaDon->id]) }}"
                                        method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            Thanh toán bằng VNPay QR
                                        </button>
                                    </form>
                                </div>
                                {{-- <form action="{{ route('payment.zalopay.create', ['hoaDon' => $hoaDon->id]) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn" style="background-color: #008fe5; color: white;">Thanh toán ZaloPay</button>
            </form> --}}
                            @else
                                <button type="button" class="btn btn-outline-success" disabled data-bs-toggle="popover"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    data-bs-content="Hóa đơn đã được thanh toán">
                                    Hóa đơn đã được thanh toán
                                </button>
                            @endif

                            <button class="btn btn-success" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Chi tiết điện nước
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
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
                                    <th colspan="2" class="text-end fs-6">Tổng tiền dịch vụ kỳ này:</th>
                                    <th class="text-end">{{ number_format($hoaDon->tong_tien, 0) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-end fs-6">Nợ từ kỳ trước chuyển sang:</th>
                                    <th class="text-end">{{ number_format($hoaDon->no_ky_truoc, 0) }}</th>
                                </tr>
                                <tr class="table-primary">
                                    <th colspan="2" class="text-end fs-6"><span>TỔNG CỘNG PHẢI THANH TOÁN:</span></th>
                                    <th class="text-end h6">
                                        {{ number_format($hoaDon->tong_tien + $hoaDon->no_ky_truoc, 0) }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-end fs-6">Đã thanh toán:</th>
                                    <th class="text-end text-success">{{ number_format($hoaDon->da_thanh_toan, 0) }}</th>
                                </tr>
                                <tr class="table-success">
                                    <th colspan="2" class="text-end fs-6">SỐ TIỀN CÒN LẠI:</th>
                                    <th class="text-end h6 text-danger">{{ number_format($hoaDon->con_no, 0) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                    <div class="mt-3">
                        <strong>Ghi chú:</strong> {{ $hoaDon->ghi_chu ?? 'Không có' }}
                    </div>
                </div>
                <div class="card-footer text-end no-print">
                    <button class="btn btn-success" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#staticBackCard">Lịch sử giao dịch</button>
                    <a href="{{ route('hoa-dons.edit', $hoaDon->id) }}" class="btn btn-warning"><i
                            class="fa fa-edit"></i>
                        Cập
                        nhật thanh toán</a>
                </div>
            </div>
        </div>
    </div>
    {{-- <h3>Chi tiết Tiêu thụ Điện - Nước</h3> --}}

    {{-- Kiểm tra nếu có bản ghi điện nước --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Chi tiết điện nước tiêu thụ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                @if ($dichVuDien)
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

                                @if ($dichVuNuoc)
                                    @if ($dichVuNuoc->pivot->kieu_tinh == 'dau_nguoi')
                                        <tr>
                                            <td><strong>Tiền nước (theo đầu người)</strong></td>
                                            <td>Số người: {{ $hoaDon->dienNuoc->so_nguoi }}</td>
                                            <td>Đơn giá: {{ number_format($dichVuNuoc->pivot->don_gia) }} VNĐ/người</td>
                                            <td>—</td>
                                            <td>{{ number_format($hoaDon->tien_nuoc) }} VNĐ</td>
                                        </tr>
                                    @elseif ($dichVuNuoc->pivot->kieu_tinh == 'co_dinh')
                                        <tr>
                                            <td><strong>Tiền nước (cố định)</strong></td>
                                            <td colspan="2">Áp dụng mức phí cố định hàng tháng</td>
                                            <td>—</td>
                                            <td>{{ number_format($hoaDon->tien_nuoc) }} VNĐ</td>
                                        </tr>
                                    @else
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
                            Không tìm thấy bản ghi chốt số điện nước cho hóa đơn tháng
                            {{ $hoaDon->thang }}/{{ $hoaDon->nam }}.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="staticBackCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackCardLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-6" id="staticBackCardLabel">Lịch sử Giao dịch</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    @php
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
                                        <td>{{ $trans->gateway_transaction_code ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning text-center" role="alert">
                            Chưa có giao dịch nào cho hóa đơn này
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection
