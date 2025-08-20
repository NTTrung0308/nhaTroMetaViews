@extends('users.index')
@section('content')
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/dich-vu" class="text-decoration-none">Dịch vụ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dịch vụ chi tiết</li>
        </ol>
    </nav>

    <!-- Main content -->
    <main class="container my-4">
        <div class="row">
            <!-- Nội dung dịch vụ -->
            <article class="col-lg-8">
                <h2 class="h4">{{ $service->title ?? 'Dịch vụ tư vấn mua bán nhà đất' }}</h2>
                <div class="lead cointent-news">
                    {!! $service->content ??
                        'Chúng tôi cung cấp dịch vụ tư vấn mua bán bất động sản chuyên nghiệp, giúp khách hàng tìm được căn nhà, căn hộ hoặc mảnh đất phù hợp với nhu cầu và ngân sách.' !!}
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="col-lg-4">
                <div class="card shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title">Liên hệ tư vấn</h5>
                        {{-- Sử dụng novalidate để tắt validation mặc định của trình duyệt --}}
                        <form id="serviceContactForm" novalidate>
                            <div class="mb-3">
                                <label for="ten" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ten" name="ten"
                                    placeholder="Nhập họ tên">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="so_dien_thoai" class="form-label">Số điện thoại <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                    placeholder="Nhập số điện thoại">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Nhập email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label for="noi_dung" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="noi_dung" name="noi_dung" rows="3" placeholder="Nhập yêu cầu..."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <i class="fas fa-paper-plane me-2"></i> Gửi yêu cầu
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('serviceContactForm');
            // Lấy đúng ID từ HTML
            const nameInput = document.getElementById('ten');
            const phoneInput = document.getElementById('so_dien_thoai');
            const emailInput = document.getElementById('email');
            const messageInput = document.getElementById('noi_dung');
            const submitBtn = document.getElementById('submitBtn');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function showError(input, message) {
                const formControl = input.parentElement;
                const errorDiv = formControl.querySelector('.invalid-feedback');
                input.classList.add('is-invalid');
                errorDiv.textContent = message;
            }

            function clearError(input) {
                const formControl = input.parentElement;
                const errorDiv = formControl.querySelector('.invalid-feedback');
                input.classList.remove('is-invalid');
                errorDiv.textContent = '';
            }

            function clearAllErrors() {
                [nameInput, phoneInput, emailInput, messageInput].forEach(input => clearError(input));
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearAllErrors();
                let isValid = true;

                // Lấy giá trị và gán vào biến có tên tương ứng
                const ten = nameInput.value.trim();
                const so_dien_thoai = phoneInput.value.trim();
                const email = emailInput.value.trim();
                const noi_dung = messageInput.value.trim();

                // Validate phía client
                if (ten === "") {
                    showError(nameInput, "Vui lòng nhập họ tên.");
                    isValid = false;
                }
                if (so_dien_thoai === "") {
                    showError(phoneInput, "Vui lòng nhập số điện thoại.");
                    isValid = false;
                } else {
                    const phoneRegex = /^(0[0-9]{9})$/;
                    if (!phoneRegex.test(so_dien_thoai)) {
                        showError(phoneInput,
                            "Số điện thoại không hợp lệ (phải đủ 10 số, bắt đầu bằng 0).");
                        isValid = false;
                    }
                }
                if (email === "") {
                    showError(emailInput, "Vui lòng nhập email.");
                    isValid = false;
                } else {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        showError(emailInput, "Email không hợp lệ.");
                        isValid = false;
                    }
                }
                // SỬA LỖI Ở ĐÂY: Sử dụng biến 'noi_dung' để kiểm tra
                if (noi_dung === "") {
                    showError(messageInput, "Vui lòng nhập nội dung.");
                    isValid = false;
                }

                if (!isValid) {
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...`;

                fetch("{{ route('contact.users.storejquery') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json"
                        },
                        // Gửi đi các key khớp với controller
                        body: JSON.stringify({
                            ten: ten,
                            so_dien_thoai: so_dien_thoai,
                            email: email,
                            noi_dung: noi_dung
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 422) {
                                return response.json().then(errorData => {
                                    throw errorData;
                                });
                            }
                            throw new Error('Lỗi hệ thống, vui lòng thử lại sau.');
                        }
                        return response.json();
                    })
                    .then(res => {
                        if (res.success) {
                            toastr.success(res.message || "Gửi yêu cầu thành công!");
                            form.reset();
                        } else {
                            toastr.error(res.message || "Có lỗi xảy ra, vui lòng thử lại.");
                        }
                    })
                    .catch(error => {
                        if (error.errors) {
                            const serverErrors = error.errors;
                            for (const field in serverErrors) {
                                // Tên field trả về từ Laravel sẽ là 'ten', 'so_dien_thoai', ...
                                // Nó sẽ khớp với id của các thẻ input
                                const inputElement = document.getElementById(field);
                                if (inputElement) {
                                    showError(inputElement, serverErrors[field][0]);
                                }
                            }
                        } else {
                            toastr.error(error.message || "Lỗi không xác định. Vui lòng thử lại.");
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = `<i class="fas fa-paper-plane me-2"></i> Gửi yêu cầu`;
                    });
            });
        });
    </script>
@endsection

{{-- Quan trọng: Đảm bảo layout chính của bạn (ví dụ: users.index) có thẻ meta CSRF --}}
{{-- Thêm thẻ này vào trong <head> của file layout chính --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
