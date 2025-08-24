@extends('admin.index')
@section('contentadmin')
    

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Cập nhật Thành viên</h5>

                    </div>
                    <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        @include('admin.members.form', ['member' => $member])
                      <div class="text-end pt-4">
                          <button type="submit" class="btn btn-primary">Cập nhật Thành viên</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
