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
                            class="text-decoration-none fs-4 fw-bold vision-banner-title content-vision-home">Tìm kiếm phòng
                        </a>
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
    </section>
    <div class="container d-block d-sm-none">
        <div class="content-service-banner mt-3 mx-4">
            <span>
                <a href="#" class="text-decoration-none text-dark  fw-bold">Trang Chủ</a>
            </span>
            <span><i class="bi bi-chevron-right fs-5 "></i></span>
            <span>
                <a href="#" class="text-decoration-none  fw-bold service-banner-title">Tìm kiếm phòng</a>
            </span>
            <h2 class="fw-bold mt-2  text-center text-blue">Thông tin về phòng</h2>
            <h4 class=" text-center">"FunHome là đại diện cho các bất động sản sang trọng đặc biệt và bất động sản
                đơn lẻ tại các quận được săn đón nhất của thành phố. Vì vậy, đừng bỏ lỡ cơ hội tuyệt vời này.”</h4>
        </div>
    </div>
    <div class="container">
        <div class="text-center pt-5">
            <i class="text-center title-funhome">FunHome</i>
        </div>

        <h1 class="text-center title-search fw-bold pb-5">Tìm căn phòng mơ ước của bạn tại Hà Nội</h1>

        <div class="row mb-4">
            <!-- Main content (left side) -->
            <div class="col-lg-8 order-2 order-lg-1 mb-3">
                <!-- Room listing 1 -->
                @forelse ($rooms as $room)
                    @php
                        $images = is_array($room->images) ? $room->images : json_decode($room->images, true);
                    @endphp
                    <div class="room-listing mb-4">
                        <div class="row g-2">
                            <div class="col-md-8">
                                {{-- Ảnh chính: lấy ảnh đầu tiên trong mảng images --}}
                                <img src="{{ isset($images[0]) ? asset($images[0]) : asset('/users/images/default-image.png') }}"
                                    alt="Ảnh chính của {{ $room->ten_phong }}" class="w-100 h-100 object-fit-cover rounded">
                            </div>
                            <div class="col-md-4">
                                <div class="row g-2">
                                    <div class="col-6 col-md-12">
                                        {{-- Ảnh phụ 1: lấy ảnh thứ hai --}}
                                        <img src="{{ isset($images[1]) ? asset($images[1]) : asset('/users/images/default-image.png') }}"
                                            alt="Ảnh phụ 1 của {{ $room->ten_phong }}"
                                            class="w-100 object-fit-cover img-search rounded">
                                    </div>
                                    <div class="col-6 col-md-12">
                                        {{-- Ảnh phụ 2: lấy ảnh thứ ba --}}
                                        <img src="{{ isset($images[2]) ? asset($images[2]) : asset('/users/images/default-image.png') }}"
                                            alt="Ảnh phụ 2 của {{ $room->ten_phong }}"
                                            class="w-100 object-fit-cover img-search rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="room-card mt-3">
                            <div class="room-info w-75">
                                {{-- Tên phòng --}}
                                <h2 class="h4">{{ $room->ten_phong }}</h2>
                                <div class="details">
                                    {{-- Địa chỉ (lấy từ nhà trọ liên quan) và diện tích --}}
                                    <i class="fas fa-map-marker-alt"></i> {{ $room->nhaTro->dia_chi ?? 'Đang cập nhật' }}
                                    &nbsp;
                                    <i class="fas fa-ruler-combined"></i> {{ $room->dien_tich }}m²
                                </div>
                                <div class="time">
                                    {{-- Thời gian đăng, định dạng dễ đọc --}}
                                    <i class="far fa-clock"></i> Đăng {{ $room->created_at->diffForHumans() }}
                                </div>
                                <div class="author">
                                    {{-- Giả sử nhà trọ có thông tin chủ nhà --}}
                                    <img src="{{ $room->nhaTro->chuNha->avatar ?? 'https://cdn-icons-png.flaticon.com/512/149/149071.png' }}"
                                        alt="Chủ nhà" class="rounded-circle" width="24" height="24">
                                    {{ $room->nhaTro->chuNha->name ?? 'Chủ nhà' }}
                                </div>
                            </div>
                            <div class="room-price">
                                <div class="label">Giá / phòng</div>
                                {{-- Giá thuê, định dạng lại cho dễ đọc --}}
                                <div class="price">{{ number_format($room->gia_thue, 0, ',', '.') }} VND</div>

                                {{-- Nút chọn phòng, có thể thay đổi dựa trên trạng thái phòng --}}
                                @if ($room->status == 'trong')
                                    <a href="{{ route('rooms.users.detail', $room->id) }}" class="btn btn-primary">Chọn phòng</a>
                                @else
                                    <a href="#" class="btn btn-secondary disabled" aria-disabled="true">Đã có người
                                        thuê</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Hiển thị khi không có phòng nào --}}
                    <div class="alert alert-info text-center">
                        <p>Không tìm thấy phòng nào phù hợp với yêu cầu của bạn.</p>
                    </div>
                @endforelse

                <div class=" p-nav text-center d-flex justify-content-center">
                    <!-- Pagination -->
                    {{ $rooms->appends(request()->query())->links('pagination::bootstrap-4') }}

                </div>
            </div>

            <!-- Sidebar (right side) -->
            <div class="col-lg-4 order-1 order-lg-2 mb-3">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5 card-title mb-3">Tìm kiếm nâng cao</h3>
                        <form class="row g-3" method="GET" action="{{ route('rooms.users.index') }}">
                            <div class="col-12">
                                <label for="keyword" class="form-label">Từ khóa</label>
                                <input type="text" id="keyword" name="keyword" class="form-control"
                                    placeholder="Tên phòng, địa chỉ..." value="{{ request('keyword') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="district" class="form-label">Quận/Huyện</label>
                                <select id="district" name="district" class="form-select">
                                    <option value="">Chọn quận</option>
                                    <option value="hoangmai" {{ request('district') == 'hoangmai' ? 'selected' : '' }}>
                                        Hoàng Mai</option>
                                    <option value="caugiay" {{ request('district') == 'caugiay' ? 'selected' : '' }}>Cầu
                                        Giấy</option>
                                    <option value="xuanthuy" {{ request('district') == 'xuanthuy' ? 'selected' : '' }}>Xuân
                                        Thủy</option>
                                    <option value="tayho" {{ request('district') == 'tayho' ? 'selected' : '' }}>Tây Hồ
                                    </option>
                                    <option value="thanhxuan" {{ request('district') == 'thanhxuan' ? 'selected' : '' }}>
                                        Thanh Xuân</option>
                                    <option value="dongda" {{ request('district') == 'dongda' ? 'selected' : '' }}>Đống Đa
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="price" class="form-label">Khoảng giá</label>
                                <select id="price" name="price" class="form-select">
                                    <option value="">Chọn mức giá</option>
                                    <option value="1" {{ request('price') == '1' ? 'selected' : '' }}>Dưới 3 triệu
                                    </option>
                                    <option value="2" {{ request('price') == '2' ? 'selected' : '' }}>3-5 triệu
                                    </option>
                                    <option value="3" {{ request('price') == '3' ? 'selected' : '' }}>5-7 triệu
                                    </option>
                                    <option value="4" {{ request('price') == '4' ? 'selected' : '' }}>Trên 7 triệu
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="balcony" class="form-label">Ban công</label>
                                <select id="balcony" name="balcony" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="co" {{ request('balcony') == 'co' ? 'selected' : '' }}>Có ban công
                                    </option>
                                    <option value="khong" {{ request('balcony') == 'khong' ? 'selected' : '' }}>Không có
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="area" class="form-label">Diện tích</label>
                                <select id="area" name="area" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="20-30" {{ request('area') == '20-30' ? 'selected' : '' }}>20-30m²
                                    </option>
                                    <option value="30-50" {{ request('area') == '30-50' ? 'selected' : '' }}>30-50m²
                                    </option>
                                    <option value="50-70" {{ request('area') == '50-70' ? 'selected' : '' }}>50-70m²
                                    </option>
                                    <option value="70+" {{ request('area') == '70+' ? 'selected' : '' }}>Trên 70m²
                                    </option>
                                </select>
                            </div>
                            <div class="col-12 row pt-3" style="display: flex; justify-content: center;">
                               
                               <div class="col-lg-6">
                                 <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i> Tìm kiếm
                                </button>
                               </div>
                                <div class="col-lg-6">
                                    <a class="btn btn-success w-100" href="{{ route('rooms.users.index') }}">Quay lại</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
