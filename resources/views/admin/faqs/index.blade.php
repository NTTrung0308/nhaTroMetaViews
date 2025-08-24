@extends('admin.index')
@section('contentadmin')
   




    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                  <h5 class="card-header">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">Câu hỏi thường gặp</li>

                        </ol>
                    </nav>
                </h5>
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Danh sách FAQ</h5>
                        @if (auth()->user()->hasPermissionTo('Thêm câu hỏi thường gặp'))
                            <a href="{{ route('admin.faqs.create') }}" class="btn btn-success rounded-pill">Thêm câu hỏi
                                thường gặp</a>
                        @endif

                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Câu hỏi</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($faqs as $faq)
                                    <tr>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ $faq->active ? 'Hiển thị' : 'Ẩn' }}</td>
                                        <td>
                                            @if (auth()->user()->hasPermissionTo('Sửa câu hỏi thường gặp'))
                                                <a href="{{ route('admin.faqs.edit', $faq) }}"
                                                    class="btn btn-sm btn-warning"><i class="icon-base bx bx-edit-alt"></i></a>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xóa câu hỏi thường gặp'))
                                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="icon-base bx bx-trash"></i></button>
                                                </form>
                                            @endif
                                            @if (auth()->user()->hasPermissionTo('Xem câu hỏi thường gặp'))
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#faqModal" data-question="{{ $faq->question }}"
                                                    data-answer="{{ $faq->answer }}">
                                                    <i class="icon-base bx bx-show"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có dữ liệu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalLabel">Chi tiết FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div>
                        Câu hỏi:
                        <h6 id="faqQuestion"></h6>
                    </div>
                    <div>
                        Câu trả lời:
                        <p id="faqAnswer"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        const faqModal = document.getElementById('faqModal');
        faqModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const question = button.getAttribute('data-question');
            const answer = button.getAttribute('data-answer');

            document.getElementById('faqQuestion').innerText = question;
            document.getElementById('faqAnswer').innerText = answer;
        });
    </script>
@endsection
