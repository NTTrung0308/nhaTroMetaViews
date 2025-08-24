@extends('admin.index')
@section('contentadmin')
  


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới dịch vụ của chúng tôi</h5>

                    </div>
                    <form action="{{ route('admin.service_about_home.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Mô tả</label>
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Ảnh</label>
                            <input type="file" name="image" class="form-control" id="imageInput">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <!-- Ảnh xem trước -->
                            <div class="mt-2">
                                <img id="previewImage" src="#" alt="Xem trước ảnh"
                                    style="max-width: 200px; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label>Nội dung</label>
                            <textarea name="content" class="form-control" id="tyni" rows="5">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="show_on_home" id="show_on_home" class="form-check-input">
                            <label for="show_on_home" class="form-check-label">Hiển thị ở trang chủ</label>
                        </div>
                        <div class="text-end">

                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        #previewImage {
            transition: transform 0.2s ease;
        }

        #previewImage:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
    </script>
@endpush
