@extends('admin.index')
@section('contentadmin')

    <div class="pagetitle">
        <h1>Phòng trọ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Thêm Phòng trọ</li>
            </ol>
        </nav>
    </div>


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
