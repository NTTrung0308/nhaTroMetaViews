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
                            class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Tin tức</a>
                    </span>
                    <h1 class="fw-bold mt-2 title">Thông tin về chúng tôi </h1>
                    <h4 class="vision-banner-title">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất
                        động sản
                        đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
                </div>
            </div>
            <div class="col-6 h-100 w-100">
                <div class="w-100 h-100">
                    <img src="{{asset('users/images/anhbg1.png')}}" class="header-banner-vision w-100 h-100 object-fit-cover">
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
    </div>
    <div class="text1 text-center py-5">
        <h2 class="news-title">Thông tin chi tiết</h2>
    </div>
    </div>
    <div class="container ">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="text-news py-3">
                    <img src="{{asset($tinTuc->hinh_anh ?? 'users/images/anh3.png')}}" alt="" class="img_1">
                    <h4 class="pt-3">{{$tinTuc->tieu_de ?? ''}}</h5>
                
                </div>
               <div class="cointent-news">
                {!! $tinTuc->noi_dung ?? '' !!}
               </div>
                <hr>
                <div class="col-sm-12 col-md-12 col-lg-4 d-lg-none">
                    <div class="news-search">
                        <div class="order-1 order-md-2">
                            <div class="search-news py-2  ">
                                <div class="fs-4">Tìm kiếm</div>
                            </div>
                            <div class="search-bar ">
                                <span class="search-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8" />
                                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Tìm kiếm...">
                            </div>
                        </div>
                       
                        <div class="wrapper-detail py-3 ">
                            <div class="news-box">
                                <h3 class="news-box-title text-center">Tin tức mới nhất</h3>
                                @foreach ($tinMoi as $tinmoiItem)
                                     <div class="news-box-item">
                                 <a href="{{ route('news.users.detail', $tinmoiItem->slug) }}" style="text-decoration: none" class="text-dark">  {{ $tinmoiItem->tieu_de ??
                                                'Giá trọ khu vực Hoàng Mai đang có xu hướng giảm giá sau điều chỉnh của cơ chế thị trường .' }}</a>
                                </div>
                                @endforeach
                               
                               
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4 d-none d-lg-block">
                <div class="news-search">
                    <div class="order-1 order-md-2">
                        <div class="search-news py-2  ">
                            <h3> SEARCH</h3>
                        </div>
                        <div class="search-bar ">
                            <span class="search-icon">
                                <svg width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Tìm kiếm...">
                        </div>
                    </div>
                 
                    <div class="wrapper-detail py-3 ">
                        <div class="news-box">
                            <h3 class="news-box-title text-center">Tin tức mới nhất</h3>
                             @foreach ($tinMoi as $tinmoiItem)
                                     <div class="news-box-item">
                                 <a href="{{ route('news.users.detail', $tinmoiItem->slug) }}" style="text-decoration: none" class="text-dark">   {{ $tinmoiItem->tieu_de ??
                                                'Giá trọ khu vực Hoàng Mai đang có xu hướng giảm giá sau điều chỉnh của cơ chế thị trường .' }}</a>
                                </div>
                                @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
