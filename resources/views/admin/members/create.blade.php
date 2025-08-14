@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Thành viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Thêm Thành viên</li>
            </ol>
        </nav>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới Thành viên</h5>

                    </div>
                    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.members.form', ['member' => null])
                      <div class="text-end pt-4">
                          <button type="submit" class="btn btn-primary">Thêm Thành viên</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
