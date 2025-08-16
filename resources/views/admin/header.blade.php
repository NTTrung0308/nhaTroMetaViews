<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="https://bootstrapmade.com/content/demo/NiceAdmin/index.html" class="logo d-flex align-items-center">
            <img src="{{ get_config()->logo ?? '/assets/img/icon_usser.png' }}" alt="">
            <span class="d-none d-lg-block">{{ get_config()->site_name ?? 'Metasoftware' }}</span>
        </a>

        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <!-- Nút là chính đồng hồ số -->
        <span id="clock">


        </span>


    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-clock-history"></i>
                </a>
            </li><!-- End Search Icon-->




            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset(Auth::user()->avatar ?? '/assets/img/default-avatar.png') }}" alt="Profile"
                        class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name ?? 'Không có' }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->username ?? 'Không có' }}</h6>
                        @if (auth()->user()->hasPermissionTo('Xem phòng trọ') ||
                                auth()->user()->hasPermissionTo('Thêm phòng trọ') ||
                                auth()->user()->hasPermissionTo('Sửa phòng trọ') ||
                                auth()->user()->hasPermissionTo('Xóa phòng trọ'))
                            <div>
                                Số phòng trọ có thể thêm: <span class="text-success fw-bold">{{ auth()->user()->max_rooms ?? 'Không có' }}</span>
                            </div>
                        @endif
                        <span>{{ Auth::user()->getRoleNames()->first() ?? 'Không có vai trò' }}</span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Hồ sơ</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Đăng xuất</span>
                            </button>
                        </form>

                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>


<script>
    function updateClock() {
        const now = new Date();
        const h = now.getHours().toString().padStart(2, '0');
        const m = now.getMinutes().toString().padStart(2, '0');
        const s = now.getSeconds().toString().padStart(2, '0');

        document.getElementById('clock').innerText = `${h}:${m}:${s}`;
    }

    setInterval(updateClock, 1000);
    updateClock(); // gọi ngay lần đầu
</script>
