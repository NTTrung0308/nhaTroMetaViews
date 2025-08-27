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
                    <a href="tin-tuc"
                        class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home w-100">Tin tức </a>
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


    <div class="text1 text-center py-5">
        <h2 class="news-title">Thông tin mới nhất </h2>
    </div>
    <div class="container ">
        <div class="row ">
            <div class="col-sm-12 col-md-8 col-lg-8 order-2 order-md-1 mb-3">
                <div class="row ">
                    @forelse ($tinTucs as $tinTuc)
                        <div class="col-6 col-md-6 col-lg-4 mb-3  ">
                            <a href="{{ route('news.users.detail', $tinTuc->slug) }}" class="text-dark "
                                style="text-decoration: none">
                                <div class="nav-news h-100">
                                    <img src="{{ $tinTuc->hinh_anh ? asset($tinTuc->hinh_anh) : asset('/users/images/anh5.png') }}"
                                        alt="" class="img_1 w-100 h-50 object-fit-cover">
                                    <div class="text-news p-3">
                                        <h6 class="title-news">
                                            {{ $tinTuc->tieu_de ??
                                                'Giá trọ khu vực Hoàng Mai đang có xu hướng giảm giá sau điều chỉnh của cơ chế thị trường .' }}
                                        </h6>
                                        <p class="line-text-limit-5">{{ $tinTuc->mo_ta_ngan ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="alert alert-warning text-center" role="alert">
                            Không có bài viết nào
                        </div>
                    @endforelse

                </div>
                <div class=" p-nav text-end d-flex justify-content-end">
                    {{ $tinTucs->appends(request()->query())->links('pagination::bootstrap-4') }}
                    {{-- @for ($i = 1; $i <= 9; $i++)
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-3 news-item-for-mobile">
                            <div class="nav-news">
                                <img src="{{ asset('/users/images/anh5.png') }}" alt="" class="img_1 w-100 h-50">
                                <div class="text-news p-3">
                                    <h6 class="title-news">Giá trọ khu vực Hoàng Mai đang có xu hướng giảm giá sau điều chỉnh của cơ chế thị
                                        trường .</h6>
                                    <p class="line-text-limit-5">Đây là một đoạn mô tả ngắn hay còn gọi là description hoặc
                                        content . Lorem ipsum dolor sit amet consectetur adipisicing
                                        elit. Id tenetur porro, blanditiis, nesciunt unde beatae quod quas ab perferendis
                                        odit dolore, sit non dolorem? Omnis cumque praesentium minima ducimus perferendis.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endfor --}}
                </div>
            </div>
            {{-- search --}}
            <div class="col-sm-12 col-md-4 col-lg-4 order-1 cc mb-3 ">
                <div class="news-search ">
                    <div class="search-news mb-3">
                        <h4>Tìm kiếm</h4>
                    </div>

                    <form method="GET" action="{{ route('news.users') }}" class="search-bar">
                        <span class="search-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </span>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control w-100"
                            placeholder="Tìm kiếm...">
                    </form>

                    <div class=" text2-news text-center py-3">
                        <h5>Tin tức phòng mới </h5>
                    </div>
                    <div class="row ">
                        @forelse ($tinMoi as $tin)
                            <div class="news-item-mobile p-2">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="w-100 h-100">
                                            <img src="{{ $tin->hinh_anh ? asset($tin->hinh_anh) : asset('/users/images/anh7.png') }}"
                                                alt="" class="img_2 w-100 h-100 object-fit-cover">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="text3-news w-100 h-100">
                                            <a href="{{ route('news.users.detail', $tin->slug) }}"
                                                class="text-decoration-none text-dark text-news ">
                                                <h6>{{ $tin->tieu_de }}</h6>
                                                <p>{{ $tin->mo_ta_ngan }}</p>
                                            </a>
                                            <small class="text-muted">
                                                @if (\Carbon\Carbon::parse($tin->created_at)->isToday())
                                                    Đăng hôm nay
                                                @else
                                                    Đăng ngày
                                                    {{ \Carbon\Carbon::parse($tin->created_at)->format('d/m/Y') }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">Không có tin mới</div>
                        @endforelse
                    </div>  

                </div>
            </div>
        </div>
    </div>
@endsection