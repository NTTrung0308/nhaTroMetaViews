<header class="site-header fbs__net-navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="site-logo d-flex align-items-center">
            <a href="/">
                <img class="img-logo w-100" src="{{ asset('/users/images/logo-FunHome.svg') }}" alt="">
            </a>
        </div>

        <!-- Menu cho Desktop -->
        <nav class="main-navigation">
            <ul>
                <li><a href="/">TRANG CHỦ</a></li>
                <!-- Bắt đầu: HTML cho Dropdown -->
                <li class="has-dropdown">
                    <a href="#"> ABOUT

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('about.users.index') }}">Về chúng tôi</a></li>
                        <li><a href="{{ route('members.users.index') }}">Thành viên</a></li>
                        {{-- <li><a href="/history">History</a></li> --}}
                        <li><a href="{{ route('services.users.index') }}">Dịch vụ</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#"> HỆ THỐNG

                        <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/dich-vu">Dịch vụ</a></li>
                        <li><a href="{{ route('rooms.users.index') }}">Tìm phòng</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('news.users') }}">TIN TỨC</a></li>
                <li><a href="{{ route('contact.users.index') }}">LIÊN HỆ</a></li>
            </ul>
        </nav>
        <div class="btn-download-app">
            <a href="" class="btn-download">Download</a>
        </div>
        <!-- Icon Hamburger cho Mobile -->
        <div class="mobile-menu-toggle" id="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>
<div id="header-placeholder"></div>

<!-- Menu cho Mobile (ẩn mặc định) -->
<div class="mobile-navigation" id="mobile-navigation">

    <!-- 1. Header của Menu Mobile -->
    <div class="mobile-nav-header">
        <a href="#" class="mobile-nav-logo">
            <!-- Thay bằng logo của bạn -->
            <img src="{{ asset('/users/images/logo-FunHome.svg') }}" alt="Logo" class="img-fluid">
        </a>
        <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Đóng menu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- 2. Phần thân Menu (các link chính) -->
    <nav class="mobile-nav-main">
        <ul>
            <li><a href="#" class="active">TRANG CHỦ</a></li>
            <!-- Bắt đầu: HTML cho Dropdown Mobile -->
            <li class="has-dropdown">
                <a href="#">
                    ABOUT
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="{{ route('about.users.index') }}">Về chúng tôi</a></li>
                    <li><a href="{{ route('members.users.index') }}">Thành viên</a></li>
                    <li><a href="/history">History</a></li>
                    <li><a href="{{ route('services.users.index') }}">Dịch vụ</a></li>
                </ul>
            </li>
            <!-- Bắt đầu: HTML cho Dropdown Mobile -->
            <li class="has-dropdown">
                <a href="#">
                    HỆ THỐNG
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </a>
                <ul class="mobile-submenu">
                    <li><a href="/dich-vu">Dịch vụ</a></li>
                    <li><a href="{{ route('rooms.users.index') }}">Tìm phòng</a></li>

                </ul>
            </li>
            <!-- Kết thúc: HTML cho Dropdown Mobile -->
            <li><a href="{{ route('news.users') }}">TIN TỨC</a></li>
            <li><a href="{{ route('contact.users.index') }}">LIÊN HỆ</a></li>
        </ul>
    </nav>
</div>

<!-- Lớp phủ nền (ẩn mặc định) -->
<div class="menu-overlay" id="menu-overlay"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileNavigation = document.getElementById('mobile-navigation');
        const mobileNavClose = document.getElementById('mobile-nav-close');
        const menuOverlay = document.getElementById('menu-overlay');

        // Logic để mở/đóng toàn bộ menu mobile
        if (mobileMenuToggle && mobileNavigation) {
            const toggleMenu = (isOpen) => {
                mobileNavigation.classList.toggle('is-open', isOpen);
                if (menuOverlay) menuOverlay.classList.toggle('is-open', isOpen);
            };
            mobileMenuToggle.addEventListener('click', () => toggleMenu(true));
            if (mobileNavClose) mobileNavClose.addEventListener('click', () => toggleMenu(false));
            if (menuOverlay) menuOverlay.addEventListener('click', () => toggleMenu(false));
        }

        // ----------------------------------------------------
        // --- BẮT ĐẦU: JS CHO DROPDOWN (PHẦN THÊM MỚI) ---
        // ----------------------------------------------------

        // Tìm tất cả các mục menu cha trong menu mobile
        const mobileDropdownToggles = document.querySelectorAll('.mobile-nav-main .has-dropdown > a');

        mobileDropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(event) {
                // Ngăn chặn hành vi mặc định của thẻ <a> (chuyển trang)
                event.preventDefault();

                // Lấy phần tử li cha và ul con (submenu)
                const parentLi = this.parentElement;
                const submenu = this.nextElementSibling;

                // Toggle lớp 'submenu-open' trên li cha để xoay mũi tên
                parentLi.classList.toggle('submenu-open');

                // Toggle hiện/ẩn submenu
                if (submenu.style.maxHeight) {
                    submenu.style.maxHeight = null; // Đóng submenu
                } else {
                    submenu.style.maxHeight = submenu.scrollHeight + "px"; // Mở submenu
                }
            });
        });

        // ----------------------------------------------------
        // --- KẾT THÚC: JS CHO DROPDOWN ---
        // ----------------------------------------------------

    });
</script>
