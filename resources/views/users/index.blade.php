<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="114x114" href="/source/icons/apple-touch-icon-114x114.png">
    <!-- Primary Meta Tags -->
    <title>{{ $config->site_name ?? 'FunHome - Bất động sản' }} | Tìm kiếm nhà đất, căn hộ, bất động sản</title>
    <meta name="description"
        content="{{ $config->meta_description ?? 'FunHome - Nền tảng kết nối mua bán, cho thuê bất động sản uy tín. Tìm kiếm căn hộ, nhà phố, đất nền với thông tin chi tiết và minh bạch.' }}">
    <meta name="keywords"
        content="{{ $config->meta_keywords ?? 'bất động sản, mua nhà, bán nhà, cho thuê, căn hộ, nhà phố, đất nền, funhome, real estate' }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $config->site_name ?? 'FunHome' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $config->meta_title ?? ($config->site_name ?? 'FunHome - Bất động sản') }}">
    <meta property="og:description"
        content="{{ $config->meta_description ?? 'FunHome - Nền tảng kết nối mua bán, cho thuê bất động sản uy tín. Tìm kiếm căn hộ, nhà phố, đất nền với thông tin chi tiết và minh bạch.' }}">
    <meta property="og:image" content="{{ asset($config->logo ?? 'assets/img/icon_usser.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:site_name" content="{{ $config->site_name ?? 'FunHome' }}">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset(get_config()->favicon_16 ?? 'assets/img/icon_usser.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset(get_config()->favicon_32 ?? 'assets/img/icon_usser.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset(get_config()->favicon_192 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="57x57"
        href="{{ asset(get_config()->favicon_57 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="60x60"
        href="{{ asset(get_config()->favicon_60 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset(get_config()->favicon_72 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset(get_config()->favicon_76 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset(get_config()->favicon_114 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset(get_config()->favicon_120 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset(get_config()->favicon_144 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset(get_config()->favicon_152 ?? 'assets/img/icon_usser.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset(get_config()->favicon_180 ?? 'assets/img/icon_usser.png') }}">


    <!-- CSS -->
    {{-- vendor css --}}
    <link href="{{ asset('users/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('users/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('users/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('/assets/css/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/users/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/users/css/reponse.css') }}">
</head>

<body>
    @if (empty($isLogin))
        @include('users.layout.header')
    @endif

    @yield('content')

    @if (empty($isLogin))
        @include('users.layout.footer')
    @endif

    @include('users.layout.web-config')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('users/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Swiper JS -->
    <script src="{{ asset('users/vendor/swiper/js/swiper-bundle.min.js') }}"></script>
    <script src="/users/js/long.js"></script>
    <script src="/users/js/style.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper-history", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            }
        });
        window.swiper2 = swiper;
    </script>
</body>

</html>
