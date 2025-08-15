@extends('users.index')
@section('content')
    {{-- banner --}}
    <section class="">
        <div class="home-banner-top ">
            <div class="container w-100 h-100 mx-auto">
                <div class="row w-100 h-100 mx-auto">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="w-100 h-100 mx-auto d-flex flex-column justify-content-center text-banner">
                            <div class="d-flex align-items-center gap-2 mb-2 mt-3">
                                <p class="mb-0 title-banner ">ĐỪNG BỎ LỠ!</p>
                                <span class="banner-line flex-grow-1"></span>
                            </div>
                            <div class="banner-divider"></div>
                            <h1 class="w-75 mt-3 desc-banner">Tìm Ngôi Nhà Mơ Ước Của Bạn</h1>
                            <p class="w-75 mt-3 content-banner">FunHome là đại diện cho các bất động sản sang trọng đặc biệt
                                và bất động
                                sản
                                đơn
                                lẻ tại các quận
                                được
                                săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.</p>
                            <a href="/shop" class="btn btn-primary  mt-3 see-now">Xem Ngay</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="item_banner_left w-100 ">
                            <div class="hero-8">
                                <div class="hero-thumb8-1">
                                    <div class="thumb bg-mask">
                                        @php
                                            $firstImage = $sliders->first()->image ?? '/users/images/anh3.png';
                                        @endphp

                                        <img id="main-banner-img" decoding="async" src="{{ asset($firstImage) }}"
                                            alt="img" class="w-100 h-100 object-fit-cover rounded-4">
                                    </div>
                                </div>
                            </div>
                            <div class="rectangle_test p-3 position-relative">
                                <div class="swiper bannerThumbsSwiper" id="banner-thumbs">
                                    <div class="swiper-wrapper">
                                        @foreach ($sliders as $slider)
                                            <div class="swiper-slide">
                                                <div class="rectangle_test_item w-100 ">
                                                    <img decoding="async"
                                                        src="{{ asset($slider->image ?? '/users/images/anh3.png') }}"
                                                        alt="img"
                                                        class="w-100 h-100 object-fit-cover rounded-4 banner-thumb"
                                                        data-img="{{ asset($slider->image ?? '/users/images/anh3.png') }}">
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="swiper-button-next bannerThumbs-next"></div>
                                <div class="swiper-button-prev bannerThumbs-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="DichVu pt-5">
        <div class="container ">
            <div class="text-center">
                <p class="title_dichvu">Dịch vụ của chúng tôi</p>
                <p class="desc_dichvu">Chúng tôi cam kết tìm ra bất động sản hoàn hảo cho bạn</p>
            </div>
            <div class="dichvu_content">
                <div class="row g-4 d-none d-sm-flex">
                    @forelse ($serviceHomes as $serviceHome)
                        <div class="col-4">
                            <div class="w-100 h-100 text-center box_dichvu">
                                <div class="icon_dichvu">
                                    <img decoding="async"
                                        src="{{ asset($serviceHome->image ?? '/users/images/icon/icon1.svg') }}"
                                        alt="img" class="w-100 h-100 object-fit-cover">
                                </div>
                                <p class="desc_contentdv p-2">{{ $serviceHome->title ?? '' }}</p>
                                <p class=" mx-auto">
                                    {{ $serviceHome->description ??
                                        'Tư vấn pháp lý chuyên nghiệp và hỗ trợ trong suốt quá trình bất động
                                                                        sản.' }}
                                </p>
                            </div>
                        </div>

                    @empty
                        <div class="text-center">
                            <p>Dịch vụ của chúng tôi đang trong quá trình cập nhật</p>
                        </div>
                    @endforelse


                </div>
                <div class="swiper mySwiper2 d-flex d-sm-none">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="w-100 h-100 text-center box_dichvu">
                                <div class="icon_dichvu">
                                    <img decoding="async" src="images/icon/icon6.svg" alt="img"
                                        class="w-100 h-100 object-fit-cover">
                                </div>
                                <p class="desc_contentdv p-2">Định giá tài sản</p>
                                <p class=" mx-auto">Tư vấn pháp lý chuyên nghiệp và hỗ trợ trong suốt quá trình bất động
                                    sản.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="w-100 h-100 text-center box_dichvu">
                                <div class=" icon_dichvu">
                                    <img decoding="async" src="images/icon/icon6.svg" alt="img"
                                        class="w-100 h-100 object-fit-cover">
                                </div>
                                <p class="desc_contentdv p-2">Định giá tài sản</p>
                                <p class=" mx-auto">Tư vấn pháp lý chuyên nghiệp và hỗ trợ trong suốt quá trình bất động
                                    sản.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="w-100 h-100 text-center box_dichvu">
                                <div class=" icon_dichvu">
                                    <img decoding="async" src="images/icon/icon6.svg" alt="img"
                                        class="w-100 h-100 object-fit-cover">
                                </div>
                                <p class="desc_contentdv p-2">Định giá tài sản</p>
                                <p class=" mx-auto">Tư vấn pháp lý chuyên nghiệp và hỗ trợ trong suốt quá trình bất động
                                    sản.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="w-100 h-100 text-center box_dichvu">
                                <div class=" icon_dichvu">
                                    <img decoding="async" src="images/icon/icon6.svg" alt="img"
                                        class="w-100 h-100 object-fit-cover">
                                </div>
                                <p class="desc_contentdv p-2">Định giá tài sản</p>
                                <p class=" mx-auto">Tư vấn pháp lý chuyên nghiệp và hỗ trợ trong suốt quá trình bất động
                                    sản.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- doi tac --}}
    <section class="doitac">
        <div class="container">
            <div class="row ">
                <div class="col-lg-6 col-12 h-100">
                    <div class="h-100 text-center text-lg-start ">
                        <p class="fs-2 py-4 title_doitac">ĐỐI TÁC CHIẾN LƯỢC TRONG LĨNH VỰC CHO THUÊ BẤT ĐỘNG SẢN</p>
                        <p>
                            FunHome – Đối tác chiến lược của các chủ đầu tư hàng đầu Việt Nam trong lĩnh vực cho thuê căn hộ
                            và phòng trọ chất lượng cao, đồng hành kiến tạo những giá trị bền vững và tối ưu hiệu quả khai
                            thác
                            bất động sản. Chúng tôi hợp tác cùng các thương hiệu uy tín để phát triển và vận hành hệ thống
                            cho
                            thuê chuyên nghiệp, mang đến không gian sống hiện đại, tiện nghi cho khách hàng. Với tầm nhìn
                            dài hạn
                            và hiểu biết sâu sắc về thị trường, FunHome cam kết kết nối chủ đầu tư với những giải pháp khai
                            thác cho thuê hiệu quả, tư vấn chuyên sâu nhằm gia tăng giá trị tài sản và tối đa hóa lợi nhuận
                            dài
                            hạn.
                        </p>
                        <div class="w-100 h-100">
                            <img src="{{ asset('/users/images/image.png') }}" alt=""
                                class="w-100 h-100 object-fit-cover rounded-4">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 d-none d-lg-block p-5">
                    <div class="w-75 mx-auto ">
                        <img src="{{ asset('/users/images/image2.png') }}" alt=""
                            class="w-100 h-100 object-fit-cover rounded-4 ">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- can ho thong minh --}}
    <section class="can_ho_thong_minh ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <p class="title_canhothongminh">Căn hộ thông minh</p>
                    <p class="desc_canhothongminh">Nơi cuộc sống trở nên kỳ diệu</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <p class="content_canhothongminh"><span class="fw-bold content_funhome">Fun Home</span> – dịch vụ cho
                        thuê phòng trọ giá rẻ, tiện nghi
                        tại Hà Nội, phù hợp cho sinh viên và người đi
                        làm. Phòng sạch đẹp, đầy đủ nội thất, an ninh tốt, gần trường và trung tâm. Không chỉ là chỗ ở, Fun
                        Home mang đến không gian sống thân thiện, hiện đại và ấm áp như ở nhà.</p>

                    <p class="content_gioithieu"><span class="icon_canhothongminh"><a href=""><i
                                    class="bi bi-arrow-up-right-circle"></i></a></span>Giới thiệu về chúng tôi</p>
                </div>
            </div>
            <div class="banner_canhothongminh">
                <img src="{{ asset('users/images/image3.png') }}" alt="img" class="w-100 h-100 object-fit-cover">
            </div>
            <div class="row mt-5">
                <div class="col-6 col-md-4 order-1">
                    <div class="text-center box_canhothongminh h-100">
                        <p class="count_canhothongminh">250+</p>
                        <p class="desc_count_canhothongminh">Phòng trọ tiện nghi đã vận hành tại Hà Nội & TP.HCM</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 order-2">
                    <div class="text-center box_canhothongminh h-100">
                        <p class="count_canhothongminh">10.000+</p>
                        <p class="desc_count_canhothongminh">Số lượng sơ lược khách hàng đã tin tưởng và sử dụng dịch vụ
                            bên fun-home.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 order-3 ">
                    <div class="text-center box_canhothongminh h-100">
                        <p class="count_canhothongminh">1500+</p>
                        <p class="desc_count_canhothongminh">Số lượng sơ lược khách hàng đã tin tưởng và sử dụng dịch vụ
                            bên fun-home.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Giai thuong --}}
    <section class="giaithuong mt-5">
        <div class="container">
            <div class="text-center">
                <p class="title_giaithuong">Giải Thưởng</p>
                <p class="desc_giaithuong">Những Thành Tựu & Danh Hiệu Của Chúng Tôi</p>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-6 col-sm-4 col-md-3 d-flex justify-content-center mb-4">
                    <img src="{{ asset('users/images/medal-of-honor.png') }}" alt="Medal of Honor"
                        class="img-fluid award-img">
                </div>
                <div class="col-6 col-sm-4 col-md-3 d-flex justify-content-center mb-4">
                    <img src="{{ asset('users/images/award-shield.png') }}" alt="Award Shield"
                        class="img-fluid award-img">
                </div>
                <div class="col-6 col-sm-4 col-md-3 d-flex justify-content-center mb-4">
                    <img src="{{ asset('users/images/shield.png') }}" alt="Shield" class="img-fluid award-img">
                </div>
                <div class="col-6 col-sm-4 col-md-3 d-flex justify-content-center mb-4">
                    <img src="{{ asset('users/images/certificate.png') }}" alt="Certificate"
                        class="img-fluid award-img">
                </div>
            </div>
        </div>
    </section>


    {{-- du an tieu bieu --}}
    <section class="duantieubieu pt-5">
        <div class="container w-100 h-100">
            <div class="text-center">
                <p class="title_duantieubieu">Dự Án Tiêu Biểu</p>
                <p class="desc_duantieubieu">Những dự án tiêu biểu mà FunHome đề cử đến người dùng</p>
            </div>
            <div class="swiper mySwiper1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide slide_duantieubieu">
                        <div class="duan-img-wrapper">
                            <img src="{{ asset('users/images/typical-project-items.png') }}" alt="duantieubieu"
                                class="img_duan">
                            <div class="duan-overlay">
                                <h3 class="duan-title">Phòng trọ sinh viên</h3>
                                <p class="duan-description mt-3">
                                    FunHome đem đến không gian sống phù hợp với học sinh, sinh viên với đầy đủ nội thất,
                                    thiết kế hiện đại và sang trọng.
                                </p>
                                <a href="#" class="duan-btn">Tìm hiểu ngay →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide slide_duantieubieu">
                        <div class="duan-img-wrapper">
                            <img src="{{ asset('users/images/typical-project-items2.png') }}" alt="duantieubieu"
                                class="img_duan">
                            <div class="duan-overlay d-flex flex-column h-100">
                                <div class="duan-text">
                                    <h3 class="duan-title">Căn hộ gia đình</h3>
                                    <p class="duan-description mt-3">
                                        FunHome đem đến không gian sống cho gia đình, với không gian rộng rãi và lối thiết
                                        kế hiện đại sẽ đem đến người dùng trải nghiệm tốt nhất.
                                    </p>
                                </div>
                                <a href="#" class="duan-btn mt-auto">Tìm hiểu ngay →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide slide_duantieubieu">
                        <div class="duan-img-wrapper">
                            <img src="{{ asset('users/images/typical-project-items.png') }}" alt="duantieubieu"
                                class="img_duan">
                            <div class="duan-overlay">
                                <h3 class="duan-title">Phòng trọ sinh viên</h3>
                                <p class="duan-description mt-3">
                                    FunHome đem đến không gian sống phù hợp với học sinh, sinh viên với đầy đủ nội thất,
                                    thiết kế hiện đại và sang trọng.
                                </p>
                                <a href="#" class="duan-btn">Tìm hiểu ngay →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide slide_duantieubieu">
                        <div class="duan-img-wrapper">
                            <img src="{{ asset('users/images/typical-project-items2.png') }}" alt="duantieubieu"
                                class="img_duan">
                            <div class="duan-overlay d-flex flex-column h-100">
                                <div class="duan-text">
                                    <h3 class="duan-title">Căn hộ gia đình</h3>
                                    <p class="duan-description mt-3">
                                        FunHome đem đến không gian sống cho gia đình, với không gian rộng rãi và lối thiết
                                        kế hiện đại sẽ đem đến người dùng trải nghiệm tốt nhất.
                                    </p>
                                </div>
                                <a href="#" class="duan-btn mt-auto">Tìm hiểu ngay →</a>
                            </div>
                        </div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>

    {{-- feedback --}}
    <section class="feedback mt-5">
        <div class="container">
            <div class="testimonial-wrapper-2">
                <div class="row justify-content-between align-items-center g-4">
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="swiper mySwiper4">
                                <div class="swiper-wrapper">
                                    @foreach ($feedbacks as $feedback)
                                        <div class="swiper-slide flex-column">
                                            <div class="d-flex feeback_form">
                                                <div class="feedback-avatar">
                                                    <img src="{{ asset($feedback->image ?? '/users/images/OIP (2).jpg') }}"
                                                        alt="Avatar"
                                                        class="rounded-circle w-100 h-100 object-fit-cover">
                                                </div>
                                                <p class="">{{ $feedback->name ?? '' }}</p>
                                            </div>
                                            <p class="feedback-content">"{{ $feedback->message ?? '' }}</p>
                                        </div>
                                    @endforeach

                                </div>
                                <p></p>
                                <div class="swiper-pagination pagination2"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp d-flex justify-content-center" data-wow-delay=".4s"
                        style="visibility: visible; animation-delay: 0.4s;">
                        <div class="testimonial-image">
                            <img src="{{ asset('users/images/Czum.png') }}" alt="img"
                                class="w-100 h-100 object-cover">
                            <div class="card-shape-1 float-bob-x d-none d-sm-flex ">
                                <img src="{{ asset('users/images/testimonial-card1.png') }}" alt="shape-img"
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="card-shape-2 float-bob-y d-none d-sm-flex ">
                                <img src="{{ asset('users/images/testimonial-card2.png') }}" alt="shape-img"
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- news & event --}}
    <section class="event mb-5">
        <div class="container">
            <div class="mt-5">
                <p class="title_event">Sự kiện & Tin tức</p>
                <p class="desc_event">Những sự kiện nổi bật của chúng tôi</p>
            </div>
            <div class="row g-4">
                @forelse ($latestPosts as $latestPost)
                    <div class="col-lg-4 col-md-6">
                        <div class="news-card h-100 shadow-sm rounded-4 overflow-hidden">
                            <div class="news-thumb">
                                <img src="{{ $latestPost->hinh_anh ?? '/users/images/anh18.png' }}" alt="News 1"
                                    class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="news-content p-4">
                                <h5 class="new-title mb-2">{{ $latestPost->tieu_de ?? '' }}</h5>
                                <p class="news-desc mb-3">{{ $latestPost->mo_ta_ngan ?? '' }}</p>
                                <a href="{{ route('news.users.detail', $latestPost->slug) }}"
                                    class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Không có bài viết nào.</p>
                    </div>
                @endforelse


            </div>
        </div>
    </section>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainImg = document.getElementById('main-banner-img');
            const thumbs = Array.from(document.querySelectorAll('.banner-thumb'));
            let current = 0;

            function setActive(idx) {
                thumbs.forEach((thumb, i) => {
                    if (i === idx) {
                        thumb.classList.add('active-thumb');
                    } else {
                        thumb.classList.remove('active-thumb');
                    }
                });
            }
            setActive(current);

            thumbs.forEach((thumb, idx) => {
                thumb.addEventListener('click', function() {
                    mainImg.src = this.dataset.img;
                    current = idx;
                    setActive(current);
                });
            });

            document.getElementById('btn-rect-prev').addEventListener('click', function() {
                current = (current - 1 + thumbs.length) % thumbs.length;
                mainImg.src = thumbs[current].dataset.img;
                setActive(current);
            });

            document.getElementById('btn-rect-next').addEventListener('click', function() {
                current = (current + 1) % thumbs.length;
                mainImg.src = thumbs[current].dataset.img;
                setActive(current);
            });
        });
    </script> --}}
@endsection
