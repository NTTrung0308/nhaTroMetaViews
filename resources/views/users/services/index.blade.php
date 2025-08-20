@extends('users.index')
@section('content')
    <section class="service">
        <div class="banner-vision d-flex align-items-center d-none d-sm-flex">
            <div class="row"></div>
            <div class="col-6">
                <div class="content-vision ">
                    <span>
                        <a href="/" class="text-decoration-none text-dark fs-4 fw-bold content-vision-home ">Trang
                            Chủ</a>
                    </span>
                    <span><i class="bi bi-chevron-right fs-5 content-vision-home"></i></span>
                    <span>
                        <a href="{{ route('services.users.index') }}"
                            class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Dịch vụ </a>
                    </span>
                    <h1 class="fw-bold mt-2 title">Thông tin về chúng tôi </h1>
                    <h4 class="vision-banner-title">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất
                        động sản
                        đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
                </div>
            </div>
            <div class="col-6 h-100 w-100">
                <div class="w-100 h-100">
                    <img src="{{ asset('users/images/anhbg1.png') }}"
                        class="header-banner-vision w-100 h-100 object-fit-cover">
                </div>
            </div>

        </div>
        <div class="container d-block d-sm-none">
            <div class="content-service-banner mt-3 mx-4">
                <span">
                    <a href="/" class="text-decoration-none text-dark  fw-bold">Trang Chủ</a>
                    </span>
                    <span><i class="bi bi-chevron-right fs-5 "></i></span>
                    <span>
                        <a href="{{ route('services.users.index') }}"
                            class="text-decoration-none  fw-bold service-banner-title">Dịch vụ của chúng
                            tôi</a>
                    </span>
                    <h2 class="fw-bold mt-4 text-blue text-center ">Dịch vụ của chúng tôi</h2>
                    <h4 class=" ">"Không chỉ là chỗ ở, Fun Home là người bạn đồng hành.”</h4>
            </div>
        </div>

        <div class="container py-5 ">
            <div class="row">
                <h1 class="text-center fw-bold fs-2">Hãy cùng khám phá một số dịch vụ<br> chúng tôi cung cấp</h2>
                    @foreach ($services as $service)
                        <a class="text-decoration-none text-dark"
                            href="{{ route('services.users.detail', ['slug' => $service->slug]) }}">
                            <div class="col-lg-4 col-md-6 col-sm-12 p-3 position-relative">
                                <div class="grid-item service-item service-style-1">
                                    <div class="service-inner service-style-inner">
                                        <div class="service-content">
                                            <div class="service-post-thumbnail">
                                                <img fetchpriority="high" decoding="async"
                                                    src="{{ asset($service->image) }}" class="" alt=""
                                                    srcset="{{ asset($service->image) }} 1024w, {{ asset($service->image) }} 300w, {{ asset($service->image) }} 768w, {{ asset($service->image) }} 1500w">
                                            </div>
                                            <div class="service-button-wrap">
                                                <div class="service-button">
                                                    <span class="btn-icon-wrap">
                                                        <span class="btn-icon"><i
                                                                class="bi bi-arrow-up-right text-white"></i></span>
                                                    </span>
                                                </div>
                                                <div class="decor-border"> </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 p-3">
                                            <h3 class="fw-bold">{{ $service->title ?? '' }}</h3>
                                            <p>{{ $service->description ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
            </div>
    </section>
    </section>
@endsection
