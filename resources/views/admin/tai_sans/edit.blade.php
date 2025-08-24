@extends('admin.index')
@section('contentadmin')
   


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Sửa Tài sản</h5>

                    </div>
    <form method="POST" action="{{ route('tai-sans.update', $taiSan->id) }}">
        @csrf
        @method('PUT')
        @include('admin.tai_sans.form')
    </form>
  </div>
            </div>
        </div>
    </div>
@endsection