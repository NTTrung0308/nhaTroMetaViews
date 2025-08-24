
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base bx bx-menu icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
        <!-- Search -->
       
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
            <!-- Place this tag where you want the button to render. -->

            <li class="nav-item dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                    data-bs-toggle="dropdown" aria-label="Toggle theme (dark)">
                    <i class="bx-moon icon-base bx icon-md theme-icon-active"></i>
                    <span class="d-none ms-2" id="nav-theme-text">Sáng/Tối</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="light"
                            aria-pressed="false">
                            <span><i class="icon-base bx bx-sun icon-md me-3" data-icon="sun"></i>Sáng</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center active"
                            data-bs-theme-value="dark" aria-pressed="true">
                            <span><i class="icon-base bx bx-moon icon-md me-3" data-icon="moon"></i>Tối</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
                            aria-pressed="false">
                            <span><i class="icon-base bx bx-desktop icon-md me-3" data-icon="desktop"></i>Tự động</span>
                        </button>
                    </li>
                </ul>
            </li>
          
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset(Auth::user()->avatar ?? '/assets/img/default-avatar.png') }}" alt
                            class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset(Auth::user()->avatar ?? '/assets/img/default-avatar.png') }}"
                                            alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ get_config()->site_name ?? 'Metasoftware' }}</h6>
                                    <small
                                        class="text-body-secondary">{{ Auth::user()->getRoleNames()->first() ?? 'Không có vai trò' }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                            <i class="icon-base bx bx-user icon-md me-3"></i><span>Về bạn</span>
                        </a>
                    </li>
                  
                    @if (auth()->user()->hasPermissionTo('Xem phòng trọ') ||
                            auth()->user()->hasPermissionTo('Thêm phòng trọ') ||
                            auth()->user()->hasPermissionTo('Sửa phòng trọ') ||
                            auth()->user()->hasPermissionTo('Xóa phòng trọ'))
                        <li>
                            <a class="dropdown-item" href="#">
                                <span class="d-flex align-items-center align-middle">
                                    <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i><span
                                        class="flex-grow-1 align-middle">Số phòng còn lại</span>
                                    <span
                                        class="flex-shrink-0 badge rounded-pill bg-danger">{{ auth()->user()->max_rooms ?? 0 }}</span>
                                </span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item">
                                <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>
                                </a>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
