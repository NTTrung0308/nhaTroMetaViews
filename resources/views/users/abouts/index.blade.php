@extends('users.index')
@section('content')
 <section class="about-banner">

        <div class="row w-100">
            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center align-items-center">
                <div class="about-box ">
                    <div> <a href="/"class="about-breadcrumb text-decoration-none">  Trang chủ </a>
                        <span class="about-breadcrumb-sep">&gt;</span>
                        <span class="about-breadcrumb-active">Giới thiệu</span>
                    </div>
                    <h1 class="about-banner-title ">Giới Thiệu</h1>
                    <div class="about-breadcrumb">
                        Định hướng &amp; Nguyên Lý &amp; Phát triển
                    </div>
                    <div class="about-orientation">
                        <h4 class="about-breadcrumb-active">Định hướng </h4>
                        <h2>Sự thanh lịch thông qua sự đơn giản</h2>

                        <hr class="about-divider my-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-door-closed-fill fs-4 me-3"></i>
                            <span class="fs-5">Nội thất cao cấp</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt-fill fs-4 me-3"></i>
                            <span class="fs-5">Vị trí đắc địa</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-cash-stack fs-4 me-3"></i>
                            <span class="fs-5">Giá cả phù hợp</span>
                        </div>
                        <button class="about-btn">
                            <i class="bi bi-arrow-right-circle"></i> Tìm hiểu ngay
                        </button>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <img src="{{ asset('/users/images/banner-about.png') }}" alt="About Us" class="w-100 banner-img-about">
            </div>
        </div>
    </section>



    <section class="about-banner-mobile">
        <img src="{{ asset('/users/images/banner-about-mobile.png') }}" alt="About Us" class="about-banner-mobile-bg-img">
        <div class="container  w-100 h-100">
            <div class="about-banner-mobile-content w-100 h-100">
                <div class="about-banner-mobile-content-1 ">
                    <div> <a href="/"class="about-breadcrumb-mobile text-decoration-none">  Trang chủ </a>
                        <span class="about-breadcrumb-mobile-sep">&gt;</span>
                        <span class="about-breadcrumb-mobile-active">Giới thiệu</span>
                    </div>
                    <h2 class="about-banner-mobile-title text-start">Giới Thiệu</h2>
                    <div class="about-banner-mobile-sub">
                        Định hướng &amp; Nguyên Lý &amp; Phát triển
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="fw-bold mb-3">{{ $abouts->title }}</h1>
                <p class="lead mb-3">{{ $abouts->description }}</p>
                <div class="mb-4">
                    <h4 class="fw-bold">{{ $abouts->mission_title }}</h4>
                    <p>{{ $abouts->mission }}</p>
                </div>
                <div class="mb-4">
                    <h4 class="fw-bold">{{ $abouts->vision_title }}</h4>
                    <p>{{ $abouts->vision }}</p>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                @if(!empty($abouts->image))
                    <img src="{{ asset($abouts->image) }}" alt="{{ $abouts->title }}" class="img-fluid rounded shadow">
                @else
                    <img src="{{ asset('/users/images/banner-about.png') }}" alt="About Us" class="img-fluid rounded shadow">
                @endif
            </div>
        </div>
    </section>

    <section class="container my-5">
        <div class="bg-light p-4 rounded shadow">
            {!! $abouts->content !!}
        </div>
    </section>


@endsection