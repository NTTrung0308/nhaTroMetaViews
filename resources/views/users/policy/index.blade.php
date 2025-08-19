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
                    <a href="#"
                        class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home w-100">Chính sách &
                        bảo mật </a>
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
            <h4 class=" text-center">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất động sản
                đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
        </div>
    </div>
    <h1 class="text-center mb-3 mt-5">{{ $policy->title }}</h1>
    <section class="container">
        <div class="box-privacy-policy p-4">
            {!! $policy->content !!}
        </div>
    </section>
@endsection
