@extends('users.index')
@section('content')
    <div class="error-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="error-content">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h1 class="error-title">404</h1>
                        <p class="error-text">Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.</p>

                        <div class="d-flex justify-content-center mb-4">
                            <div class="text-start">
                                <p><i class="fas fa-home property-icon"></i> Có thể bạn muốn xem <a href="#"
                                        class="text-decoration-none">các bất động sản mới nhất</a></p>
                                <p><i class="fas fa-map-marker-alt property-icon"></i> Hoặc tìm kiếm theo <a href="#"
                                        class="text-decoration-none">khu vực</a></p>
                                <p><i class="fas fa-phone-alt property-icon"></i> Liên hệ hỗ trợ: <a href="tel:0123456789"
                                        class="text-decoration-none">0123 456 789</a></p>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="index.html" class="btn btn-primary btn-lg px-4 gap-3">
                                <i class="fas fa-home me-2"></i> Về trang chủ
                            </a>
                            <a href="contact.html" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-headset me-2"></i> Liên hệ hỗ trợ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
