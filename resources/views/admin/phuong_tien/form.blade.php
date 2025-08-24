@extends('admin.index')
@section('contentadmin')
    


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới Phương tiện</h5>

                    </div>


                    @php $isEdit = isset($phuongTien); @endphp
                    <form method="POST"
                        action="{{ $isEdit ? route('admin.phuong_tiens.update', $phuongTien->id) : route('admin.phuong_tiens.store') }}">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label>Tên phương tiện</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $phuongTien->name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Biển số</label>
                            <input type="text" name="bien_so" class="form-control"
                                value="{{ old('bien_so', $phuongTien->bien_so ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Loại phương tiện</label>
                            <select name="loai_phuong_tien" class="form-select" required>
                                @foreach (['o_to', 'o_to_dien', 'xe_may', 'xe_may_dien', 'xe_dap', 'xe_dap_dien'] as $loai)
                                    <option value="{{ $loai }}" @selected(old('loai_phuong_tien', $phuongTien->loai_phuong_tien ?? '') === $loai)>
                                        {{ ucfirst(str_replace('_', ' ', $loai)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tên chủ xe</label>
                            <input type="text" name="ten_chu_xe" class="form-control"
                                value="{{ old('ten_chu_xe', $phuongTien->ten_chu_xe ?? '') }}" required>
                        </div>

                        @if (!empty($selectedUserId))
                            @php
                                $selectedUser = $users->firstWhere('id', $selectedUserId);
                            @endphp
                            <div class="mb-3">
                                <label>Khách hàng</label>
                                <input type="text" class="form-control"
                                    value="{{ $selectedUser->name }} - {{ $selectedUser->email }}" disabled>
                                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
                            </div>
                        @else
                            <div class="mb-3">
                                <label>Khách hàng</label>
                                <select name="user_id" class="form-control select_ted" required>
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id', $phuongTien->user_id ?? '') == $user->id)>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif


                        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Cập nhật' : 'Thêm mới' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
