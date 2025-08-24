@extends('admin.index')
@section('contentadmin')


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Sửa dịch vụ của chúng tôi</h5>

                    </div>

    <form action="{{ route('admin.service_about_home.update', $serviceAbout->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $serviceAbout->title) }}">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <input type="text" name="description" class="form-control" value="{{ old('description', $serviceAbout->description) }}">
        </div>

        <div class="mb-3">
            <label>Ảnh</label><br>
            <img 
                id="previewImage" 
                src="{{ $serviceAbout->image ? asset($serviceAbout->image) : '#' }}" 
                alt="Xem trước ảnh" 
                style="max-width: 200px; {{ $serviceAbout->image ? '' : 'display:none;' }} border: 1px solid #ddd; padding: 5px; border-radius: 5px;"
            >
            <input type="file" name="image" class="form-control mt-2" id="imageInput">
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" id="tyni" rows="5">{{ old('content', $serviceAbout->content) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="show_on_home" id="show_on_home" class="form-check-input" {{ $serviceAbout->show_on_home ? 'checked' : '' }}>
            <label for="show_on_home" class="form-check-label">Hiển thị ở trang chủ</label>
        </div>
    
       <div class="text-end">
         <button type="submit" class="btn btn-success">Cập nhật</button>
       </div>
    </form>
 </div>
            </div>
        </div>
    </div>
@endsection

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
    }
});
</script>
@endpush
