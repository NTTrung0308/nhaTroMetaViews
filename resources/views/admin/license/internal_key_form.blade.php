@extends('admin.index')

@section('contentadmin')
   

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nhập key nội bộ để tiếp tục</h5>

                    </div>
                    <form action="{{ route('internal.key.verify') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="internal_key" class="form-label">Key nội bộ</label>
                            <input type="password" name="internal_key" id="internal_key" class="form-control">
                            @error('internal_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
