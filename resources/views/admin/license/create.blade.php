@extends('admin.index')

@section('contentadmin')
   
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm License Key để tiếp tục</h5>

                    </div>

                    <form action="{{ route('admin.license.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="max_rooms" class="form-label">Số lượng phòng tối đa</label>
                            <input type="number" name="max_rooms" id="max_rooms" class="form-control" >
                              @error('max_rooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       <div class="text-end">
                         <button type="submit" class="btn btn-primary">Tạo Key</button>
                       </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    
@endsection
