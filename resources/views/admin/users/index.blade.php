@extends('admin.index')
@section('contentadmin')
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
              
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung Người dùng</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm người dùng'))
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success rounded-pill">Thêm người
                                dùng</a>
                        @endif
                    </div>
                    <div class="row">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="row align-items-end g-3 mb-4">

                            <div class="col-md-4">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ request('email') }}">
                            </div>



                            <div class="col-md-2">
                                <label class="form-label">Trạng thái</label>
                                <select name="active" class="form-select">
                                    <option value="">-- Tất cả --</option>
                                    <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Ẩn
                                    </option>
                                    <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Hiện
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Xoá lọc</a>
                            </div>
                        </form>



                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">

                            <thead>
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Email</th>

                                    <th>Ngày sinh</th>
                                    <th>Hoạt động</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>

                                        <td>{{ $user->birthday ?? 'Chưa có ngày sinh' }}</td>
                                        <td>{{ $user->active ? 'Có' : 'Không' }}</td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa người dùng'))
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm"><i
                                                        class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa người dùng'))
                                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                                    style="display:inline-block;">
                                                    @csrf @method('DELETE')
                                                    <button onclick="return confirm('Xoá người dùng này?')"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif
                                            <button class="btn btn-info btn-sm"
                                                onclick="showUserDetail({{ json_encode($user) }})">
                                                <i class="icon-base bx bx-show"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Dữ liệu trống.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class=" p-nav text-end d-flex justify-content-end">
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <div class=" p-nav text-end d-flex justify-content-end">
                    {{-- {{ $rooms->appends(request()->query())->links('pagination::bootstrap-4') }} --}}
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailModalLabel">Chi tiết người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body" id="userDetailContent">
                    <!-- Nội dung sẽ được render bằng JS -->
                </div>
            </div>
        </div>
    </div>
    <script>
        function showUserDetail(user) {
            let html = `
             <div class="row">
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1"><span class="mb-1 false">Ảnh
                                            đại
                                            diện <!----></span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-avatar"
                                                    src="${user.avatar ? `${window.location.origin + '/' + user.avatar}` : '/assets/img/default_image.png'}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; ">
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </span>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1"><span class="mb-1 false">CMND Trước</span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-avatar"
                                                    src="${user.cmt_mat_truoc ? `${window.location.origin + '/' + user.cmt_mat_truoc}` : '/assets/img/default_image.png'}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; ">
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </span>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1"><span class="mb-1 false">CMND Sau</span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-avatar"
                                                    src="${user.cmt_mat_sau ? `${window.location.origin + '/' + user.cmt_mat_sau}` : '/assets/img/default_image.png'}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; ">
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </span>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-6 d-flex justify-content-center">
                                <span>
                                    <div class="d-flex flex-column mb-1"><span class="mb-1 false">Hộ chiếu</span>
                                        <div class="position-relative image-container-user mb-2">
                                            <div style="width: 100px; height: 100px; position: relative; overflow: hidden;"
                                                class="mb-2 thumbnail">
                                                <img id="preview-avatar"
                                                    src="${user.ho_chieu ? `${window.location.origin + '/' + user.ho_chieu}` : '/assets/img/default_image.png'}"
                                                    alt="Xem trước ảnh"
                                                    style="width: 100%; height: 100%; object-fit: cover; ">
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </span>
                            </div>
                           <div class="col-lg-4 mb-3"><strong>Họ tên:</strong>${user.name ?? 'Không có'}</div>
                           <div class="col-lg-4 mb-3"><strong>Email:</strong>${user.email ?? 'Không có'}</div>
                           <div class="col-lg-4 mb-3"><strong>Số điện thoại:</strong>${user.phone ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Giới tính:</strong>${user.gioi_tinh ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Ngày sinh:</strong>${user.birthday ?? 'Không rõ'}</div>                         
                           <div class="col-lg-4 mb-3"><strong>Trạng thái:</strong>${user.active ? 'Đang hoạt động' : 'Không hoạt động'}</div>
                           <div class="col-lg-4 mb-3"><strong>Số cmnd:</strong>${user.cmnd ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Ngày cấp cmnd:</strong>${user.ngay_cap_cmnd ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Nơi cấp cmnd:</strong>${user.noi_cap_cmnd ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Thành phố:</strong>${user.thanh_pho ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Huyện:</strong>${user.huyen ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Xã:</strong>${user.xa ?? 'Không rõ'}</div>
                           <div class="col-lg-6 mb-3"><strong>Số tài khoản:</strong>${user.stk ?? 'Không rõ'}</div>
                           <div class="col-lg-6 mb-3"><strong>Ngân hàng:</strong>${user.ngan_hang ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Nghề nghiệp:</strong>${user.nghe_nghiep ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Nơi làm việc:</strong>${user.noi_lam_viec ?? 'Không rõ'}</div>
                           <div class="col-lg-4 mb-3"><strong>Mã vân tay:</strong>${user.ma_van_tay ?? 'Không rõ'}</div>
                            <div class="col-lg-12 mb-3"><strong>Địa chỉ:</strong>${user.address ?? 'Không rõ'}</div>
                            <div class="col-lg-12 mb-3"><strong>Ghi chú:</strong>${user.note ?? 'Không rõ'}</div>
                        </div>
        
            `;
            document.getElementById('userDetailContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('userDetailModal')).show();
        }
    </script>
@endsection
