@extends('admin.index')
@section('contentadmin')

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Bảng điều khiển</h1>

    {{-- Form Lọc Dữ Liệu --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bộ lọc</h6>
        </div>
        <div class="card-body">
            <form id="dashboard-filter-form">
                <div class="row align-items-end">
                    {{-- Bộ lọc cho Admin/Quản lý --}}
                    @can('Xem toàn bộ thống kê')
                    <div class="col-md-3 mb-3">
                        <label for="filter-nha-tro" class="form-label">Nhà trọ</label>
                        <select name="nha_tro_id" id="filter-nha-tro" class="form-control">
                            <option value="">-- Tất cả nhà trọ --</option>
                            @foreach($nhaTros as $nhaTro)
                                <option value="{{ $nhaTro->id }}">{{ $nhaTro->ten_nha_tro }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="filter-room" class="form-label">Phòng</label>
                        <select name="room_id" id="filter-room" class="form-control" disabled>
                            <option value="">-- Chọn nhà trọ trước --</option>
                        </select>
                    </div>
                    @endcan

                    {{-- Bộ lọc chung cho mọi người --}}
                    <div class="col-md-2 mb-3">
                        <label for="filter-thang" class="form-label">Tháng</label>
                        <select name="thang" id="filter-thang" class="form-control">
                            <option value="">-- Cả năm --</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">Tháng {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="filter-nam" class="form-label">Năm</label>
                        <select name="nam" id="filter-nam" class="form-control">
                            <option value="">-- Tất cả năm --</option>
                            @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-filter"></i> Lọc
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @can('Xem toàn bộ thống kê')
        <div class="alert alert-info">Bạn đang xem thống kê toàn bộ hệ thống.</div>
    @else
        <div class="alert alert-warning">Bạn đang xem thống kê cá nhân.</div>
    @endcan

    <!-- Hàng 1: Các thẻ KPI -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Doanh thu (Theo bộ lọc)</div>
                            <div id="kpi-doanh-thu" class="h5 mb-0 font-weight-bold text-gray-800">Đang tải...</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar-alt fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng nợ cần thu</div>
                            <div id="kpi-tong-no" class="h5 mb-0 font-weight-bold text-gray-800">Đang tải...</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Số phòng có hóa đơn</div>
                            <div id="kpi-phong-thue" class="h5 mb-0 font-weight-bold text-gray-800">Đang tải...</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-person-booth fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Hóa đơn quá hạn</div>
                            <div id="kpi-hoa-don-qua-han" class="h5 mb-0 font-weight-bold text-gray-800">Đang tải...</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hàng 2: Các biểu đồ -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Thống kê doanh thu</h6></div>
                <div class="card-body"><div class="chart-area"><canvas id="revenueChart"></canvas></div></div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tỷ lệ trạng thái hóa đơn</h6></div>
                <div class="card-body"><div class="chart-pie pt-4"><canvas id="statusChart"></canvas></div></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Thêm Chart.js nếu layout của bạn chưa có --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- CÁC BIẾN VÀ HÀM TIỆN ÍCH ---
        const formatCurrency = (number) => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        let revenueChartInstance, statusChartInstance;
        const filterForm = document.getElementById('dashboard-filter-form');
        const nhaTroSelect = document.getElementById('filter-nha-tro');
        const roomSelect = document.getElementById('filter-room');

        // --- HÀM VẼ BIỂU ĐỒ ---
        const renderCharts = (data) => {
            if (revenueChartInstance) revenueChartInstance.destroy();
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            revenueChartInstance = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: data.revenueChart.labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: data.revenueChart.data,
                        backgroundColor: 'rgba(78, 115, 223, 0.8)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { callback: (value) => formatCurrency(value) } } },
                    plugins: { tooltip: { callbacks: { label: (context) => formatCurrency(context.raw) } } }
                }
            });

            if (statusChartInstance) statusChartInstance.destroy();
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChartInstance = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: data.statusChart.labels,
                    datasets: [{
                        data: data.statusChart.data,
                        backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b', '#858796'],
                        hoverBackgroundColor: ['#f4b619', '#17a673', '#e02d1b', '#6e707e'],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        };

        // --- HÀM CẬP NHẬT GIAO DIỆN ---
        const updateDashboard = (data) => {
            document.getElementById('kpi-doanh-thu').innerText = formatCurrency(data.kpi.doanhThuThangNay);
            document.getElementById('kpi-tong-no').innerText = formatCurrency(data.kpi.tongNoPhaiThu);
            document.getElementById('kpi-phong-thue').innerText = data.kpi.soPhongDangThue;
            document.getElementById('kpi-hoa-don-qua-han').innerText = data.kpi.soHoaDonQuaHan;
            renderCharts(data);
        };

        // --- HÀM GỌI API CHÍNH ---
        const fetchDashboardData = () => {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const url = `{{ route('admin.dashboard.stats') }}?${params.toString()}`;

            // Thêm hiệu ứng loading
            document.querySelectorAll('.h5.font-weight-bold').forEach(el => el.innerText = 'Đang tải...');
            
            fetch(url)
                .then(response => response.ok ? response.json() : Promise.reject('Failed to load'))
                .then(updateDashboard)
                .catch(error => {
                    console.error('Lỗi khi tải dữ liệu dashboard:', error);
                    document.getElementById('kpi-doanh-thu').innerText = 'Lỗi tải dữ liệu';
                });
        };

        // --- CÁC SỰ KIỆN ---
        // 1. Lọc khi submit form
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn trang tải lại
            fetchDashboardData();
        });

        // 2. Tải phòng khi chọn nhà trọ (chỉ tồn tại nếu người dùng là admin/quản lý)
        if (nhaTroSelect) {
            nhaTroSelect.addEventListener('change', function() {
                const nhaTroId = this.value;
                roomSelect.innerHTML = '<option value="">Đang tải...</option>';
                roomSelect.disabled = true;

                if (!nhaTroId) {
                    roomSelect.innerHTML = '<option value="">-- Chọn nhà trọ trước --</option>';
                    return;
                }
                
                // Sử dụng route đã định nghĩa để lấy phòng
                const roomUrl = `{{ route('admin.dashboard.getRooms', ['nhaTroId' => ':id']) }}`.replace(':id', nhaTroId);

                fetch(roomUrl)
                    .then(response => response.json())
                    .then(rooms => {
                        roomSelect.innerHTML = '<option value="">-- Tất cả phòng --</option>';
                        rooms.forEach(room => {
                            const option = new Option(room.ten_phong, room.id);
                            roomSelect.add(option);
                        });
                        roomSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải danh sách phòng:', error);
                        roomSelect.innerHTML = '<option value="">Lỗi tải phòng</option>';
                    });
            });
        }

        // --- TẢI DỮ LIỆU LẦN ĐẦU KHI VÀO TRANG ---
        fetchDashboardData();
    });
</script>
@endpush