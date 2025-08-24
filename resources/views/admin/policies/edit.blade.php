@extends('admin.index')
@section('contentadmin')
    


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới Chính sách</h5>

                    </div>

                    <form action="{{ route('policies.update', $policy) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Tiêu đề</label>
                                <input type="text" name="title" class="form-control" value="{{ $policy->title }}">
                            </div>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <div class="checkbox-wrapper-61" style="padding-left: 0">
                                <input type="checkbox" class="check" name="active" value="1" id="active"
                                    {{ old('active', $policy->active ?? true) ? 'checked' : '' }}>
                                <label for="active" class="label">
                                    <svg width="45" height="45" viewbox="0 0 95 95">
                                        <rect x="30" y="20" width="50" height="50" stroke="black" fill="none" />
                                        <g transform="translate(0,-952.36222)">
                                            <path
                                                d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                stroke="black" stroke-width="3" fill="none" class="path1" />
                                        </g>
                                    </svg>
                                    <span>Hiển thị chính sách</span>
                                </label>
                                {{-- <label for="tsr{{ $ts->id }}">{{ $ts->ten_tai_san }}</label> --}}
                            </div>
                            @error('active')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea name="content" id="tyni" rows="6" class="form-control" required>{{ $policy->content }}</textarea>
                            </div>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>



                        {{-- <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="active" value="1"
                                {{ old('active', $policy->active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label">Hiển thị chính sách</label>
                        </div> --}}


                        <div class="text-end">
                            <button type="submit" class="btn btn-success">💾 Cập nhật</button>
                        <a href="{{ route('policies.index') }}" class="btn btn-secondary">🔙 Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
