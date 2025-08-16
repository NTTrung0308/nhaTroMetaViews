@extends('admin.index')

@section('contentadmin')
<div class="container">
    <h1>Thêm License Key</h1>

    <form action="{{ route('admin.license.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="max_rooms" class="form-label">Số lượng phòng tối đa</label>
            <input type="number" name="max_rooms" id="max_rooms" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Key</button>
    </form>
</div>
@endsection
