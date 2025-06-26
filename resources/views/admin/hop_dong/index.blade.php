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
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung hợp đồng</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm hợp đồng'))
                            <a href="{{ route('admin.hop_dong.create') }}" class="btn btn-success rounded-pill">Thêm hợp
                                đồng
                                Mới</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Người thuê</th>
                                    <th>Tòa nhà</th>
                                    <th>Phòng</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Ghi chú</th>
                                    <th>Trạng thái phòng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hopDongs as $hd)
                                    <tr>
                                        <td>{{ $hd->id }}</td>
                                        <td>{{ $hd->user->name ?? 'N/A' }}</td>
                                        <td>{{ $hd->nhaTro->ten_toa_nha ?? 'N/A' }}</td>
                                        <td>{{ $hd->room->ma_phong ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($hd->ngay_bat_dau)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($hd->ngay_ket_thuc)->format('d/m/Y') }}</td>
                                        <td>{{ $hd->ghi_chu ?? '-' }}</td>
                                        <td>
                                            @if ($hd->room)
                                                <span
                                                    class="badge bg-{{ $hd->room->status === 'da_thue' ? 'success' : ($hd->room->status === 'tam_khoa' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $hd->room->status)) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Không xác định</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.hop_dong.edit', $hd) }}"
                                                class="btn btn-sm btn-primary">Sửa</a>
                                            <form action="{{ route('admin.hop_dong.destroy', $hd) }}" method="POST"
                                                style="display:inline-block"
                                                onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Xoá</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="9">Không có hợp đồng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $hopDongs->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
