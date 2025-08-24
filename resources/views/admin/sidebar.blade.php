 {{-- <aside id="sidebar" class="sidebar">

     <ul class="sidebar-nav" id="sidebar-nav">

         <li class="nav-item">
             <a class="nav-link {{ in_array(Request::route()->getName(), ['dashboard.index']) ? '' : 'collapsed' }}"
                 href="{{ route('dashboard.index') }}">
                 <i class="bi bi-grid"></i>
                 <span>Dashboard</span>
             </a>
         </li><!-- End Dashboard Nav -->
         @if (auth()->user()->hasAnyPermission(['Xem dịch vụ', 'Xem nhà trọ', 'Xem phòng trọ', 'Xem công tơ điện', 'Xem công tơ nước', 'Xem tài sản trọ', 'Xem tài sản', 'Xem quản lý điện nước']))
             <li class="nav-heading">Quản lý vận hành</li>
         @endif


         @if (auth()->user()->hasPermissionTo('Xem dịch vụ') || auth()->user()->hasPermissionTo('Thêm dịch vụ') || auth()->user()->hasPermissionTo('Sửa dịch vụ') || auth()->user()->hasPermissionTo('Xóa dịch vụ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['dichvu.index', 'dichvus.create', 'dichvus.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('dichvu.index') }}">
                     <i class="bi bi-tools"></i>
                     <span>Dịch vụ</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem nhà trọ') || auth()->user()->hasPermissionTo('Thêm nhà trọ') || auth()->user()->hasPermissionTo('Sửa nhà trọ') || auth()->user()->hasPermissionTo('Xóa nhà trọ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['nha_tro.index', 'nha_tro.create', 'nha_tro.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('nha_tro.index') }}">
                     <i class="bi bi-house-door"></i>
                     <span>Nhà trọ</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem phòng trọ') || auth()->user()->hasPermissionTo('Thêm phòng trọ') || auth()->user()->hasPermissionTo('Sửa phòng trọ') || auth()->user()->hasPermissionTo('Xóa phòng trọ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['rooms.index', 'rooms.create', 'rooms.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('rooms.index') }}">
                     <i class="bi bi-door-closed"></i>
                     <span>Phòng trọ</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem công tơ điện') || auth()->user()->hasPermissionTo('Thêm công tơ điện') || auth()->user()->hasPermissionTo('Sửa công tơ điện') || auth()->user()->hasPermissionTo('Xóa công tơ điện'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.cong_tos.dien.index', 'admin.cong_tos.dien.create', 'admin.cong_tos.dien.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.cong_tos.dien.index') }}">
                     <i class="bi bi-lightning"></i>
                     <span>Công tơ điện</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem công tơ nước') || auth()->user()->hasPermissionTo('Thêm công tơ nước') || auth()->user()->hasPermissionTo('Sửa công tơ nước') || auth()->user()->hasPermissionTo('Xóa công tơ nước'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.cong_tos.nuoc.index', 'admin.cong_tos.nuoc.create', 'admin.cong_tos.nuoc.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.cong_tos.nuoc.index') }}">
                     <i class="bi bi-droplet"></i>
                     <span>Công tơ nước</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem tài sản trọ') || auth()->user()->hasPermissionTo('Thêm tài sản trọ') || auth()->user()->hasPermissionTo('Sửa tài sản trọ') || auth()->user()->hasPermissionTo('Xóa tài sản trọ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['tai_san_chung_riengs.index', 'tai_san_chung_riengs.create', 'tai_san_chung_riengs.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('tai_san_chung_riengs.index') }}">
                     <i class="bi bi-box"></i>
                     <span>Tài sản trọ</span>
                 </a>
             </li>
         @endif

         @if (auth()->user()->hasPermissionTo('Xem tài sản') || auth()->user()->hasPermissionTo('Thêm tài sản') || auth()->user()->hasPermissionTo('Sửa tài sản') || auth()->user()->hasPermissionTo('Xóa tài sản'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['tai-sans.index', 'tai-sans.create', 'tai-sans.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('tai-sans.index') }}">
                     <i class="bi bi-cash-coin"></i>
                     <span>Tài sản</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem quản lý điện nước') || auth()->user()->hasPermissionTo('Thêm quản lý điện nước') || auth()->user()->hasPermissionTo('Sửa quản lý điện nước'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['diennuoc.index']) ? '' : 'collapsed' }}"
                     href="{{ route('diennuoc.index') }}">
                     <i class="bi bi-droplet"></i>
                     <span>Quản lý điện nước</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem vai trò', 'Xem tài khoản quản trị']))
             <li class="nav-heading">Phân quyền</li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem vai trò') || auth()->user()->hasPermissionTo('Thêm vai trò') || auth()->user()->hasPermissionTo('Sửa vai trò') || auth()->user()->hasPermissionTo('Xóa vai trò'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.roles.index', 'admin.roles.create', 'admin.roles.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.roles.index') }}">
                     <i class="bi bi-shield-lock"></i>
                     <span>Vai trò</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem tài khoản quản trị') || auth()->user()->hasPermissionTo('Thêm tài khoản quản trị') || auth()->user()->hasPermissionTo('Sửa tài khoản quản trị') || auth()->user()->hasPermissionTo('Xóa tài khoản quản trị'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.quanly.index']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.quanly.index') }}">
                     <i class="bi bi-person-circle"></i>
                     <span>Quản trị</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem người dùng', 'Xem hợp đồng', 'Xem hóa đơn']))
             <li class="nav-heading">Khách hàng</li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem người dùng') || auth()->user()->hasPermissionTo('Thêm người dùng') || auth()->user()->hasPermissionTo('Sửa người dùng') || auth()->user()->hasPermissionTo('Xóa người dùng'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.users.index', 'admin.users.create', 'admin.users.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.users.index') }}">
                     <i class="bi bi-person-circle"></i>
                     <span>Khách hàng</span>
                 </a>
             </li>
         @endif

         @if (auth()->user()->hasPermissionTo('Xem hợp đồng') || auth()->user()->hasPermissionTo('Thêm hợp đồng') || auth()->user()->hasPermissionTo('Sửa hợp đồng') || auth()->user()->hasPermissionTo('Xóa hợp đồng'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.hop_dong.index', 'admin.hop_dong.create', 'admin.hop_dong.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.hop_dong.index') }}">
                     <i class="bi bi-file-earmark"></i>
                     <span>Hợp đồng</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem hóa đơn', 'Thêm hóa đơn', 'Sửa hóa đơn', 'Xóa hóa đơn']))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['hoa-dons.index', 'hoa-dons.create', 'hoa-dons.edit', 'hoa-dons.show']) ? '' : 'collapsed' }}"
                     href="{{ route('hoa-dons.index') }}">
                     <i class="bi bi-file-earmark-text"></i>
                     <span>Hóa đơn</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem tin tức', 'Xem liên hệ', 'Xem chính sách', 'Xem slider', 'Xem cảm nghĩ', 'Cài đặt web', 'Về chúng tôi']))
             <li class="nav-heading">Hiện thị trang chủ</li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem tin tức', 'Thêm tin tức', 'Sửa tin tức', 'Xóa tin tức']))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['tin_tuc.index', 'tin_tuc.create', 'tin_tuc.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('tin_tuc.index') }}">
                     <i class="bi bi-newspaper"></i>
                     <span>Tin tức</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem liên hệ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['lien_he.index.admin']) ? '' : 'collapsed' }}"
                     href="{{ route('lien_he.index.admin') }}">
                     <i class="bi bi-person-lines-fill"></i>
                     <span>Liên hệ</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem chính sách') || auth()->user()->hasPermissionTo('Thêm chính sách') || auth()->user()->hasPermissionTo('Sửa chính sách') || auth()->user()->hasPermissionTo('Xóa chính sách'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['policies.index', 'policies.create', 'policies.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('policies.index') }}">
                     <i class="bi bi-file-earmark-text"></i>
                     <span>Chính sách</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem slider') || auth()->user()->hasPermissionTo('Thêm slider') || auth()->user()->hasPermissionTo('Sửa slider') || auth()->user()->hasPermissionTo('Xóa slider'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['sliders.index', 'sliders.create', 'sliders.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('sliders.index') }}">
                     <i class="bi bi-images me-2"></i>
                     <span>Sliders</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem cảm nghĩ') || auth()->user()->hasPermissionTo('Thêm cảm nghĩ') || auth()->user()->hasPermissionTo('Sửa cảm nghĩ') || auth()->user()->hasPermissionTo('Xóa cảm nghĩ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['feedbacks.index', 'feedbacks.create', 'feedbacks.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('feedbacks.index') }}">
                     <i class="bi bi-chat-left-text"></i>
                     <span>Cảm nghĩ</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Cài đặt web'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['web-config.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('web-config.edit') }}">
                     <i class="bi bi-gear"></i>
                     <span>Cài đặt web</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Về chúng tôi'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['about_us.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('about_us.edit') }}">
                     <i class="bi bi-people me-2"></i>
                     <span>Về chúng tôi</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission('Xem câu hỏi thường gặp', 'Sửa câu hỏi thường gặp', 'Xóa câu hỏi thường gặp', 'Thêm câu hỏi thường gặp'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.faqs.index', 'admin.faqs.create', 'admin.faqs.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.faqs.index') }}">
                     <i class="bi bi-question-circle me-2"></i>
                     <span>Câu hỏi thường gặp</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission('Xem dịch vụ về chúng tôi', 'Sửa dịch vụ về chúng tôi', 'Xóa dịch vụ về chúng tôi', 'Thêm dịch vụ về chúng tôi'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.service_about_home.index', 'admin.service_about_home.create', 'admin.service_about_home.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.service_about_home.index') }}">
                     <i class="bi bi-box-seam me-2"></i>
                     <span>Dịch vụ về chúng tôi</span>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission('Xem thành viên trang chủ', 'Sửa thành viên trang chủ', 'Xóa thành viên trang chủ', 'Thêm thành viên trang chủ'))
             <li class="nav-item">
                 <a class="nav-link {{ in_array(Request::route()->getName(), ['admin.members.index', 'admin.members.create', 'admin.members.edit']) ? '' : 'collapsed' }}"
                     href="{{ route('admin.members.index') }}">
                     <i class="bi bi-person-badge-fill me-2"></i>
                     <span>Thành viên trang chủ</span>
                 </a>
             </li>
         @endif

     </ul>

 </aside> --}}
 <aside id="layout-menu" class="layout-menu menu-vertical menu"
     style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

     <div class="app-brand demo ">
         <a href="#" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <span class="text-primary">

                    <img  width="35px" height="35px" src="{{asset(get_config()->logo ?? '/assets/img/icon_usser.png')}}" alt="">
                 </span>
             </span>
             <span class="app-brand-text demo menu-text fw-bold ms-2">{{ get_config()->site_name ?? 'Metasoftware' }}</span>
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
             <i class="icon-base bx bx-chevron-left"></i>
         </a>
     </div>


     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1 ps ps--active-y">
         <li class="menu-item {{ in_array(Request::route()->getName(), ['dashboard.index']) ? 'active' : '' }}">
             <a class="menu-link " href="{{ route('dashboard.index') }}">
                 <i class="menu-icon icon-base bx bx-home"></i>
                 <div>Dashboard</div>
             </a>
         </li>
         @if (auth()->user()->hasAnyPermission([
                     'Xem dịch vụ',
                     'Xem nhà trọ',
                     'Xem phòng trọ',
                     'Xem công tơ điện',
                     'Xem công tơ nước',
                     'Xem tài sản trọ',
                     'Xem tài sản',
                     'Xem quản lý điện nước',
                 ]))
             <li class="menu-header small">
                 <span class="menu-header-text" data-i18n="Quản lý vận hành">Quản lý vận hành</span>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem dịch vụ') ||
                 auth()->user()->hasPermissionTo('Thêm dịch vụ') ||
                 auth()->user()->hasPermissionTo('Sửa dịch vụ') ||
                 auth()->user()->hasPermissionTo('Xóa dịch vụ'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['dichvu.index', 'dichvus.create', 'dichvus.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('dichvu.index') }}">
                     <i class="menu-icon tf-icons bx bx-grid"></i>
                     <div>Dịch vụ</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem nhà trọ') ||
                 auth()->user()->hasPermissionTo('Thêm nhà trọ') ||
                 auth()->user()->hasPermissionTo('Sửa nhà trọ') ||
                 auth()->user()->hasPermissionTo('Xóa nhà trọ'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['nha_tro.index', 'nha_tro.create', 'nha_tro.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('nha_tro.index') }}">
                     <i class="menu-icon tf-icons bx bx-home-heart"></i>
                     <div>Nhà trọ</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem phòng trọ') ||
                 auth()->user()->hasPermissionTo('Thêm phòng trọ') ||
                 auth()->user()->hasPermissionTo('Sửa phòng trọ') ||
                 auth()->user()->hasPermissionTo('Xóa phòng trọ'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['rooms.index', 'rooms.create', 'rooms.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('rooms.index') }}">
                     <i class='bxr  bxs-door-open'></i>
                     <i class="menu-icon tf-icons bx bx-door-open"></i>
                     <div>Phòng trọ</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem công tơ điện') ||
                 auth()->user()->hasPermissionTo('Thêm công tơ điện') ||
                 auth()->user()->hasPermissionTo('Sửa công tơ điện') ||
                 auth()->user()->hasPermissionTo('Xóa công tơ điện'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['admin.cong_tos.dien.index', 'admin.cong_tos.dien.create', 'admin.cong_tos.dien.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('rooms.index') }}">
                     <i class="menu-icon tf-icons bx bxs-zap"></i>
                     <div>Công tơ điện</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem công tơ nước') ||
                 auth()->user()->hasPermissionTo('Thêm công tơ nước') ||
                 auth()->user()->hasPermissionTo('Sửa công tơ nước') ||
                 auth()->user()->hasPermissionTo('Xóa công tơ nước'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['admin.cong_tos.nuoc.index', 'admin.cong_tos.nuoc.create', 'admin.cong_tos.nuoc.edit']) ? '' : 'collapsed' }}">
                 <a class="menu-link " href="{{ route('admin.cong_tos.nuoc.index') }}">
                     <i class="menu-icon tf-icons bx bxs-droplet"></i>
                     <div>Công tơ nước</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem tài sản trọ') ||
                 auth()->user()->hasPermissionTo('Thêm tài sản trọ') ||
                 auth()->user()->hasPermissionTo('Sửa tài sản trọ') ||
                 auth()->user()->hasPermissionTo('Xóa tài sản trọ'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['tai_san_chung_riengs.index', 'tai_san_chung_riengs.create', 'tai_san_chung_riengs.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('tai_san_chung_riengs.index') }}">
                     <i class="menu-icon tf-icons bx bxs-dollar-circle"></i>
                     <div>Tài sản trọ</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem tài sản') ||
                 auth()->user()->hasPermissionTo('Thêm tài sản') ||
                 auth()->user()->hasPermissionTo('Sửa tài sản') ||
                 auth()->user()->hasPermissionTo('Xóa tài sản'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['tai-sans.index', 'tai-sans.create', 'tai-sans.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('tai-sans.index') }}">
                     <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                     <div>Tài sản</div>
                 </a>
             </li>
         @endif

       
         @if (auth()->user()->hasPermissionTo('Xem quản lý điện nước') ||
                 auth()->user()->hasPermissionTo('Thêm quản lý điện nước') ||
                 auth()->user()->hasPermissionTo('Sửa quản lý điện nước'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['diennuoc.index']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('diennuoc.index') }}">
                     <i class="menu-icon tf-icons bx bxl-redux"></i>
                     <div>Quản lý điện nước</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem vai trò', 'Xem tài khoản quản trị']))
             <li class="menu-header small">
                 <span class="menu-header-text" data-i18n="Phân quyền">Phân quyền</span>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem vai trò') ||
                 auth()->user()->hasPermissionTo('Thêm vai trò') ||
                 auth()->user()->hasPermissionTo('Sửa vai trò') ||
                 auth()->user()->hasPermissionTo('Xóa vai trò'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['admin.roles.index', 'admin.roles.create', 'admin.roles.edit']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('admin.roles.index') }}">
                     <i class="menu-icon tf-icons bx bxs-user"></i>
                     <div>Vai trò</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem tài khoản quản trị') ||
                 auth()->user()->hasPermissionTo('Thêm tài khoản quản trị') ||
                 auth()->user()->hasPermissionTo('Sửa tài khoản quản trị') ||
                 auth()->user()->hasPermissionTo('Xóa tài khoản quản trị'))
             <li
                 class="menu-item {{ in_array(Request::route()->getName(), ['admin.quanly.index']) ? 'active' : '' }}">
                 <a class="menu-link " href="{{ route('admin.quanly.index') }}">
                     <i class="menu-icon tf-icons bx bxs-briefcase"></i>
                     <div>Quản trị</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission(['Xem người dùng', 'Xem hợp đồng', 'Xem hóa đơn']))
             <li class="menu-header small">
                 <span class="menu-header-text" data-i18n="Khách hàng">Khách hàng</span>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem người dùng') ||
                 auth()->user()->hasPermissionTo('Thêm người dùng') ||
                 auth()->user()->hasPermissionTo('Sửa người dùng') ||
                 auth()->user()->hasPermissionTo('Xóa người dùng'))
             <li
                 class="menu-item  {{ in_array(Request::route()->getName(), ['admin.users.index', 'admin.users.create', 'admin.users.edit']) ? 'active' : '' }}">
                 <a class="menu-link" href="{{ route('admin.users.index') }}">
                     <i class="menu-icon tf-icons bx bx-user"></i>
                     <div>Khách hàng</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem hợp đồng') ||
                 auth()->user()->hasPermissionTo('Thêm hợp đồng') ||
                 auth()->user()->hasPermissionTo('Sửa hợp đồng') ||
                 auth()->user()->hasPermissionTo('Xóa hợp đồng'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['admin.hop_dong.index', 'admin.hop_dong.create', 'admin.hop_dong.edit']) ? 'active' : '' }}">
                 <a class="menu-link"
                     href="{{ route('admin.hop_dong.index') }}">
                     <i class="menu-icon tf-icons bx bx-file"></i>
                     <div>Hợp đồng</div>
                 </a>
             </li>
         @endif
          @if (auth()->user()->hasAnyPermission(['Xem hóa đơn', 'Thêm hóa đơn', 'Sửa hóa đơn', 'Xóa hóa đơn']))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['hoa-dons.index', 'hoa-dons.create', 'hoa-dons.edit', 'hoa-dons.show']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('hoa-dons.index') }}">
                     <i class="menu-icon tf-icons bx bx-receipt"></i>
                     <div>Hóa đơn</div>
                 </a>
             </li>
         @endif
           @if (auth()->user()->hasAnyPermission(['Xem tin tức', 'Xem liên hệ', 'Xem chính sách', 'Xem slider', 'Xem cảm nghĩ', 'Cài đặt web', 'Về chúng tôi']))
            <li class="menu-header small">
                 <span class="menu-header-text" data-i18n="Hiện thị trang chủ">Hiện thị trang chủ</span>
             </li>
         @endif
          @if (auth()->user()->hasAnyPermission(['Xem tin tức', 'Thêm tin tức', 'Sửa tin tức', 'Xóa tin tức']))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['tin_tuc.index', 'tin_tuc.create', 'tin_tuc.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('tin_tuc.index') }}">
                     <i class="menu-icon tf-icons bx bx-news"></i>
                     <div>Tin tức</div>
                 </a>
             </li>
         @endif
          @if (auth()->user()->hasPermissionTo('Xem liên hệ'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['lien_he.index.admin']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('lien_he.index.admin') }}">
                     <i class="menu-icon tf-icons bx bx-envelope"></i>
                     <div>Liên hệ</div>
                 </a>
             </li>
         @endif
          @if (auth()->user()->hasPermissionTo('Xem chính sách') || auth()->user()->hasPermissionTo('Thêm chính sách') || auth()->user()->hasPermissionTo('Sửa chính sách') || auth()->user()->hasPermissionTo('Xóa chính sách'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['policies.index', 'policies.create', 'policies.edit']) ? 'acitve' : '' }}">
                 <a class="menu-link "
                     href="{{ route('policies.index') }}">
                     <i class="menu-icon tf-icons bx bx-book"></i>
                     <div>Chính sách</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem slider') || auth()->user()->hasPermissionTo('Thêm slider') || auth()->user()->hasPermissionTo('Sửa slider') || auth()->user()->hasPermissionTo('Xóa slider'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['sliders.index', 'sliders.create', 'sliders.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('sliders.index') }}">
                     <i class="menu-icon tf-icons bx bx-slideshow"></i>
                     <div>Sliders</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Xem cảm nghĩ') || auth()->user()->hasPermissionTo('Thêm cảm nghĩ') || auth()->user()->hasPermissionTo('Sửa cảm nghĩ') || auth()->user()->hasPermissionTo('Xóa cảm nghĩ'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['feedbacks.index', 'feedbacks.create', 'feedbacks.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('feedbacks.index') }}">
                     <i class="menu-icon tf-icons bx bx-comment"></i>
                     <div>Cảm nghĩ</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Cài đặt web'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['web-config.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('web-config.edit') }}">
                     <i class="menu-icon tf-icons bx bx-cog"></i>
                     <div>Cài đặt web</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasPermissionTo('Về chúng tôi'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['about_us.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('about_us.edit') }}">
                     <i class="menu-icon tf-icons bx bx-info-circle"></i>
                     <div>Về chúng tôi</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission('Xem câu hỏi thường gặp', 'Sửa câu hỏi thường gặp', 'Xóa câu hỏi thường gặp', 'Thêm câu hỏi thường gặp'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['admin.faqs.index', 'admin.faqs.create', 'admin.faqs.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('admin.faqs.index') }}">
                     <i class="menu-icon tf-icons bx bx-help-circle"></i>
                     <div>Câu hỏi thường gặp</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission('Xem dịch vụ về chúng tôi', 'Sửa dịch vụ về chúng tôi', 'Xóa dịch vụ về chúng tôi', 'Thêm dịch vụ về chúng tôi'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['admin.service_about_home.index', 'admin.service_about_home.create', 'admin.service_about_home.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('admin.service_about_home.index') }}">
                     <i class="menu-icon tf-icons bx bx-briefcase"></i>
                     <div>Dịch vụ về chúng tôi</div>
                 </a>
             </li>
         @endif
         @if (auth()->user()->hasAnyPermission('Xem thành viên trang chủ', 'Sửa thành viên trang chủ', 'Xóa thành viên trang chủ', 'Thêm thành viên trang chủ'))
             <li class="menu-item {{ in_array(Request::route()->getName(), ['admin.members.index', 'admin.members.create', 'admin.members.edit']) ? 'active' : '' }}">
                 <a class="menu-link "
                     href="{{ route('admin.members.index') }}">
                     <i class="menu-icon tf-icons bx bx-group"></i>
                     <div>Thành viên trang chủ</div>
                 </a>
             </li>
         @endif
     </ul>


 </aside>
