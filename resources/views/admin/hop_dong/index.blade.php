@extends('admin.index')
@section('contentadmin')

<h4>Danh sách hợp đồng thuê phòng</h4>

<a href="{{ route('admin.hop_dong.create') }}" class="btn btn-success mb-3">+ Thêm hợp đồng</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
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
                    @if($hd->room)
                        <span class="badge bg-{{ $hd->room->status === 'da_thue' ? 'success' : ($hd->room->status === 'tam_khoa' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $hd->room->status)) }}
                        </span>
                    @else
                        <span class="text-muted">Không xác định</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.hop_dong.edit', $hd) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <form action="{{ route('admin.hop_dong.destroy', $hd) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xoá</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8">Không có hợp đồng nào.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $hopDongs->links() }}

@endsection
