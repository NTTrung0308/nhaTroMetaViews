@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Danh sách dịch vụ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Danh sách dịch vụ của chúng tôi</li>
            </ol>
        </nav>
    </div>

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung Dịch vụ</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm dịch vụ về chúng tôi'))
                            <a href="{{ route('admin.service_about_home.create') }}"
                                class="btn btn-success rounded-pill">Thêm Dịch vụ</a>
                        @endif
                    </div>
                    <hr>
                    <form action="{{ route('admin.service_about_home.index') }}" method="GET"
                        class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="title" class="form-control" placeholder="Tìm tiêu đề"
                                    value="{{ request('title') }}">
                            </div>

                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary  w-100"><i class="bi bi-search"></i> Tìm
                                    kiếm</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th>Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Hiển thị</th>
                                    <th>Ảnh</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($serviceAbouts as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->show_on_home ? 'Có' : 'Không' }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset($item->image) }}" style="max-width: 50px;">
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa dịch vụ về chúng tôi'))
                                                <a href="{{ route('admin.service_about_home.edit', $item->id) }}"
                                                    class="btn btn-warning btn-sm"> <i class="bi bi-wrench"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa dịch vụ về chúng tôi'))
                                                <form action="{{ route('admin.service_about_home.destroy', $item->id) }}"
                                                    method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"> <i
                                                            class="bi bi-trash text-white"></i></button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-info btn-sm text-white view-detail-btn"
                                                data-title="{{ $item->title }}"
                                                data-description="{{ $item->description }}"
                                                data-content="{{ $item->content }}"
                                                data-image="{{ $item->image ? asset($item->image) : '' }}"
                                                data-show="{{ $item->show_on_home ? 'Có' : 'Không' }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có dịch vụ nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $serviceAbouts->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- Modal xem chi tiết --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Chi tiết dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                   
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-3">
                                <img id="modalImage" src="" alt=""
                                    style="max-width: 100%; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                            </div>
                        </div>
                        <div class="col-lg-8">
                             <h5 id="modalTitle"></h4>
                            <p><strong>Mô tả:</strong> <span id="modalDescription"></span></p>
                            <p><strong>Hiển thị ở trang chủ:</strong> <span id="modalShow"></span></p>
                            <p><strong>Nội dung:</strong></p>
                        </div>
                    </div>
                    <div id="modalContent" class="border p-2 rounded mt-4" style="white-space: pre-line;"></div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.view-detail-btn');
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('modalTitle').textContent = this.dataset.title;
                    document.getElementById('modalDescription').textContent = this.dataset
                        .description;
                    document.getElementById('modalContent').innerHTML  = this.dataset.content;
                    document.getElementById('modalShow').textContent = this.dataset.show;

                    const img = document.getElementById('modalImage');
                    if (this.dataset.image) {
                        img.src = this.dataset.image;
                        img.style.display = 'block';
                    } else {
                        img.style.display = 'none';
                    }

                    modal.show();
                });
            });
        });
    </script>
@endpush
