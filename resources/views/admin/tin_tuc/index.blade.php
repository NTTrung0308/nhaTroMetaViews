@extends('admin.index')
@section('contentadmin')
   



    <div class="row">

        <div class="col-lg-12">

            <div class="card">
               
                <div class="card-body">

                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách Tin tức</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm tin tức'))
                            <a href="{{ route('tin_tuc.create') }}" class="btn btn-success rounded-pill">Thêm mới</a>
                        @endif
                    </div>
                    <hr>
                    <form action="{{ route('tin_tuc.index') }}" method="GET"
                        class="row mb-3 d-flex justify-content-center align-items-center">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="tieu_de" class="form-control" placeholder="Tìm tiêu đề"
                                    value="{{ request('tieu_de') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="tac_gia" class="form-control" placeholder="Tìm tác giả"
                                    value="{{ request('tac_gia') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="trang_thai" class="form-control">
                                    <option value="">-- Tất cả trạng thái --</option>
                                    <option value="hien_thi" {{ request('trang_thai') == 'hien_thi' ? 'selected' : '' }}>
                                        Hiển
                                        thị</option>
                                    <option value="nhap" {{ request('trang_thai') == 'nhap' ? 'selected' : '' }}>Bản nháp
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary  w-100"><i class="bi bi-search"></i> Tìm
                                    kiếm</button>
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Tác giả</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tinTucs as $tt)
                                        <tr>
                                            <td>{{ $tt->tieu_de }}</td>
                                            <td>{{ $tt->tac_gia }}</td>
                                            <td>{{ $tt->trang_thai == 'hien_thi' ? 'Hiện thị' : 'Bản nháp' }}</td>
                                            <td>{{ $tt->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if (auth()->user()->hasPermissionTo('Sửa tin tức'))
                                                    <a href="{{ route('tin_tuc.edit', $tt->id) }}"
                                                        class="btn btn-warning btn-sm"><i class="icon-base bx bx-edit-alt"></i></a>
                                                @endif
                                                @if (auth()->user()->hasPermissionTo('Xóa tin tức'))
                                                    <form action="{{ route('tin_tuc.destroy', $tt->id) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Xóa tin tức này?')"><i class="icon-base bx bx-trash"></i></button>
                                                    </form>
                                                @endif
                                                <button type="button" class="btn btn-info btn-sm btn-xem-chi-tiet"
                                                    data-bs-toggle="modal" data-bs-target="#modalChiTiet"
                                                    data-tieude="{{ $tt->tieu_de }}" data-noidung="{{ $tt->noi_dung }}"
                                                    data-mota="{{ $tt->mo_ta_ngan }}" data-tacgia="{{ $tt->tac_gia }}"
                                                    data-anh="{{ asset($tt->hinh_anh) }}">
                                                    <i class="icon-base bx bx-show"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Không có dữ liệu tin tức.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class=" p-nav text-end d-flex justify-content-end">
                    {{ $tinTucs->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modalChiTiet" tabindex="-1" aria-labelledby="modalChiTietLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết tin tức</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="d-flex">

                                <h5 id="ct-tieu-de"></h5>
                            </div>
                            <p class="text-muted"><span id="ct-tac-gia"></span></p>
                            <img id="ct-hinh-anh" src="" class="img-fluid mb-3" style="max-height: 300px;">
                        </div>
                        <div class="col-lg-4">
                            <label for="">Mô tả ngắn:</label>
                            <p id="ct-mo-ta" class="fst-italic text-secondary"></p>
                        </div>
                    </div>

                    <hr>
                    <div id="ct-noi-dung" style="max-height: 400px; overflow-y: auto; word-wrap: break-word;"></div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalChiTiet');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                document.getElementById('ct-tieu-de').textContent = "Tiêu đề: " + button.getAttribute(
                    'data-tieude');
                document.getElementById('ct-tac-gia').textContent = "Tác giả: " + button.getAttribute(
                    'data-tacgia');
                document.getElementById('ct-mo-ta').textContent = button.getAttribute('data-mota');
                document.getElementById('ct-noi-dung').innerHTML = button.getAttribute('data-noidung');
                document.getElementById('ct-hinh-anh').src = button.getAttribute('data-anh');
            });
        });
    </script>
@endsection
