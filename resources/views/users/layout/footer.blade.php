<footer class="footer">
    <div class="container">
        <div class="row ">
            <div class="col-6">
                <a class="logo" href="#"><img class="img-logo" src="users/images/logo-FunHome.svg" alt=""></a>
            </div>

            <div class="col-6 ">
                <div class="icon-footer w-100 h-100 d-flex justify-content-end mx-auto align-items-center">
                    <i class="bi bi-facebook fs-4"></i>
                    <i class="bi bi-messenger fs-4 mx-2"></i>
                    <i class="bi bi-linkedin fs-4 mx-2"></i>
                    <i class="bi bi-telephone-fill fs-4"></i>
                </div>
            </div>
        </div>
        <hr class="text-light ">
        <div class="row gy-4 text-light footer-destop d-md-flex d-none">
            <div class="col-md-12 col-lg-3 col-sm-12">
                <h5 class="mb-4">Đặt lịch</h5>
                <form class="d-flex mb-2">
                    <input type="email" class="form-control me-2" placeholder="Nhập G-mail">
                    <button class="btn rounded-3 btn-light">Gửi</button>
                </form>
                <small>Đăng ký nhận bản tin của chúng tôi để nhận thông tin hàng tuần.</small>
            </div>
            <div class="col-md-6 col-lg-2 col-6">
                <div class="">
                    <p class="fw-bold fs-3">Địa Chỉ</p>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Hoàng Mai</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Cầu Giấy</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Xuân Thủy</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Tây Hồ</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Thanh Xuân</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Đống Đa</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-2 col-6">
                <p class="fw-bold fs-3">Hỗ Trợ</p>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">Chúng tôi</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Câu hỏi</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Tin Tức</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Dịch vụ</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Thành viên</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-2 col-6">
                <p class="fw-bold fs-3">Chính Sách</p>
                <ul class="list-unstyled">
                    {{-- <li><a href="{{ route('privacy-policy') }}" class="text-white text-decoration-none">Chính sách bảo
                            mật</a></li>
                    <li><a href="{{ route('Terms-of-Use') }}" class="text-white text-decoration-none">Điều khoản Sử
                            dụng</a></li>
                    <li><a href="{{ route('Questions-&-Feedback') }}" class="text-white text-decoration-none">Câu hỏi &
                            góp ý</a></li> --}}
                </ul>
            </div>
            <div class="col-md-6 col-6 col-lg-3 text-md-start">

                <div class="row g-3">
                    <div class="box">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-4 d-flex mt-2">
                                <i class="bi bi-google-play fs-3 mx-3"></i>

                            </div>
                            <div class="col-8 d-flex justify-content-center align-items-center flex-column">
                                <h6>tải ngay trên<br>
                                    Google Play</h6>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-4 d-flex mt-2">
                                <i class="bi bi-apple fs-3 mx-3"></i>

                            </div>
                            <div class="col-8 d-flex justify-content-center align-items-center flex-column">
                                <h6>Tải ngay trên <br>
                                    Apple Store</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-mobile d-md-none px-3 py-4">
            <h5 class="text-light mb-3">Đặt lịch</h5>
            <form class="d-flex mb-3">
                <input type="email" class="form-control me-2" placeholder="Nhập G-mail">
                <button class="btn btn-light">Gửi</button>
            </form>
            <small class="text-light">Đăng ký để nhận thông tin hàng tuần.</small>

            <div class="accordion mt-4" id="footerAccordion">
                <div class="accordion-item bg-transparent border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent text-white p-2" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseAddress">
                            📍 Địa chỉ
                        </button>
                    </h2>
                    <div id="collapseAddress" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
                        <div class="accordion-body text-white ps-3">
                            Hoàng Mai, Cầu Giấy, Xuân Thủy, Tây Hồ, Thanh Xuân, Đống Đa
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-transparent border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent text-white p-2" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseSupport">
                            ☎️ Hỗ trợ
                        </button>
                    </h2>
                    <div id="collapseSupport" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
                        <div class="accordion-body text-white ps-3">
                            Gọi 1900 1234<br>hoặc email hotro@funhome.vn
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-transparent border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent text-white p-2" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapsePolicy">
                            📄 Chính sách
                        </button>
                    </h2>
                    <div id="collapsePolicy" class="accordion-collapse collapse" data-bs-parent="#footerAccordion">
                        <div class="accordion-body text-white ps-3">
                            <ul class="list-unstyled small">
                                <li><a href="#" class="text-white text-decoration-none">Chính sách bảo mật</a>
                                </li>
                                <li><a href="#" class="text-white text-decoration-none">Điều khoản sử dụng</a>
                                </li>
                                <li><a href="#" class="text-white text-decoration-none">Câu hỏi & góp ý</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 ">
                {{-- <a href="#"><img class="img-dowmload w-75" src="/images/appstore.png" alt=""></a>
                <a href="#"><img class="img-dowmload w-75" src="/images/appstore.png" alt=""></a> --}}
                <div class="col-6">
                    <a href="#"><img class="img-dowmload w-100" src="/images/appstore.png" alt=""></a>
                </div>
                <div class="col-6">
                    <a href="#"><img class="img-dowmload w-100" src="/images/appstore.png" alt=""></a>
                </div>
            </div>
        </div>


        {{-- <div class="row d-sm-none">
            <div class="col-6">
                <a href="">
                    <img class="img-dowmload w-100" src="/images/appstore.png" alt="">
                </a>
            </div>

            <div class="col-6">
                <img class="img-dowmload w-100" src="/images/appstore.png" alt="">
            </div>
        </div> --}}
        <hr class="text-light ">
        <div class="copy">
            <div class=" d-flex justify-content-center align-items-center">
                <p class="text-light text-center">@copy right Tanh</p>
            </div>
        </div>
    </div>

</footer>
