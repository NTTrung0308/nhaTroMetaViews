{{-- <div class="mb-3">
    <label for="image" class="form-label">Ảnh</label>
    @if (!empty($member->image))
        <div class="mb-2">
            <img src="{{ asset($member->image) }}" alt="" style="max-width: 150px;">
        </div>
    @endif
    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> --}}

<div class="col-lg-12 col-sm-12 col-12 d-flex justify-content-center">
    <span>
        <div class="d-flex flex-column mb-1"><span class="mb-1 false">Ảnh
                đại
                diện <!----></span>
           <div class="position-relative image-container-user mb-2">
    <div style="width: 100px; height: 100px; position: relative; overflow: hidden;" class="mb-2 thumbnail">
     <img id="preview-image" src="{{ optional($member)->image ? asset($member->image) : '' }}" alt="Xem trước ảnh"
            style="width: 100%; height: 100%; object-fit: cover; {{ optional($member)->image ? '' : 'display: none;' }}">
        <svg id="default-icon-avt" xmlns="http://www.w3.org/2000/svg" width="25px" height="25px"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-image"
            style="{{ optional($member)->image ? 'display: none;' : '' }} position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <circle cx="8.5" cy="8.5" r="1.5"></circle>
            <polyline points="21 15 16 10 5 21"></polyline>
        </svg>
    </div>
    <input id="image" type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="d-none">
    <div class="control-btns">
        <label for="image">
            <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-edit-2">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg>
        </label>
    </div>
</div>

            <small class="text-danger"></small><!---->
        </div>
    </span>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Tên</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
        value="{{ old('name', $member->name ?? '') }}">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Mô tả</label>
    <input type="text" class="form-control" name="description"
        value="{{ old('description', $member->description ?? '') }}">
</div>

<div class="mb-3">
    <label for="facebook" class="form-label">Facebook</label>
    <input type="url" class="form-control" name="facebook" value="{{ old('facebook', $member->facebook ?? '') }}">
</div>

<div class="mb-3">
    <label for="google" class="form-label">Google</label>
    <input type="url" class="form-control" name="google" value="{{ old('google', $member->google ?? '') }}">
</div>

<div class="mb-3">
    <label for="instagram" class="form-label">Instagram</label>
    <input type="url" class="form-control" name="instagram"
        value="{{ old('instagram', $member->instagram ?? '') }}">
</div>
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewImage = document.getElementById('preview-image');
    const defaultIcon = document.getElementById('default-icon-avt');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            previewImage.src = event.target.result;
            previewImage.style.display = 'block';
            defaultIcon.style.display = 'none';
        }
        reader.readAsDataURL(file);
    } else {
        previewImage.src = '';
        previewImage.style.display = 'none';
        defaultIcon.style.display = 'block';
    }
});
</script>
