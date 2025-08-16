@extends('admin.index')

@section('contentadmin')
<div class="container mt-5">
    <h2>Nhập key nội bộ để tiếp tục</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('internal_key') }}
        </div>
    @endif

    <form action="{{ route('internal.key.verify') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="internal_key" class="form-label">Key nội bộ</label>
            <input type="password" name="internal_key" id="internal_key" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Xác nhận</button>
    </form>
</div>
@endsection
