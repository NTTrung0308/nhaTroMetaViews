@extends('admin.index')
@section('contentadmin')
    

    <div class="card p-3">
         <h5 class="card-header">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Về chúng tôi</li>

                </ol>
            </nav>
        </h5>
        <style>
            .image-upload-wrapper {
                width: 190px;
                height: 190px;
                border: 2px dashed #ccc;
                border-radius: 8px;
                cursor: pointer;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                background-color: #f8f9fa;
            }

            .image-upload-wrapper img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-upload-wrapper .plus-icon {
                font-size: 32px;
                color: #888;
                position: absolute;
            }

            input[type="file"] {
                display: none;
            }
        </style>
        <form action="{{ route('about_us.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="form-label">Ảnh đại diện</label>
                        <div class="image-upload-wrapper" onclick="document.getElementById('imageInput').click()">
                            @if ($about->image)
                                <img id="imagePreview" src="{{ asset($about->image) }}" alt="Preview">
                            @else
                                <div class="image-placeholder" id="placeholder">+</div>
                                <img id="imagePreview" style="display: none;">
                            @endif
                        </div>
                        <input type="file" name="image" id="imageInput" class="form-control d-none" accept="image/*">
                        @error('image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="mb-3">
                        <label>Tiêu đề</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $about->title) }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Mô tả ngắn</label>
                        <textarea name="description" class="form-control">{{ old('description', $about->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <label>Hiển thị</label>
                            <select name="active" class="form-select">
                                <option value="1" {{ old('active', $about->active) == 1 ? 'selected' : '' }}>Hiển thị
                                </option>
                                <option value="0" {{ old('active', $about->active) == 0 ? 'selected' : '' }}>Ẩn
                                </option>
                            </select>
                            @error('active')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>




            <div class="mb-3">
                <label>Nội dung đầy đủ</label>
                <textarea name="content" class="form-control" id="tyni" rows="6">{{ old('content', $about->content) }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="mb-3">
                <label>Tiêu đề sứ mệnh</label>
                <input type="text" name="mission_title" class="form-control"
                    value="{{ old('mission_title', $about->mission_title) }}">
                @error('mission_title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Sứ mệnh</label>
                <textarea name="mission" class="form-control">{{ old('mission', $about->mission) }}</textarea>
                @error('mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Tiêu đề tầm nhìn</label>
                <input type="text" name="vision_title" class="form-control"
                    value="{{ old('vision_title', $about->vision_title) }}">
                @error('vision_title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Tầm nhìn</label>
                <textarea name="vision" class="form-control">{{ old('vision', $about->vision) }}</textarea>
                @error('vision')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="text-end">
                <button class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    const placeholder = document.getElementById('placeholder');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (placeholder) placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
