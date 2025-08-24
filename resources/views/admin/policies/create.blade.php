@extends('admin.index')
@section('contentadmin')
    


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới Chính sách</h5>

                    </div>

                    <form action="{{ route('policies.store') }}" method="POST">
                        @csrf

                      <div class="col-lg-12">
                          <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                      
                          <div class="col-lg-12">
                              <div class="checkbox-wrapper-61" style="padding-left: 0">
                                <input type="checkbox" class="check" name="active" value="1"
                                    id="active"  {{ old('active', $policy->active ?? true) ? 'checked' : '' }}>
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





                            {{-- <input class="form-check-input" type="checkbox" name="active" value="1"
                                {{ old('active', $policy->active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label">Hiển thị chính sách</label> --}}

                       

                       <div class="col-lg-12">
                         <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea name="content" rows="6" id="tyni" class="form-control">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                       </div>
                       <div class="text-end">
                         <button type="submit" class="btn btn-success">💾 Lưu</button>
                        <a href="{{ route('policies.index') }}" class="btn btn-secondary">🔙 Quay lại</a>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
