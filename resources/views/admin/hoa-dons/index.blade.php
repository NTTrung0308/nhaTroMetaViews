@extends('admin.index')
@section('contentadmin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Danh Sách Hóa Đơn</h1>
    <a href="{{ route('hoa-dons.generate.form') }}" class="btn btn-primary">
        <i class="fa-solid fa-file-invoice-dollar"></i> Tạo Hóa Đơn Hàng Loạt
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Mã HĐ</th>
                    <th>Phòng</th>
                    <th>Người Thuê</th>
                    <th>Kỳ HĐ</th>
                    <th class="text-end">Tổng Phải Trả</th>
                    <th class="text-end">Còn Nợ</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-end">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hoaDons as $hd)
                <tr>
                    <td>{{ $hd->ma_hoa_don }}</td>
                    <td>{{ $hd->room->ten_phong ?? 'N/A' }}</td>
                    <td>{{ $hd->user->name ?? 'N/A' }}</td>
                    <td>Tháng {{ $hd->thang }}/{{ $hd->nam }}</td>
                    <td class="text-end">{{ number_format($hd->tong_tien + $hd->no_ky_truoc, 0) }} đ</td>
                    <td class="text-end fw-bold {{ $hd->con_no > 0 ? 'text-danger' : 'text-success' }}">{{ number_format($hd->con_no, 0) }} đ</td>
                    <td class="text-center">
                        @if($hd->trang_thai == 'da_thanh_toan')
                            <span class="badge bg-success">Đã thanh toán</span>
                        @elseif($hd->trang_thai == 'qua_han')
                             <span class="badge bg-danger">Quá hạn</span>
                        @elseif($hd->trang_thai == 'da_huy')
                             <span class="badge bg-secondary">Đã hủy</span>
                        @else
                             <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <form action="{{ route('hoa-dons.destroy', $hd->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?');">
                            <a href="{{ route('hoa-dons.show', $hd->id) }}" class="btn btn-sm btn-info" title="Xem"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('hoa-dons.edit', $hd->id) }}" class="btn btn-sm btn-warning" title="Cập nhật thanh toán"><i class="fa fa-dollar-sign"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Chưa có hóa đơn nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $hoaDons->links() }}
    </div>
</div>
@endsection