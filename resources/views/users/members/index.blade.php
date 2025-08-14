@extends('users.index')
@section('content')
    <div class="banner-service d-none d-sm-flex align-items-center ">
        <div class="content-service w-100">
            <span>
                <a href="#" class="text-decoration-none text-dark  fw-bold">Trang Chủ</a>
            </span>
            <span><i class="bi bi-chevron-right fs-5 "></i></span>
            <span>
                <a href="#" class="text-decoration-none  fw-bold service-banner-title">Đồng sáng
                    lập & Thành viên</a>
            </span>
            <p class="fw-bold mt-2 title">Đồng sáng lập & Thành viên</p>
            <h4 class="service-banner-title w-100">"Chúng tôi ở đây mang đến môi trường lý tưởng”</h4>
        </div>
        <div class="w-100 h-100">
            <img src="{{ asset('/users/images/header-member.png') }}" class="header-banner-service w-100">
        </div>
    </div>
    <div class="container d-block d-sm-none">
        <div class="content-service-banner mt-3 mx-4">
            <span>
                <a href="#" class="text-decoration-none text-dark  fw-bold">Trang Chủ</a>
            </span>
            <span><i class="bi bi-chevron-right fs-5 "></i></span>
            <span>
                <a href="#" class="text-decoration-none  fw-bold service-banner-title">Đồng sáng
                    lập & Thành viên</a>
            </span>
            <h2 class="fw-bold mt-2  text-center text-blue">Đồng sáng
                lập & Thành viên</h2>
            <h4 class=" ">"Chúng tôi ở đây mang đến môi trường lý tưởng”</h4>
        </div>
    </div>


    <section>
        <div class="text-member p-5 d-flex justify-content-center align-items-center">
            <div class="container  text-center">
                <h4 class="fs-2 vision-banner-title  fw-bold">Cùng gặp gỡ những người đứng sau Funhome</h4>

                <hr class="about-divider my-3 mx-auto">

                <p class="   fs-4">Những người trẻ mang trong mình khát vọng giúp sinh viên và người đi làm tìm được chốn ở
                    tử tế, giá hợp lý và trải nghiệm sống trọn vẹn hơn mỗi ngày.</p>
            </div>
        </div>
    </section>


    <section class="co-fouder-pc">
        <div class="container py-5">
            <div class="row">

                <div class="col-lg-4 col-md-4 col-sm-12 ">
                    <div class="co-fouder">
                        <h4 class="vision-banner-title">Nguyễn Văn A</h4>
                        <h5>Co-Fouder & Member</h5>
                        <hr class="w-25 about-divider ">
                        <p class="co-fouder-text">
                            Xuất phát từ trải nghiệm thực tế khi đi thuê trọ, A đồng sáng lập Fun Home với mong muốn giúp
                            sinh
                            viên và người đi làm dễ dàng tìm được phòng trọ sạch sẽ, giá rẻ và minh bạch. Anh phụ trách kết
                            nối
                            với chủ trọ uy tín và vận hành hệ thống nền tảng.
                        </p>
                        <span><i class="bi bi-envelope-check"></i></span>
                        <span>NguyenvanA@example.com</span>
                        <span>
                            <div class="vr"></div>
                        </span>
                        <span>LinkedIn</span>
                        <div class="w-100 py-3">
                            <img src="{{ asset('users/images/img-co-fouder.png') }}" alt="Co-Fouder"
                                class="img-co-fouder  ">
                        </div>
                        <h4 class="member-banner-title">Từ phòng trọ đến tổ ấm</h4>
                        <hr class="w-25 about-divider ">
                        <p class="co-fouder-text">
                            Là Co-Founder Fun Home, tôi từng sống trong những căn phòng chật chội, thiếu ánh sáng. Trải
                            nghiệm
                            đó thôi thúc tôi tạo ra Fun Home – nhà trọ giá rẻ nhưng chất lượng, đầy đủ tiện nghi, xanh mát
                            và ấm
                            cúng, để ai cũng có một chốn về tử tế.
                        </p>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 ">
                    <!-- Card 1 -->
                    <div class="mb-4">
                        <div class="custom-card">
                            <img src="{{ asset('users/images/project-member-1.png') }}" class="card-img-top" alt="Căn hộ">
                            <div class="custom-card-overlay">
                                <div>
                                    <small class="text-white-50">[23 Dự án]</small>
                                    <h5 class="card-title text-white fw-bold mt-1">Căn hộ</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                    <span class="text-white"><i class="bi bi-play-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="custom-card-2">
                        <img src="{{ asset('users/images/project-member-2.png') }}" class="card-img-top-2" alt="Studio">
                        <div class="custom-card-overlay">
                            <div>
                                <small class="text-white-50">[7 Dự án]</small>
                                <h5 class="card-title text-white fw-bold mt-1">Studio</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                <span class="text-white"><i class="bi bi-play-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <!-- Card 3 -->
                    <div class="mb-4">
                        <div class="custom-card-3">
                            <img src="{{ asset('users/images/project-member-3.png') }}" class="card-img-top-3"
                                alt="Văn Phòng">
                            <div class="custom-card-overlay">
                                <div>
                                    <small class="text-white-50">[17 Dự án]</small>
                                    <h5 class="card-title text-white fw-bold mt-1">Văn Phòng</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                    <span class="text-white"><i class="bi bi-play-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="custom-card-4">
                        <img src="{{ asset('users/images/project-member-4.png') }}" class="card-img-top-4" alt="Cửa hàng">
                        <div class="custom-card-overlay">
                            <div>
                                <small class="text-white-50">[17 Dự án]</small>
                                <h5 class="card-title text-white fw-bold mt-1">Cửa hàng</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                <span class="text-white"><i class="bi bi-play-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="co-fouder-mobile">
        <div class="container">
            <div class="co-fouder">
                <h4 class="vision-banner-title">Nguyễn Văn A</h4>
                <h5>Co-Fouder & Member</h5>
                <hr class="w-25 about-divider ">
                <p class="co-fouder-text">
                    Xuất phát từ trải nghiệm thực tế khi đi thuê trọ, A đồng sáng lập Fun Home với mong muốn giúp
                    sinh
                    viên và người đi làm dễ dàng tìm được phòng trọ sạch sẽ, giá rẻ và minh bạch. Anh phụ trách kết
                    nối
                    với chủ trọ uy tín và vận hành hệ thống nền tảng.
                </p>
                <span><i class="bi bi-envelope-check"></i></span>
                <span>NguyenvanA@example.com</span>
                <span>
                    <div class="vr"></div>
                </span>
                <span>LinkedIn</span>
                <div class="w-100 py-3">
                    <img src="{{ asset('users/images/img-co-fouder.png') }}" alt="Co-Fouder" class="img-co-fouder  ">
                </div>
                <h4 class="member-banner-title">Từ phòng trọ đến tổ ấm</h4>
                <hr class="w-25 about-divider ">
                <p class="co-fouder-text">
                    Là Co-Founder Fun Home, tôi từng sống trong những căn phòng chật chội, thiếu ánh sáng. Trải
                    nghiệm
                    đó thôi thúc tôi tạo ra Fun Home – nhà trọ giá rẻ nhưng chất lượng, đầy đủ tiện nghi, xanh mát
                    và ấm
                    cúng, để ai cũng có một chốn về tử tế.
                </p>
            </div>
            <div class="swiper mySwiper-member py-3">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="custom-card">
                            <img src="{{ asset('users/images/project-member-1.png') }}" class="card-img-top"
                                alt="Căn hộ">
                            <div class="custom-card-overlay">
                                <div>
                                    <small class="text-white-50">[23 Dự án]</small>
                                    <h5 class="card-title text-white fw-bold mt-1">Căn hộ</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                    <span class="text-white"><i class="bi bi-play-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="custom-card-2">
                            <img src="{{ asset('users/images/project-member-2.png') }}" class="card-img-top-2"
                                alt="Studio">
                            <div class="custom-card-overlay">
                                <div>
                                    <small class="text-white-50">[7 Dự án]</small>
                                    <h5 class="card-title text-white fw-bold mt-1">Studio</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                    <span class="text-white"><i class="bi bi-play-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="custom-card-3">
                            <img src="{{ asset('users/images/project-member-3.png') }}" class="card-img-top-3"
                                alt="Văn Phòng">
                            <div class="custom-card-overlay">
                                <div>
                                    <small class="text-white-50">[17 Dự án]</small>
                                    <h5 class="card-title text-white fw-bold mt-1">Văn Phòng</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                    <span class="text-white"><i class="bi bi-play-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="custom-card-4">
                            <img src="{{ asset('users/images/project-member-4.png') }}" class="card-img-top-4"
                                alt="Cửa hàng">
                            <div class="custom-card-overlay">
                                <div>
                                    <small class="text-white-50">[17 Dự án]</small>
                                    <h5 class="card-title text-white fw-bold mt-1">Cửa hàng</h5>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-white text-decoration-none">Xem thêm</a>
                                    <span class="text-white"><i class="bi bi-play-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>



    <section>
        <div class="container">
            <h1 class="title-member">Member</h1>
            <p class="slogan-member text-muted text-center mt-2">“Về nhà dễ dàng hơn với Fun Home.”</p>
            <div class="swiper swiper-member mySwiper-member pt-4">
                <div class="swiper-wrapper">
                    @foreach ($members as $member)
                        <div class="swiper-slide">
                            <div class="member-card ">
                                <div class="member-img-wrap ">
                                    <img src="{{ asset($member->image ?? 'users/images/img-member.png') }}"
                                        alt="{{ $member->name ?? '' }}" class="member-img">
                                </div>
                                <div class="icon-member">
                                    @if ($member->instagram)
                                        <a href="{{ $member->instagram }}" class="text-secondary "><i
                                                class="bi bi-instagram"></i></a>
                                    @endif
                                    @if ($member->facebook)
                                        <a href="{{ $member->facebook }}" class="text-secondary "><i
                                                class="bi bi-facebook"></i></a>
                                    @endif
                                    @if ($member->google)
                                        <a href="{{ $member->google }}" class="text-secondary "><i
                                                class="bi bi-google"></i></a>
                                    @endif
                                </div>
                                <div class="member-info-box text-center rounded-3">
                                    <a href="#"
                                        class="member-name fw-bold text-decoration-none">{{ $member->name ?? '' }}</a>
                                    <div class="d-flex justify-content-center">
                                        <hr class="w-25 about-divider ">
                                    </div>
                                    <div class="member-role text-secondary mb-2">"{{ $member->description ?? '' }}"</div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>



        </div>
    </section>


    <section>
        <div class="text-member d-flex justify-content-center align-items-center py-5">
            <div class="container">
                <div class="text-center">
                    <h4 class="fs-2 mt-3 vision-banner-title  fw-bold">“Một sản phẩm tốt là sản phẩm giúp người dùng giải
                        quyết
                        đúng
                        vấn đề, đúng lúc”</h4>
                    <h5 class="fs-4 vision-banner-title  "> Fun Home</h5>
                    <p class="   fs-4">"Phòng trọ tử tế, giá cả yêu thương."</p>
                    <hr class="about-divider mx-auto ">
                </div>

                <div class=" text-start">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="product-review-member">
                                <h4 class="product-review-member-title  w-75">Khách hàng của chúng tôi đang nói gì với
                                    chúng tôi? </h4>
                                <p class="mt-3 product-review-member-text">"Một khu trọ kiểu mẫu!"</p>
                                <div class="row ">
                                    <div class="col-6 info-block">
                                        <div class="info-title">10m+</div>
                                        <div class="info-subtitle">Những Người Hạnh Phúc</div>
                                    </div>
                                    <div class="col-6 info-block">
                                        <div class="info-title">4.88</div>
                                        <div class="info-subtitle">Đánh giá chung</div>
                                        <div class="rating-stars mt-1">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-5">
                            <div class="swiper mySwiper-member-text">
                                <div class="swiper-wrapper">
                                    @foreach ($feedbacks as $feedback)
                                        <div class="swiper-slide">
                                            <div class="member-card p-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($feedback->image ?? 'users/images/circle-avatar-member.png') }}"
                                                        alt="Nguyễn Văn B" class="avatar-member me-3">
                                                    <div>
                                                        <h6 class="fw-bold mb-1">{{ $feedback->name ?? '' }}</h6>
                                                       
                                                    </div>
                                                    <img src="{{ asset('users/images/quote-icon-member.png') }}"
                                                        alt="Quote Icon" class="ms-auto quote-icon-member">
                                                </div>
                                                <p class="mt-4 fs-5 text-quote">"{{ $feedback->message ?? '' }}"</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- Slide 1 -->


                                   

                                </div>

                                <!-- Điều hướng -->
                                <div class="testimonial-nav mt-3 text-center">
                                    <button class="nav-btn-member-prev btn-nav-member" aria-label="Previous">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button class="nav-btn-member-next btn-nav-member" aria-label="Next">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>




        </div>
    </section>
@endsection
