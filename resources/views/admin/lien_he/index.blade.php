@extends('admin.index')
@section('contentadmin')
  



    <div class="row">

        <div class="col-lg-12">


            <div class="card">
                 <h5 class="card-header">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Liên hệ</li>

                </ol>
            </nav>
        </h5>
                <div class="card-body">


                    <form method="GET" action="{{ route('lien_he.index.admin') }}" class="row g-2 mb-4 mt-2">
                        <div class="col-md-5">
                            <input type="text" name="ten" class="form-control" placeholder="Tìm theo tên"
                                value="{{ request('ten') }}">
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="ngay_tao" class="form-control" value="{{ request('ngay_tao') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            <a href="{{ route('lien_he.index.admin') }}" class="btn btn-secondary">Xóa lọc</a>
                        </div>
                    </form>


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>

                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dsLienHe as $lh)
                                    <tr>
                                        <td>{{ $lh->ten }}</td>
                                        <td>{{ $lh->email }}</td>
                                        <td>{{ $lh->so_dien_thoai }}</td>

                                        <td>{{ $lh->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info btn-xem-chi-tiet"
                                                data-ten="{{ $lh->ten }}" data-email="{{ $lh->email }}"
                                                data-sdt="{{ $lh->so_dien_thoai }}" data-noidung="{{ $lh->noi_dung }}"
                                                data-thoigian="{{ $lh->created_at->format('d/m/Y H:i') }}">
                                                Xem chi tiết
                                            </button>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có liên hệ nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
                <div class=" p-nav text-end d-flex justify-content-end">
                    {{ $dsLienHe->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="modalChiTietLienHe" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết liên hệ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Họ tên:</strong> <span id="ct-ten"></span></p>
                    <p><strong>Email:</strong> <span id="ct-email"></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="ct-sdt"></span></p>
                    <p><strong>Thời gian gửi:</strong> <span id="ct-thoigian"></span></p>
                    <p style="max-height: 400px; overflow-y: auto; word-wrap: break-word;"><strong>Nội dung:</strong> <span
                            id="ct-noidung"></span></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-xem-chi-tiet');

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('ct-ten').textContent = this.dataset.ten;
                    document.getElementById('ct-email').textContent = this.dataset.email;
                    document.getElementById('ct-sdt').textContent = this.dataset.sdt || 'Không có';
                    document.getElementById('ct-noidung').textContent = this.dataset.noidung;
                    document.getElementById('ct-thoigian').textContent = this.dataset.thoigian;

                    const modal = new bootstrap.Modal(document.getElementById(
                    'modalChiTietLienHe'));
                    modal.show();
                });
            });
        });
    </script>
@endsection
