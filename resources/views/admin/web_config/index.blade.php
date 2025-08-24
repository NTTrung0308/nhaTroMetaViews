@extends('admin.index')
@section('contentadmin')
    <div class="card p-3">
        <h5 class="card-header">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Cấu hình</li>

                </ol>
            </nav>
        </h5>
        <form action="{{ route('web-config.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <ul class="nav nav-tabs mb-3" id="configTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                        type="button" role="tab">Cơ bản</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab">Liên hệ</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button"
                        role="tab">Mạng xã hội</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button"
                        role="tab">SEO</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="script-tab" data-bs-toggle="tab" data-bs-target="#script" type="button"
                        role="tab">Scripts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image" type="button"
                        role="tab">Ảnh</button>
                </li>
            </ul>
            <div class="tab-content" id="configTabsContent">
                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                    <div class="">
                        <div class="card-header">
                            <h5>Thông tin cơ bản</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6"><label>Tên site</label><input name="site_name" class="form-control"
                                    value="{{ old('site_name', $config->site_name) }}"></div>
                            <div class="col-md-6"><label>Khẩu hiệu</label><input name="site_slogan" class="form-control"
                                    value="{{ old('site_slogan', $config->site_slogan) }}"></div>
                            <div class="col-md-6"><label>Key</label><input name="key" class="form-control"
                                    value="{{ old('key', $config->key) }}"></div>
                            <div class="col-md-6"><label>Ngôn ngữ</label><input name="language" class="form-control"
                                    value="{{ old('language', $config->language) }}" readonly></div>
                            <div class="col-md-12"><label>Múi giờ</label><input name="timezone" class="form-control"
                                    value="{{ old('timezone', $config->timezone) }}" readonly></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel">
                    <div class="">
                        <div class="card-header">
                            <h5>Liên hệ</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6"><label>Email</label><input name="email" class="form-control"
                                    value="{{ old('email', $config->email) }}"></div>
                            <div class="col-md-6"><label>Hotline</label><input name="hotline" class="form-control"
                                    value="{{ old('hotline', $config->hotline) }}"></div>
                            <div class="col-md-6"><label>SĐT</label><input name="phone" class="form-control"
                                    value="{{ old('phone', $config->phone) }}"></div>
                            <div class="col-md-6"><label>Zalo</label><input name="zalo_number" class="form-control"
                                    value="{{ old('zalo_number', $config->zalo_number) }}"></div>
                            <div class="col-md-12"><label>Địa chỉ</label><input name="address" class="form-control"
                                    value="{{ old('address', $config->address) }}"></div>
                            <div class="col-md-12"><label>Google Map</label>
                                <textarea name="google_map_embed" class="form-control">{{ old('google_map_embed', $config->google_map_embed) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="social" role="tabpanel">
                    <div class="">
                        <div class="card-header">
                            <h5>Mạng xã hội</h5>
                        </div>
                        <div class="card-body row g-3">
                            @foreach (['facebook', 'zalo', 'youtube', 'tiktok', 'instagram', 'linkedin', 'twitter'] as $platform)
                                <div class="col-md-6">
                                    <label>{{ ucfirst($platform) }} URL</label>
                                    <input name="{{ $platform }}_url" class="form-control"
                                        value="{{ old($platform . '_url', $config->{$platform . '_url'}) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="seo" role="tabpanel">
                    <div class="">
                        <div class="card-header">
                            <h5>SEO</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6"><label>Meta Title</label><input name="meta_title" class="form-control"
                                    value="{{ old('meta_title', $config->meta_title) }}"></div>
                            <div class="col-md-6"><label>Meta Keywords</label><input name="meta_keywords"
                                    class="form-control" value="{{ old('meta_keywords', $config->meta_keywords) }}">
                            </div>
                            <div class="col-md-12"><label>Meta Description</label>
                                <textarea name="meta_description" class="form-control">{{ old('meta_description', $config->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="script" role="tabpanel">
                    <div class="">
                        <div class="card-header">
                            <h5>Scripts</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-12"><label>Script Header</label>
                                <textarea name="script_header" class="form-control">{{ old('script_header', $config->script_header) }}</textarea>
                            </div>
                            <div class="col-md-12"><label>Script Footer</label>
                                <textarea name="script_footer" class="form-control">{{ old('script_footer', $config->script_footer) }}</textarea>
                            </div>
                            <div class="col-md-6"><label>Google Analytics ID</label><input name="google_analytics_id"
                                    class="form-control"
                                    value="{{ old('google_analytics_id', $config->google_analytics_id) }}">
                            </div>
                            <div class="col-md-6"><label>Facebook Pixel ID</label><input name="facebook_pixel_id"
                                    class="form-control"
                                    value="{{ old('facebook_pixel_id', $config->facebook_pixel_id) }}">
                            </div>
                            <div class="col-md-12"><label>Chat Widget Script</label>
                                <textarea name="chat_widget_script" class="form-control">{{ old('chat_widget_script', $config->chat_widget_script) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="image" role="tabpanel">

                    <div class="">
                        <div class="card-header">
                            <h5>Ảnh</h5>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-lg-2">
                                <div class="">
                                    <label for="logo" class="form-label">Ảnh đại diện</label>

                                    <label class="image-upload-wrapper" for="logo">
                                        @if (!empty($config->logo))
                                            <img id="preview-image" src="{{ asset($config->logo) }}" alt="Preview">
                                        @else
                                            <img id="preview-image" src="#" alt="Preview"
                                                style="display: none;">
                                            <span class="plus-icon" id="plus-icon">+</span>
                                        @endif
                                    </label>

                                    <input type="file" name="logo" id="logo" accept="image/*">
                                </div>
                            </div>



                            @foreach (['16', '32', '144', '192', '114', '120', '152', '180', '57', '60', '72', '76'] as $size)
                                <div class="col-md-2">
                                    <label>Favicon {{ $size }}x{{ $size }}</label>
                                    @php
                                        $faviconField = 'favicon_' . $size;
                                        $hasImage = $config->$faviconField;
                                    @endphp

                                    <label class="image-preview-wrapper clickable {{ $hasImage ? 'has-image' : '' }}">
                                        @if ($hasImage)
                                            <img src="{{ asset($config->$faviconField) }}" class="image-preview"
                                                data-role="preview">
                                        @else
                                            <div class="image-placeholder" data-role="placeholder">+</div>
                                        @endif
                                        <input type="file" name="{{ $faviconField }}"
                                            class="form-control crop-input hidden-input" data-size="{{ $size }}">
                                    </label>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary">Cập nhật</button>
                </div>
            </div>


        </form>
    </div>

    <style>
        .image-preview-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f8f8;
            cursor: pointer;
            transition: border 0.2s ease;
        }

        .image-preview-wrapper:hover {
            border-color: #666;
        }

        .image-preview-wrapper.has-image {
            border: none;
            background-color: transparent;
        }

        .image-preview {
            border: 2px dashed #ccc;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-placeholder {
            font-size: 2rem;
            color: #aaa;
            font-weight: bold;
            pointer-events: none;
        }

        .hidden-input {
            display: none;
        }

        .image-preview-wrapper {
            position: relative;
            width: 126px;
            height: 126px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f8f8;
            cursor: pointer;
            transition: border 0.2s ease;
        }

        .image-preview-wrapper:hover {
            border-color: #666;
        }

        .image-preview-wrapper.has-image {
            border: none;
            background-color: transparent;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-placeholder {
            font-size: 2rem;
            color: #aaa;
            font-weight: bold;
            pointer-events: none;
        }

        .image-upload-wrapper {
            width: 120px;
            height: 120px;
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



        #imageToCrop {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .modal-xl {
            max-width: 90vw;
        }
    </style>

    <!-- Modal crop ảnh -->
    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cắt ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="cropper-container-wrapper">
                        <img id="imageToCrop" src="" alt="Ảnh cần cắt" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button class="btn btn-primary" id="cropAndSave">Cắt và dùng ảnh</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let cropper;
        const input = document.getElementById('logo');
        const preview = document.getElementById('preview-image');
        const plusIcon = document.getElementById('plus-icon');

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (plusIcon) plusIcon.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
        let currentInput = null;
        let targetSize = null;
        // Khi chọn ảnh logo, hiển thị preview ngay
        document.querySelectorAll('.crop-input').forEach(input => {
            input.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];
                    const reader = new FileReader();
                    currentInput = e.target;

                    targetSize = currentInput.getAttribute('data-size');

                    reader.onload = function(event) {
                        const img = document.getElementById('imageToCrop');
                        img.src = event.target.result;

                        // Gắn sự kiện khi ảnh đã load xong
                        img.onload = function() {
                            const modal = new bootstrap.Modal(document.getElementById(
                                'cropImageModal'));
                            modal.show();

                            if (cropper) cropper.destroy();
                            cropper = new Cropper(img, {
                                aspectRatio: 1,
                                viewMode: 1,
                                responsive: true,
                                background: false,
                                autoCropArea: 1,
                            });
                        };
                    };

                    reader.readAsDataURL(file);
                }
            });
        });

        document.getElementById('cropAndSave').addEventListener('click', function() {
            if (cropper && currentInput) {
                let width = 100;
                let height = 100;

                if (targetSize && targetSize !== 'logo') {
                    width = parseInt(targetSize);
                    height = parseInt(targetSize);
                }

                const canvas = cropper.getCroppedCanvas({
                    width,
                    height
                });

                canvas.toBlob(function(blob) {
                    const file = new File([blob], "cropped_" + (targetSize || 'image') + ".png", {
                        type: "image/png"
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentInput.files = dataTransfer.files;

                    // 👉 Tạo URL preview ảnh vừa cắt
                    const imageUrl = URL.createObjectURL(blob);

                    // 👉 Tìm thẻ preview gần input nhất
                    const wrapper = currentInput.closest('.image-preview-wrapper');
                    if (wrapper) {
                        wrapper.classList.add('has-image');
                        // Nếu có ảnh cũ hoặc placeholder, xóa nó
                        wrapper.querySelectorAll('img, .image-placeholder').forEach(el => el.remove());

                        // Thêm ảnh mới vào để xem trước
                        const previewImg = document.createElement('img');
                        previewImg.src = imageUrl;
                        previewImg.classList.add('image-preview');
                        wrapper.appendChild(previewImg);
                    }

                    bootstrap.Modal.getInstance(document.getElementById('cropImageModal')).hide();
                });

            }
        });
    </script>
@endsection
