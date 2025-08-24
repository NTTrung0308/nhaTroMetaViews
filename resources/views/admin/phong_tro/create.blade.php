@extends('admin.index')
@section('contentadmin')

    

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới Phòng trọ</h5>

                    </div>
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.phong_tro.form', ['room' => null])
                      <div class="text-end pt-4">
                          <button type="submit" class="btn btn-primary">Thêm phòng</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
