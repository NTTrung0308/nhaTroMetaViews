@extends('admin.index')
@section('contentadmin')
    <style>
        #imagePreviewWrapper {
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 10px;
            display: inline-block;
            background-color: #f8f9fa;
        }

        #previewImage {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
   

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ isset($feedback) ? 'Sửa cảm nghĩ' : 'Thêm cảm nghĩ' }}</h5>

                    </div>
                    <div class="col-12">
                        <form
                            action="{{ isset($feedback) ? route('feedbacks.update', $feedback) : route('feedbacks.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($feedback))
                                @method('PUT')
                            @endif

                            <div class="row">
                                {{-- Tên --}}
                                <div class="mb-3 col-lg-6">
                                    <label>Tên</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $feedback->name ?? '') }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Chức vụ --}}
                                <div class="mb-3 col-lg-6">
                                    <label>Chức vụ</label>
                                    <input type="text" name="position"
                                        class="form-control @error('position') is-invalid @enderror"
                                        value="{{ old('position', $feedback->position ?? '') }}">
                                    @error('position')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Hiển thị --}}
                                <div class="col-lg-12">
                                    <div class="checkbox-wrapper-61">
                                        <input type="checkbox" name="active" class="check" value="1" id="active"
                                            {{ old('active', $feedback->active ?? true) ? 'checked' : '' }}>
                                        <label for="active" class="label">
                                            <svg width="45" height="45" viewbox="0 0 95 95">
                                                <rect x="30" y="20" width="50" height="50" stroke="black"
                                                    fill="none" />
                                                <g transform="translate(0,-952.36222)">
                                                    <path
                                                        d="m 56,963 c -102,122 6,9 7,9 17,-5 -66,69 -38,52 122,-77 -7,14 18,4 29,-11 45,-43 23,-4 "
                                                        stroke="black" stroke-width="3" fill="none" class="path1" />
                                                </g>
                                            </svg>
                                            <span>Hiển thị</span>
                                        </label>
                                    </div>
                                    @error('active')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Ảnh đại diện --}}
                                <div class="mb-3 col-lg-12">
                                    <label>Ảnh đại diện</label>
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" id="imageInput2">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    <div id="imagePreviewWrapper" class="mt-2" style="max-width: 200px;">
                                        <img id="previewImage"
                                            src="{{ isset($feedback) && $feedback->image ? asset($feedback->image) : '' }}"
                                            alt="Ảnh xem trước" class="img-thumbnail"
                                            style="max-height: 150px; {{ isset($feedback) && $feedback->image ? '' : 'display:none;' }}">
                                    </div>
                                </div>

                                {{-- Nội dung --}}
                                <div class="mb-3 col-lg-12">
                                    <label>Nội dung cảm nghĩ</label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4" required>{{ old('message', $feedback->message ?? '') }}</textarea>
                                    @error('message')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-success">{{ isset($feedback) ? 'Cập nhật' : 'Thêm mới' }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('imageInput2').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('previewImage');

            if (!file) {
                preview.style.display = 'none';
                preview.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
