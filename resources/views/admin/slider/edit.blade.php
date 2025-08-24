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
