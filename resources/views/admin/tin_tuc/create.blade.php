@extends('admin.index')
@section('contentadmin')
    


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới Tin tức</h5>

                    </div>
                    <form action="{{ route('tin_tuc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.tin_tuc._form', ['tinTuc' => null])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
