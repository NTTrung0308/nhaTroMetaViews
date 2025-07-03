@extends('admin.index')
@section('contentadmin')
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ isset($faq) ? 'Sửa Câu hỏi thường gặp' : 'Thêm Câu hỏi thường gặp' }}</h5>

                    </div>
                    <div class="col-12">
                        <form action="{{ isset($faq) ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($faq))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label>Câu hỏi</label>
                                <input type="text" name="question" class="form-control"
                                    value="{{ old('question', $faq->question ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Trả lời</label>
                                <textarea name="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Trạng thái</label>
                                <select name="active" class="form-select">
                                    <option value="1" {{ old('active', $faq->active ?? 1) == 1 ? 'selected' : '' }}>
                                        Hiển thị</option>
                                    <option value="0" {{ old('active', $faq->active ?? 1) == 0 ? 'selected' : '' }}>Ẩn
                                    </option>
                                </select>
                            </div>

                           <div class="text-end">
                             <button class="btn btn-success">{{ isset($faq) ? 'Cập nhật' : 'Thêm mới' }}</button>
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Quay lại</a>
                           </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
@endsection
