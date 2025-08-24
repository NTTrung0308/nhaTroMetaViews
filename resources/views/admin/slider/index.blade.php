@extends('admin.index')
@section('contentadmin')
   



    <div class="row">

        <div class="col-lg-12">

            <div class="card">
               
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung Slider</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm slider'))
                            <a href="{{ route('sliders.create') }}" class="btn btn-success rounded-pill">Thêm Slider</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Phụ đề</th>
                                    <th>Vị trí</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $index => $slider)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($slider->image)
                                                <img src="{{ asset($slider->image) }}" width="100" height="60"
                                                    style="object-fit: cover;">
                                            @endif
                                        </td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->subtitle }}</td>
                                        <td>{{ $slider->position }}</td>
                                        <td>
                                            <span class="badge bg-{{ $slider->active ? 'success' : 'secondary' }}">
                                                {{ $slider->active ? 'Hiển thị' : 'Ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa slider'))
                                                <a href="{{ route('sliders.edit', $slider) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="icon-base bx bx-edit-alt"></i>
                                                </a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa slider'))
                                                <form action="{{ route('sliders.destroy', $slider) }}" method="POST"
                                                    class="d-inline-block"
                                                    onsubmit="return confirm('Bạn có chắc muốn xoá slider này không?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="icon-base bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Chưa có slider nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
