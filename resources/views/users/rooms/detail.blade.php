@extends('users.index')
@section('content')
    <section>
        <div class="banner-vision d-flex align-items-center d-none d-sm-flex">
            <div class="row"></div>
            <div class="col-6">
                <div class="content-vision ">
                    <span>
                        <a href="{{ route('home') }}"
                            class="text-decoration-none text-dark fs-4 fw-bold content-vision-home ">Trang
                            Chủ</a>
                    </span>
                    <span><i class="bi bi-chevron-right fs-5 content-vision-home"></i></span>
                    <span>
                        <a href="{{ route('rooms.index') }}"
                            class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Phòng </a>
                    </span>
                    <span><i class="bi bi-chevron-right fs-5 content-vision-home"></i></span>
                    <span>
                        <a href="#"
                            class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Chi tiết
                            phòng</a>
                    </span>
                    <h1 class="fw-bold mt-2 title">Thông tin phòng cho thuê</h1>
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
                <a href="{{ route('home') }}" class="text-decoration-none text-dark fs-4 fw-bold content-vision-home ">Trang
                    Chủ</a>
            </span>
            <span><i class="bi bi-chevron-right fs-5 "></i></span>
            <span>
                <a href="{{ route('rooms.index') }}" class="text-decoration-none  fw-bold service-banner-title">Danh sách
                    phòng</a>
            </span>
            <span><i class="bi bi-chevron-right fs-5 "></i></span>
            <span>
                <a href="#" class="text-decoration-none  fw-bold service-banner-title">Chi tiết phòng</a>
            </span>
            <h2 class="fw-bold mt-2  text-center text-blue">Thông tin phòng cho thuê</h2>
            <h4 class="w-100 text-center">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất động sản
                đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-9 ">
                <div class="img-detail-room">
                    @if ($room->images && count(json_decode($room->images)) > 0)
                        @php $images = json_decode($room->images); @endphp
                        <img id="mainImage1" src="{{ asset($images[0]) }}" alt="Ảnh chính"
                            class="w-100 main_image object-fit-cover" style="height: 400px;">
                    @else
                        <img id="mainImage1" src="/users/images/default-room.jpg" alt="Ảnh chính"
                            class="w-100 main_image object-fit-cover" style="height: 400px;">
                    @endif

                    <!-- Swiper -->
                    @if ($room->images && count(json_decode($room->images)) > 0)
                        <div class="swiper mySwiperDung mt-3">
                            <div class="swiper-wrapper">
                                @foreach (json_decode($room->images) as $image)
                                    <div class="swiper-slide img-slide">
                                        <img src="{{ asset($image) }}" alt="Ảnh phòng" onclick="changeImage(this.src)"
                                            class="w-100 object-fit-cover detail_image"
                                            style="height: 120px; cursor: pointer;">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next button_next"></div>
                            <div class="swiper-button-prev button_prev"></div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <h4 class="fw-bold">{{ $room->ten_phong }}</h4>
                        <p>{{ $room->nhaTro->dia_chi }}, {{ $room->nhaTro->quan }}, {{ $room->nhaTro->thanh_pho }}</p>
                        <hr>
                    </div>
                    <div class="info-row">
                        <div class="info-left">
                            <div class="info-group">
                                Mức giá
                                <strong class="text-danger">{{ number_format($room->gia_thue) }}đ/tháng</strong>
                            </div>
                            <div class="info-group">
                                Diện tích
                                <strong>{{ $room->dien_tich }} m²</strong>
                                @if ($room->mat_tien)
                                    <div style="font-size: 12px; color: #777;">Mặt tiền {{ $room->mat_tien }} m</div>
                                @endif
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
                        <p>{{ $room->mo_ta ?? 'Chưa có mô tả chi tiết.' }}</p>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-cash-coin"></i>
                                    <span class="info-label">Mức giá</span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end text-danger">
                                        {{ number_format($room->gia_thue) }}<span>đ/tháng</span></p>
                                </div>
                            </div>
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-house-door-fill"></i>
                                    <span class="info-label">Diện tích </span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">{{ $room->dien_tich }} m²</p>
                                </div>
                            </div>
                            <hr>
                            @if ($room->mat_tien)
                                <div class="featured-detail w-100">
                                    <div class="info-left1 w-100">
                                        <i class="bi bi-aspect-ratio"></i>
                                        <span class="info-label">Mặt tiền </span>
                                    </div>
                                    <div class="w-100">
                                        <p class="text-end">{{ $room->mat_tien }} m</p>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-calendar-check"></i>
                                    <span class="info-label">Thời gian vào ở</span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">{{ $room->thoi_gian_vao_o ?? 'Liên hệ' }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-lightning-charge"></i>
                                    <span class="info-label">Mức giá điện </span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">
                                        {{ $room->gia_dien ? number_format($room->gia_dien) . 'đ/kWh' : 'Theo giá nhà nước' }}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="featured-detail w-100">
                                <div class="info-left1 w-100">
                                    <i class="bi bi-droplet"></i>
                                    <span class="info-label">Mức giá nước </span>
                                </div>
                                <div class="w-100">
                                    <p class="text-end">
                                        {{ $room->gia_nuoc ? number_format($room->gia_nuoc) . 'đ/m³' : 'Theo giá nhà nước' }}
                                    </p>
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
                                    <h6 class="mx-2 mt-1">Cho thuê nhà mặt phố tại {{ $room->nhaTro->thanh_pho }}</h6>
                                </div>
                                <div class="box-content">
                                    @foreach ($roomsByDistrict as $district)
                                        <p>
                                            <a href="{{ route('rooms.users.index', ['district' => $district->quan]) }}"
                                                class="text-decoration-none text-dark district-link"
                                                onmouseover="this.style.color='#007bff'"
                                                onmouseout="this.style.color='#000'">
                                                {{ $district->quan }} ({{ $district->count }})
                                            </a>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="fw-bold py-4">Xem trên bản đồ</h3>
                        @if ($room->nhaTro->toa_do)
                            <div id="map" style="width: 100%; height: 400px;"></div>
                        @else
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14899.377068557635!2d105.8604876952148!3d20.99887883924942!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aeaa17c35b81%3A0x79d8becf2f06f8dc!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5o IGdoIHbDoCBDw7RuZyBuZ2jhu4cgSMOgIE7hu5lp!5e0!3m2!1svi!2s!4v1750301949106!5m2!1svi!2s"
                                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @endif
                    </div>
                    <h3 class="fw-bold mt-4"> Phòng tương tự </h3>
                    {{-- PC & Tablet Grid --}}
                    <div class="row mt-3 d-none d-sm-flex">
                        @foreach ($similarRooms as $similarRoom)
                            <div class="col-sm-12 col-md-6 col-lg-4 mt-4 detailroom-mobile">
                                <div class="navbar-news">
                                    @if ($similarRoom->images && count(json_decode($similarRoom->images)) > 0)
                                        <img src="{{ asset(json_decode($similarRoom->images)[0]) }}" alt=""
                                            class="img_4 w-100" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="/users/images/default-room.jpg" alt="" class="img_4 w-100"
                                            style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="text4-detail py-3 mx-3">
                                        <h6>{{ $similarRoom->ten_phong }}</h6>
                                        <span
                                            class="text-danger">{{ number_format($similarRoom->gia_thue) }}đ/tháng</span>
                                        <p>{{ Str::limit($similarRoom->mo_ta ?? 'Chưa có mô tả', 100) }}</p>
                                        <a href="{{ route('rooms.detail', $similarRoom->id) }}"
                                            class="btn btn-primary btn-sm">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Mobile Swiper --}}
                    <div class="d-block d-sm-none mt-3">
                        <div class="swiper detailroom-swiper ">
                            <div class="swiper-wrapper">
                                @foreach ($similarRooms as $similarRoom)
                                    <div class="swiper-slide">
                                        <div class="navbar-news">
                                            @if ($similarRoom->images && count(json_decode($similarRoom->images)) > 0)
                                                @php $simImages = json_decode($similarRoom->images); @endphp
                                                <img src="{{ asset($simImages[0]) }}" alt="" class="img_4 w-100"
                                                    style="height: 200px; object-fit: cover;">
                                            @else
                                                <img src="/users/images/default-room.jpg" alt=""
                                                    class="img_4 w-100" style="height: 200px; object-fit: cover;">
                                            @endif
                                            <div class="text4-detail py-3 mx-3">
                                                <h6>{{ $similarRoom->ten_phong }}</h6>
                                                <span
                                                    class="text-danger">{{ number_format($similarRoom->gia_thue) }}đ/tháng</span>
                                                <p>{{ Str::limit($similarRoom->mo_ta ?? 'Chưa có mô tả', 100) }}</p>
                                                <a href="{{ route('rooms.detail', $similarRoom->id) }}"
                                                    class="btn btn-primary btn-sm">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                            <h6 class="mx-2 mt-1">Cho thuê nhà mặt phố tại {{ $room->nhaTro->thanh_pho }}</h6>
                        </div>
                        <div class="box-content">
                            @foreach ($roomsByDistrict as $district)
                                <p>
                                    <a href="{{ route('rooms.users.index', ['district' => $district->quan]) }}"
                                        class="text-decoration-none text-dark district-link"
                                        onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#000'">
                                        {{ $district->quan }} ({{ $district->count }})
                                    </a>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function changeImage(src) {
            document.getElementById('mainImage1').src = src;
        }
        // Nếu dùng swiper, có thể gắn sự kiện cho các ảnh phụ:
        document.querySelectorAll('.detail_image').forEach(function(img) {
            img.addEventListener('click', function() {
                changeImage(this.src);
            });
        });
    </script>
@endsection