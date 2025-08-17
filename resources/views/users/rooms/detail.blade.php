@extends('users.index')
@section('content')


<section>
        <div class="banner-vision d-flex align-items-center d-none d-sm-flex">
            <div class="row"></div>
            <div class="col-6">
                <div class="content-vision ">
                    <span>
                        <a href="#" class="text-decoration-none text-dark fs-4 fw-bold content-vision-home ">Trang
                            Chủ</a>
                    </span>
                    <span><i class="bi bi-chevron-right fs-5 content-vision-home"></i></span>
                    <span>
                        <a href="#"
                            class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Phòng </a>
                    </span>
                    <h1 class="fw-bold mt-2 title">Thông tin về chúng tôi </h1>
                    <h4 class="vision-banner-title">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất
                        động sản
                        đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
                </div>
            </div>
            <div class="col-6 h-100 w-100">
                <div class="w-100 h-100">
                    <img src="/users/images/anhbg1.png" class="header-banner-vision w-100 h-100 object-fit-cover">
                </div>
            </div>

        </div>
    </section>
    <div class="container d-block d-sm-none">
        <div class="content-service-banner mt-3 mx-4">
            <span>
                <a href="#" class="text-decoration-none text-dark  fw-bold">Trang Chủ</a>
            </span>
            <span><i class="bi bi-chevron-right fs-5 "></i></span>
            <span>
                <a href="#" class="text-decoration-none  fw-bold service-banner-title">Chi
                    tiết tin tức</a>
            </span>
            <h2 class="fw-bold mt-2  text-center text-blue">Thông tin về chúng tôi</h2>
            <h4 class="w-100 text-center">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất động sản
                đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-9 ">
                <div class="img-detail-room">
                    <img id="mainImage1" src="/users/images/anh8.png" alt="Ảnh chính" class="  w-100  main_image object-fit-cover">
                    <!-- Swiper -->
                    <div class="swiper mySwiperDung">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide img-slide"><img src="/users/images/anh10.png" alt="Ảnh 1"
                                    onclick="changeImage(this.src)" class="w-100 object-fit-cover detail_image"></div>
                            <div class="swiper-slide img-slide"><img src="/users/images/anh8.png" alt="Ảnh 1"
                                    onclick="changeImage(this.src)" class="w-100 object-fit-cover"></div>
                            <div class="swiper-slide img-slide"><img src="/users/images/anh7.png" alt="Ảnh 1"
                                    onclick="changeImage(this.src)" class="w-100 object-fit-cover"></div>
                            <div class="swiper-slide img-slide"><img src="/users/images/anh5.png" alt="Ảnh 1"
                                    onclick="changeImage(this.src)" class="w-100 object-fit-cover"></div>
                            <div class="swiper-slide img-slide"><img src="/users/images/anh4.png" alt="Ảnh 1"
                                    onclick="changeImage(this.src)" class="w-100 object-fit-cover"></div>
                            <div class="swiper-slide img-slide"><img src="/users/images/anh3.png" alt="Ảnh 1"
                                    onclick="changeImage(this.src)" class="w-100 object-fit-cover"></div>
                        </div>
                        <div class="swiper-button-next button_next"></div>
                        <div class="swiper-button-prev button_prev"></div>
                    </div>
                    <div class="mt-4">
                        <h4 class="fw-bold"> Cho thuê nhà mặt phố Thượng Thụy, quận Tây Hồ giá rẻ </h4>
                        <p>Số 8 Phố Thượng Thụy, Phường Phú Thượng, Tây Hồ, Hà Nội</p>
                        <hr>
                    </div>
                    <div class="info-row">
                        <div class="info-left">
                            <div class="info-group">
                                Mức giá
                                <strong>10 triệu/tháng</strong>
                            </div>
                            <div class="info-group">
                                Diện tích
                                <strong>130 m²</strong>
                                <div style="font-size: 12px; color: #777;">Mặt tiền 7.2 m</div>
                            </div>
                        </div>
                        <div class="info-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-share" viewBox="0 0 16 16">
                                <path
                                    d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-heart" viewBox="0 0 16 16">
                                <path
                                    d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mt-4">Thông tin mô tả</h4>
                        <p>Cho thuê nhà mặt tiền 7.2m diện tích 130m² phố Thượng Thụy, quận Tây Hồ.Tiện kinh doanh, kho
                            xưởng,
                            sửa xe ô tô xe máy. Giá 10tr/tháng.</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-search"></i>
                                    <span class="info-label">Mức giá</span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">10tr/tháng</p>
                                </div>
                            </div>
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-house-door-fill"></i>
                                    <span class="info-label">Diện tích </span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">130m2</p>
                                </div>
                            </div>
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-house-door-fill"></i>
                                    <span class="info-label">Mặt tiền </span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">7,2m2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-search"></i>
                                    <span class="info-label">Thơi gian vào ở</span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">Ở ngay</p>
                                </div>
                            </div>
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-house-door-fill"></i>
                                    <span class="info-label">Mức giá điện, nước </span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end mt-2">Do nhà chủ cung cấp</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3 mb-3  d-lg-none">
                        <div class="detailroom">
                            <div class="row contact-detailroom mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <img src="/users/images/anh11.png" alt="" class="img-detailroom1">
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class=" contact-detail ">
                                        <h6 class="fw-bold name-detailroom">Nguyễn Doãn Dũng</h6>
                                        <span> Xem thêm 2 thông tin </span>
                                    </div>
                                </div>
                                <hr class="mt-3">
                                <div class="img-detailroom d-flex ">
                                    <img src="/users/images/anh12.png" alt="">
                                    <h6 class="mt-2 ">Chat qua zalo</h6>
                                </div>
                                <div class="img-detailroom d-flex mt-3">
                                    <i class="bi bi-telephone"></i>
                                    <h6 class="mt-2"> 0823567489 </h6>
                                </div>
                            </div>
                            <div class="warning">
                                <div class="d-flex">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <span>
                                        <h6 class="text-danger mx-2 mt-1">Lưu ý </h6> Không nên đặt cọc, giao dịch trước
                                        khi xem
                                        nhà và xác
                                        minh thông tin của người
                                        cho thuê.
                                    </span>
                                </div>
                            </div>
                            <div class="locale-detailroom">
                                <div class="d-flex">
                                    <img src="/users/images/anh13.png" alt="" class="img-detailroom2">
                                    <h6 class="mx-2 mt-1">Cho thuê nhà mặt phố tại Quận
                                        Tây Hồ</h6>
                                </div>
                                <div class="box-content">
                                    <p>Xuân La (27)</p>
                                    <p>Quảng An (17)</p>
                                    <p>Thụy Khuê (15)</p>
                                    <p>Phú Thượng (7)</p>
                                    <p>Yên Phụ (6)</p>
                                    <p>Bưởi (5)</p>
                                    <p>Nhật Tân (2)</p>
                                    <p>Tứ Liên (2)</p>
                                    <p>Yên Phụ (6)</p>
                                    <p>Bưởi (5)</p>
                                    <p>Nhật Tân (2)</p>
                                    <p>Tứ Liên (2)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-bold py-4">Xem trên bản đồ</h3>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14899.377068557635!2d105.8604876952148!3d20.99887883924942!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aeaa17c35b81%3A0x79d8becf2f06f8dc!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIGRvYW5oIHbDoCBDw7RuZyBuZ2jhu4cgSMOgIE7hu5lp!5e0!3m2!1svi!2s!4v1750301949106!5m2!1svi!2s"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <h3 class="fw-bold mt-4"> Giá phòng dành cho bạn </h3>
                    {{-- PC & Tablet Grid --}}
                    <div class="row mt-3 d-none d-sm-flex">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="col-sm-12 col-md-6 col-lg-4 mt-4 detailroom-mobile">
                                <div class="navbar-news">
                                    <img src="/users/images/anh5.png" alt="" class="img_4 w-100 h-100">
                                    <div class="text4-detail py-3 mx-3">
                                        <h6>Cho thuê nhà 226p.Vĩnh Hưng, Hoàng Mai, Hà Nội</h6>
                                        <span class="text-danger">10tr/tháng</span>
                                        <p>Phù hợp với hộ gia đình hoặc sinh viên ở nhiều người, mong mọi người tham khảo
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    {{-- Mobile Swiper --}}
                    <div class="d-block d-sm-none mt-3">
                        <div class="swiper detailroom-swiper ">
                            <div class="swiper-wrapper">
                                @for ($i = 0; $i < 6; $i++)
                                    <div class="swiper-slide">
                                        <div class="navbar-news">
                                            <img src="/users/images/anh5.png" alt="" class="img_4 w-100 h-100">
                                            <div class="text4-detail py-3 mx-3">
                                                <h6>Cho thuê nhà 226p.Vĩnh Hưng, Hoàng Mai, Hà Nội</h6>
                                                <span class="text-danger">10tr/tháng</span>
                                                <p>Phù hợp với hộ gia đình hoặc sinh viên ở nhiều người, mong mọi người tham
                                                    khảo</p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-3 mb-3 d-none d-sm-block ">
                <div class="detailroom">
                    <div class="row contact-detailroom mt-5">
                        <div class="col-sm-12 col-md-12 col-lg-4">
                            <img src="/users/images/anh11.png" alt="" class="img-detailroom1">
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class=" contact-detail ">
                                <h6 class="fw-bold name-detailroom">Nguyễn Doãn Dũng</h6>
                                <span> Xem thêm 2 thông tin </span>
                            </div>
                        </div>
                        <hr class="mt-3">
                        <div class="img-detailroom d-flex ">
                            <img src="/users/images/anh12.png" alt="">
                            <h6 class="mt-2 ">Chat qua zalo</h6>
                        </div>
                        <div class="img-detailroom d-flex mt-3">
                            <i class="bi bi-telephone"></i>
                            <h6 class="mt-2"> 0823567489 </h6>
                        </div>
                    </div>
                    <div class="warning">
                        <div class="d-flex">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span>
                                <h6 class="text-danger mx-2 mt-1">Lưu ý </h6> Không nên đặt cọc, giao dịch trước khi xem
                                nhà và xác
                                minh thông tin của người
                                cho thuê.
                            </span>
                        </div>
                    </div>
                    <div class="locale-detailroom">
                        <div class="d-flex">
                            <img src="/users/images/anh13.png" alt="" class="img-detailroom2">
                            <h6 class="mx-2 mt-1">Cho thuê nhà mặt phố tại Quận
                                Tây Hồ</h6>
                        </div>
                        <div class="box-content">
                            <p>Xuân La (27)</p>
                            <p>Quảng An (17)</p>
                            <p>Thụy Khuê (15)</p>
                            <p>Phú Thượng (7)</p>
                            <p>Yên Phụ (6)</p>
                            <p>Bưởi (5)</p>
                            <p>Nhật Tân (2)</p>
                            <p>Tứ Liên (2)</p>
                            <p>Yên Phụ (6)</p>
                            <p>Bưởi (5)</p>
                            <p>Nhật Tân (2)</p>
                            <p>Tứ Liên (2)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection