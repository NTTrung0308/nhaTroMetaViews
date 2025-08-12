@extends('users.index')
@section('content')

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
                    <a href="#" class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Liên
                        hệ </a>
                </span>
                <h1 class="fw-bold mt-2 title">Liên hệ </h1>
                <h4 class="vision-banner-title">"{{get_config()->site_name ?? 'FunHome'}} là đại diện cho các bất động sản sang trọng đặc biệt và bất
                    động sản
                    đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
            </div>
        </div>
        <div class="col-6 h-100 w-100">
            <div class="w-100 h-100">
                <img src="{{asset('/users/images/anhbg1.png')}}" class="header-banner-vision w-100 h-100 object-fit-cover">
            </div>
        </div>

    </div>
    <div class="container d-block d-sm-none">
        <div class="content-service-banner mt-3 mx-4">
            <span">
                <a href="#" class="text-decoration-none text-dark  fw-bold">Trang Chủ</a>
                </span>
                <span><i class="bi bi-chevron-right fs-5 "></i></span>
                <span>
                    <a href="#" class="text-decoration-none  fw-bold service-banner-title">Liên hệ</a>
                </span>
                <h2 class="fw-bold mt-2  ">Liên hệ</h2>
                <h4 class=" ">"Chúng tôi ở đây để giúp đỡ, bằng mọi cách có thể”</h4>
        </div>
    </div>

    <section class="service pt-5">
        <div class="container">
            <div class="text-center">
                <p class="title_service">Dịch vụ của chúng tôi</p>
                <p class="desc_service">Chúng tôi cam kết tìm ra bất động sản hoàn hảo cho bạn</p>
            </div>
            <div class="service_content">
                <div class="row d-none d-sm-flex">
                    <div class="col-lg-3 col-md-6 col-sm-6 mt-4">
                        <div class="w-100 h-100 text-center box_service">
                            <div class=" icon_service">
                                <i class="bi bi-chat-square-quote fs-2"></i>
                            </div>
                            <p class="desc-content-service mt-3">Thông Tin Dịch Vụ</p>
                            <p class="desc-content-text mx-auto">Cung cấp phòng trọ sạch sẽ, giá rẻ cho sinh viên và người
                                đi làm.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mt-4 ">
                        <div class="w-100 h-100 text-center box_service">
                            <div class=" icon_service">
                                <i class="bi bi-chat-square-text fs-2"></i>
                            </div>
                            <p class="desc-content-service mt-3">Ưu Đãi Hiện Có</p>
                            <p class="desc-content-text mx-auto">Giảm giá 10% cho hợp đồng dài hạn từ 6 tháng trở lên.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mt-4">
                        <div class="w-100 h-100 text-center box_service">
                            <div class=" icon_service">
                                <i class="bi bi-geo-alt fs-2"></i>
                            </div>
                            <p class="desc-content-service mt-3">Khu Vực Phục Vụ</p>
                            <p class="desc-content-text mx-auto">Hiện đang hoạt động tại TP.HCM, Hà Nội và Đà Nẵng.</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 mt-4">
                        <div class="w-100 h-100 text-center box_service">
                            <div class=" icon_service">
                                <i class="bi bi-people fs-2 "></i>
                            </div>
                            <p class="desc-content-service mt-3">Hỗ Trợ Nhanh</p>
                            <p class="desc-content-text mx-auto">Liên hệ Zalo hoặc Hotline 24/7 qua số: {{get_config()->zalo_number ?? '0909 123 456'}}</p>
                        </div>
                    </div>


                </div>
                <!-- Swiper cho mobile -->
                <div class="d-block d-sm-none">
                    <div class="swiper serviceSwiper w-100 h-100 mx-auto">
                        <div class="swiper-wrapper w-100 h-100">
                            <div class="swiper-slide w-100 h-100">
                                <div class="w-100 h-100 text-center box_service">
                                    <div class=" icon_service">
                                        <i class="bi bi-chat-square-quote fs-2"></i>
                                    </div>
                                    <p class="desc-content-service p-2">Thông Tin Dịch Vụ</p>
                                    <p class="desc-content-text mx-auto">Cung cấp phòng trọ sạch sẽ, giá rẻ cho sinh viên và
                                        người đi làm.</p>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="w-100 h-100 text-center box_service">
                                    <div class=" icon_service">
                                        <i class="bi bi-chat-square-text fs-2"></i>
                                    </div>
                                    <p class="desc-content-service p-2">Ưu Đãi Hiện Có</p>
                                    <p class="desc-content-text mx-auto">Giảm giá 10% cho hợp đồng dài hạn từ 6 tháng trở
                                        lên.</p>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="w-100 h-100 text-center box_service">
                                    <div class=" icon_service">
                                        <i class="bi bi-geo-alt fs-2"></i>
                                    </div>
                                    <p class="desc-content-service p-2">Khu Vực Phục Vụ</p>
                                    <p class="desc-content-text mx-auto">Hiện đang hoạt động tại TP.HCM, Hà Nội và Đà Nẵng.
                                    </p>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="w-100 h-100 text-center box_service">
                                    <div class=" icon_service">
                                        <i class="bi bi-people fs-2 "></i>
                                    </div>
                                    <p class="desc-content-service p-2">Hỗ Trợ Nhanh</p>
                                    <p class="desc-content-text mx-auto">Liên hệ Zalo hoặc Hotline 24/7 qua số: {{get_config()->zalo_number ?? '0909 123 456'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-4">
        <!-- Liên hệ -->
        <div class="row contact-main-row mt-5">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <form class="contact-form p-4" action="{{route('contact.users.store')}}"  method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contactName" class="contact-label">Họ tên</label>
                            <input type="text" class="form-control contact-input" id="contactName" name="ten" value="{{old('ten')}}"
                                placeholder="Họ và tên">
                                  @error('ten')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contactEmail" class="contact-label">Email</label>
                            <input type="email" class="form-control contact-input" id="contactEmail" name="email" value="{{old('email')}}"
                                placeholder="Địa chỉ email">
                                 @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contactPhone" class="contact-label">Số điện thoại</label>
                        <input type="text" class="form-control contact-input" id="contactPhone" name="so_dien_thoai" value="{{old('so_dien_thoai')}}"
                            placeholder="Số điện thoại">
                             @error('so_dien_thoai')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="contactMessage" class="contact-label">Tin nhắn</label>
                        <textarea class="form-control contact-input" id="contactMessage" rows="4" name="noi_dung"
                            placeholder="Nội dung tin nhắn cần gửi">{{old('noi_dung')}}</textarea>
                             @error('noi_dung')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                    </div>
                    <button type="submit" class="contact-btn">Gửi tin nhắn</button>
                </form>
            </div>
            <div class="col-lg-6">
                <div class="contact-info-box ps-lg-4">
                    <h2 class="contact-info-title mb-3">Liên Hệ Với Chúng Tôi</h2>
                    <div class="contact-info-desc mb-4">
                        Vui lòng liên hệ trực tiếp qua các thông tin dưới đây, chúng tôi sẽ phản hồi bạn sớm nhất có thể.
                    </div>
                    <ul class="contact-info-list">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt contact-info-icon"></i>
                            <span class="contact-info-label">Địa chỉ:</span>
                            <span class="contact-info-text">{{ get_config()->address ?? '216 Hoàng Mai, Quận Hoàng Mai, Hà Nội' }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope contact-info-icon"></i>
                            <span class="contact-info-label">Email:</span>
                            <span class="contact-info-text">{{ get_config()->email ?? 'hotro@funhome.vn' }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-telephone contact-info-icon"></i>
                            <span class="contact-info-label">Hotline:</span>
                            <span class="contact-info-text">{{ get_config()->hotline ?? '1900 1234' }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-chat-dots contact-info-icon"></i>
                            <span class="contact-info-label">Zalo:</span>
                            <span class="contact-info-text">{{ get_config()->zalo_number ?? '0909 123 456' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>



  
@endsection