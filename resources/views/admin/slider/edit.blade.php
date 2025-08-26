{{-- File: resources/views/admin/slider/edit.blade.php --}}

@extends('admin.index')

@section('contentadmin')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Sửa Slider</h5>
                    </div>

                    @include('admin.slider.form')

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Đoạn script này sẽ được đẩy vào @stack('scripts') trong layout --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const croppedImageInput = document.getElementById('croppedImage');

    if (imageInput && previewImage && croppedImageInput) {
        let cropper;

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
                previewImage.src = event.target.result;
                previewImage.style.display = 'block';

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(previewImage, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    autoCropArea: 1,
                    
                    cropend() {
                        const canvas = cropper.getCroppedCanvas({
                            width: 1280,
                            height: 720,
                        });
                        croppedImageInput.value = canvas.toDataURL('image/jpeg', 0.85);
                    }
                });
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush