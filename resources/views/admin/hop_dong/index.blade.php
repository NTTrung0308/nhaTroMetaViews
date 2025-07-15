@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Hợp đồng thuê phòng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Hợp đồng thuê phòng</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách hợp đồng</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm hợp đồng'))
                            <a href="{{ route('admin.hop_dong.create') }}" class="btn btn-success rounded-pill mb-2 mb-sm-0">
                                <i class="bi bi-plus-circle"></i> Thêm hợp đồng
                            </a>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Người thuê</th>
                                    <th>Phòng</th>
                                    <th>Ngày BĐ</th>
                                    <th>Ngày HH</th>
                                    <th>Trạng thái HĐ</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hopDongs as $hd)
                                    <tr>
                                        <td>{{ $hd->id }}</td>
                                        <td>{{ $hd->user->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $hd->room->ma_phong ?? 'N/A' }}</span><br>
                                            <small class="text-muted">{{ $hd->nhaTro->ten_toa_nha ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($hd->ngay_bat_dau)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($hd->ngay_het_han)->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $hd->trang_thai_class }}">
                                                {{ $hd->trang_thai }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-info view-details-btn"
                                                title="Xem chi tiết"
                                                data-id="{{ $hd->id }}"
                                                data-nguoi-thue="{{ $hd->user->name ?? 'N/A' }}"
                                                data-nha-tro="{{ $hd->nhaTro->ten_toa_nha ?? 'N/A' }}"
                                                data-phong="{{ $hd->room->ma_phong ?? 'N/A' }}"
                                                data-ngay-bat-dau="{{ \Carbon\Carbon::parse($hd->ngay_bat_dau)->format('d/m/Y') }}"
                                                data-ngay-het-han="{{ \Carbon\Carbon::parse($hd->ngay_het_han)->format('d/m/Y') }}"
                                                data-gia-thue="{{ number_format($hd->gia_thue, 0, ',', '.') }} VND"
                                                data-tien-coc="{{ number_format($hd->tien_coc, 0, ',', '.') }} VND"
                                                data-ghi-chu="{{ $hd->ghi_chu ?? '-' }}"
                                                data-landlord-ho-ten="{{ $hd->landlord_ho_ten ?? 'N/A' }}"
                                                data-landlord-sdt="{{ $hd->landlord_sdt ?? 'N/A' }}"
                                                data-landlord-cccd="{{ $hd->landlord_cccd ?? 'N/A' }}"
                                                data-landlord-cccd-ngay-cap="{{ $hd->landlord_cccd_ngay_cap ? \Carbon\Carbon::parse($hd->landlord_cccd_ngay_cap)->format('d/m/Y') : 'N/A' }}"
                                                data-landlord-cccd-noi-cap="{{ $hd->landlord_cccd_noi_cap ?? 'N/A' }}"
                                                data-landlord-hktt="{{ $hd->landlord_hktt ?? 'N/A' }}"
                                                data-trang-thai="{{ $hd->trang_thai }}"
                                                data-trang-thai-class="{{ $hd->trang_thai_class }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <a href="{{ route('admin.hop_dong.edit', $hd) }}" class="btn btn-sm btn-primary" title="Sửa"><i class="bi bi-pencil-square"></i></a>
                                            
                                            <form action="{{ route('admin.hop_dong.destroy', $hd) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xoá hợp đồng này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xoá"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có hợp đồng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $hopDongs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Chi Tiết Hợp Đồng -->
    <div class="modal fade" id="hopDongDetailModal" tabindex="-1" aria-labelledby="hopDongDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hopDongDetailModalLabel">Chi Tiết Hợp Đồng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="bi bi-file-earmark-text text-primary"></i> Thông tin hợp đồng</h6>
                            <hr class="mt-2">
                            <p><strong>ID Hợp đồng:</strong> #<span id="modal-id" class="fw-bold"></span></p>
                            <p><strong>Trạng thái:</strong> <span id="modal-trang-thai" class="badge rounded-pill"></span></p>
                            <p><strong>Giá thuê / tháng:</strong> <span id="modal-gia-thue" class="text-danger fw-bold"></span></p>
                            <p><strong>Tiền cọc:</strong> <span id="modal-tien-coc" class="text-success fw-bold"></span></p>
                            <p><strong>Ngày bắt đầu:</strong> <span id="modal-ngay-bat-dau"></span></p>
                            <p><strong>Ngày hết hạn:</strong> <span id="modal-ngay-het-han"></span></p>
                            <p><strong>Ghi chú:</strong> <span id="modal-ghi-chu"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="bi bi-people-fill text-primary"></i> Các bên liên quan</h6>
                            <hr class="mt-2">
                            <strong>Bên cho thuê (Chủ trọ):</strong>
                            <ul class="list-unstyled ps-3">
                                <li><strong>Họ tên:</strong> <span id="modal-landlord-ho-ten"></span></li>
                                <li><strong>SĐT:</strong> <span id="modal-landlord-sdt"></span></li>
                                <li><strong>CCCD:</strong> <span id="modal-landlord-cccd"></span></li>
                            </ul>
                            <strong>Bên thuê (Khách hàng):</strong>
                            <ul class="list-unstyled ps-3">
                                <li><strong>Họ tên:</strong> <span id="modal-nguoi-thue"></span></li>
                                <li><strong>Phòng thuê:</strong> <span id="modal-phong"></span></li>
                                <li><strong>Tại nhà trọ:</strong> <span id="modal-nha-tro"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="#" id="printContractBtn" class="btn btn-success" target="_blank">
                        <i class="bi bi-printer-fill"></i> In Hợp Đồng
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hopDongDetailModalEl = document.getElementById('hopDongDetailModal');
        if (hopDongDetailModalEl) {
            const hopDongDetailModal = new bootstrap.Modal(hopDongDetailModalEl);
            const viewButtons = document.querySelectorAll('.view-details-btn');
            const printBtn = document.getElementById('printContractBtn');
            
            // Lấy các element trong modal một lần để tối ưu
            const modalId = document.getElementById('modal-id');
            const modalTrangThai = document.getElementById('modal-trang-thai');
            const modalGiaThue = document.getElementById('modal-gia-thue');
            const modalTienCoc = document.getElementById('modal-tien-coc');
            const modalNgayBatDau = document.getElementById('modal-ngay-bat-dau');
            const modalNgayHetHan = document.getElementById('modal-ngay-het-han');
            const modalGhiChu = document.getElementById('modal-ghi-chu');
            const modalLandlordHoTen = document.getElementById('modal-landlord-ho-ten');
            const modalLandlordSdt = document.getElementById('modal-landlord-sdt');
            const modalLandlordCccd = document.getElementById('modal-landlord-cccd');
            const modalNguoiThue = document.getElementById('modal-nguoi-thue');
            const modalPhong = document.getElementById('modal-phong');
            const modalNhaTro = document.getElementById('modal-nha-tro');
            const modalTitle = document.getElementById('hopDongDetailModalLabel');

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const data = this.dataset;

                    // Điền dữ liệu vào modal
                    modalId.textContent = data.id;
                    modalTrangThai.textContent = data.trangThai;
                    modalTrangThai.className = 'badge rounded-pill ' + data.trangThaiClass; // Cập nhật class màu
                    modalGiaThue.textContent = data.giaThue;
                    modalTienCoc.textContent = data.tienCoc;
                    modalNgayBatDau.textContent = data.ngayBatDau;
                    modalNgayHetHan.textContent = data.ngayHetHan;
                    modalGhiChu.textContent = data.ghiChu;
                    modalLandlordHoTen.textContent = data.landlordHoTen;
                    modalLandlordSdt.textContent = data.landlordSdt;
                    modalLandlordCccd.textContent = data.landlordCccd;
                    modalNguoiThue.textContent = data.nguoiThue;
                    modalPhong.textContent = data.phong;
                    modalNhaTro.textContent = data.nhaTro;
                    modalTitle.textContent = `Chi Tiết Hợp Đồng #${data.id}`;

                    // Cập nhật đường dẫn cho nút In
                    let printUrl = "{{ route('admin.hop_dong.print', ['hopDong' => ':id']) }}";
                    printUrl = printUrl.replace(':id', data.id);
                    printBtn.setAttribute('href', printUrl);

                    // Hiển thị modal
                    hopDongDetailModal.show();
                });
            });
        }
    });
</script>
@endpush