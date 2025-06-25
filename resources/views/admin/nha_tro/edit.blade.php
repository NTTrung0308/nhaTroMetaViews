@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Nhà trọ</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Sửa Nhà trọ</li>
            </ol>
        </nav>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Sửa mới Nhà trọ</h5>

                    </div>
                   <form action="{{ route('nha_tro.update', $nhaTro) }}" method="POST">
                        @csrf @method('PUT')
                        @include('admin.nha_tro.form', ['nhaTro' => $nhaTro])
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                            <a href="{{ route('nha_tro.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
