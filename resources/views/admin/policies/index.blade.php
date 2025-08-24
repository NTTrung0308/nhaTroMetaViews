@extends('admin.index')
@section('contentadmin')
   

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách chính sách</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm chính sách'))
                            <a href="{{ route('policies.create') }}" class="btn btn-success rounded-pill">Thêm chính
                                sách</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>Tiêu đề</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($policies as $policy)
                                    <tr>
                                        <td>{{ $policy->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $policy->active ? 'success' : 'secondary' }}">
                                                {{ $policy->active ? 'Hiển thị' : 'Ẩn' }}
                                            </span>
                                        </td>
                                        <td>{{ $policy->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa chính sách'))
                                                <a href="{{ route('policies.edit', $policy) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa chính sách'))
                                                <form action="{{ route('policies.destroy', $policy) }}" method="POST"
                                                    style="display:inline-block;"
                                                    onsubmit="return confirm('Xác nhận xoá?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif

                                            <button class="btn btn-sm btn-info btn-show-policy"
                                                data-title="{{ $policy->title }}"
                                                data-content="{{ base64_encode($policy->content) }}" data-bs-toggle="modal"
                                                data-bs-target="#policyDetailModal">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Chưa có chính sách nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal chi tiết -->
    <div class="modal fade" id="policyDetailModal" tabindex="-1" aria-labelledby="policyDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="policyDetailModalLabel">Tiêu đề chính sách</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="policyModalContent"
                    style="max-height: 400px; overflow-y: auto; word-wrap: break-word;">
                    Nội dung chính sách...
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-show-policy').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const title = this.dataset.title;
                    const encodedContent = this.dataset.content;
                    const content = atob(encodedContent); // giải mã base64

                    document.getElementById('policyDetailModalLabel').textContent = title;
                    document.getElementById('policyModalContent').innerHTML = content;
                });
            });
        });
    </script>
@endsection
