{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ get_config()->site_name ?? 'Metasorft' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="{{ get_config()->meta_description ?? 'deaacription' }}" name="description">
    <meta content="{{ get_config()->meta_keywords ?? 'deaacription' }}" name="keywords">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset(get_config()->favicon_16 ?? 'assets/img/icon_usser.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset(get_config()->favicon_32 ?? 'assets/img/icon_usser.png') }}">


    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/cropper.min.css') }}" rel="stylesheet" />


    <link href="{{ asset('/assets/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />

</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <main id="main" class="main">
        @yield('contentadmin')
    </main>

    @include('admin.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>



    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('/assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('/assets/js/toastr.min.js') }}"></script>



    <script type="text/javascript" src="{{ asset('/assets/js/monment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
    <script src="{{ asset('/assets/js/style.js') }}"></script>
    <script src="{{ asset('/assets/js/cropper.min.js') }}"></script>
    <script src="{{ asset('/source/tinymce/tinymce.min.js') }}"></script>
    @if (session('generation_status'))
        <script>
            // Đảm bảo rằng đoạn mã này chạy sau khi DOM đã sẵn sàng
            document.addEventListener('DOMContentLoaded', function() {
             
                const status = @json(session('generation_status'));

                // Cấu hình chung cho Toastr (tùy chọn)
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": 5000, // 5 giây cho thông báo tóm tắt
                };

                // 1. Hiển thị TOAST TÓM TẮT
                // Tin nhắn chính là tiêu đề, còn phần tóm tắt là nội dung
                toastr.success(
                    `Thành công: ${status.success_count} hóa đơn.<br>Bỏ qua: ${status.skipped_count} phòng.`,
                    status.message // "Tạo hóa đơn hoàn tất cho tháng 8/2023!"
                );

                // 2. Nếu có lỗi, hiển thị TOAST CHI TIẾT
                if (status.skipped_count > 0 && status.errors) {
                    // Xây dựng chuỗi HTML chứa danh sách lỗi
                    let errorDetailsHtml = '<ul>';
                    // Lặp qua đối tượng lỗi
                    for (const [roomName, reason] of Object.entries(status.errors)) {
                        errorDetailsHtml += `<li><strong>${roomName}:</strong> ${reason}</li>`;
                    }
                    errorDetailsHtml += '</ul>';

                    // Hiển thị toast cảnh báo với các tùy chọn đặc biệt
                    toastr.warning(errorDetailsHtml, "Chi tiết các phòng đã bỏ qua", {
                        "timeOut": 7000, // 0 = không tự động đóng
                        "extendedTimeOut": 0, // 0 = không tự động đóng khi hover
                        "escapeHtml": false, // QUAN TRỌNG: Cho phép hiển thị HTML
                        "closeButton": true,
                        "tapToDismiss": false
                    });
                }
            });
        </script>
    @endif
    <script type="text/javascript">
        tinymce.init({
            selector: '#tyni',
            plugins: 'advlist autolink lists link charmap preview anchor table image',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | table | link image | blocks fontfamily fontsize',
            images_upload_url: "/admin/upload-image",
            relative_urls: false,
            document_base_url: "{{ url('/') }}",
            automatic_uploads: true,
            setup: function(editor) {
                editor.on('NodeChange', function(event) {
                    const currentImages = Array.from(editor.getDoc().querySelectorAll('img')).map(img =>
                        img.src);

                    if (!editor.oldImages) editor.oldImages = currentImages;

                    const removedImages = editor.oldImages.filter(img => !currentImages.includes(img));
                    editor.oldImages = currentImages;

                    removedImages.forEach(imageUrl => {
                        fetch('admin/delete-image', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    image: imageUrl
                                })
                            })
                            .then(response => response.json())
                            .then(data => console.log(data.message))
                            .catch(error => console.error('Lỗi khi xóa ảnh:', error));
                    });
                });
            }
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
  
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const croppedImageInput = document.getElementById('croppedImage');
            if (imageInput && previewImage && croppedImageInput) {

                let cropper;

                if (imageInput && previewImage && croppedImageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            previewImage.src = event.target.result;
                            previewImage.style.display = 'block';


                            if (cropper) cropper.destroy();

                            cropper = new Cropper(previewImage, {
                                aspectRatio: 16 / 9,
                                viewMode: 1,
                                autoCropArea: 1,
                                cropend() {
                                    const canvas = cropper.getCroppedCanvas({
                                        width: 1280,
                                        height: 720,
                                    });
                                    croppedImageInput.value = canvas.toDataURL('image/png');
                                }
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }

            const provinceSelect = document.getElementById('province-select');
            const districtSelect = document.getElementById('district-select');
            const wardSelect = document.getElementById('ward-select');

            if (provinceSelect && districtSelect && wardSelect) {
                let provinceData = [];

                function populateSelect(selectElement, items, defaultOptionText) {
                    selectElement.innerHTML = `<option value="">-- ${defaultOptionText} --</option>`;
                    items.forEach(item => {
                        const option = new Option(item.name, item.name);
                        selectElement.add(option);
                    });
                }

                fetch("{{ asset('data/tinh_thanh.json') }}")
                    .then(response => response.json())
                    .then(data => {
                        provinceData = data;
                        populateSelect(provinceSelect, provinceData, 'Chọn Tỉnh/Thành phố');

                        const oldProvince = provinceSelect.getAttribute('data-old');
                        if (oldProvince) {
                            provinceSelect.value = oldProvince;
                            provinceSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => console.error('Lỗi khi tải dữ liệu tỉnh thành:', error));

                provinceSelect.addEventListener('change', function() {
                    const selectedProvinceName = this.value;
                    districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
                    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                    districtSelect.disabled = true;
                    wardSelect.disabled = true;

                    if (selectedProvinceName) {
                        const selectedProvince = provinceData.find(p => p.name === selectedProvinceName);
                        if (selectedProvince && selectedProvince.districts) {
                            populateSelect(districtSelect, selectedProvince.districts, 'Chọn Quận/Huyện');
                            districtSelect.disabled = false;

                            const oldDistrict = districtSelect.getAttribute('data-old');
                            if (oldDistrict) {
                                districtSelect.value = oldDistrict;
                                districtSelect.dispatchEvent(new Event('change'));
                            }
                        }
                    }
                });

                districtSelect.addEventListener('change', function() {
                    const selectedProvinceName = provinceSelect.value;
                    const selectedDistrictName = this.value;

                    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                    wardSelect.disabled = true;

                    if (selectedDistrictName) {
                        const selectedProvince = provinceData.find(p => p.name === selectedProvinceName);
                        const selectedDistrict = selectedProvince?.districts.find(d => d.name ===
                            selectedDistrictName);
                        if (selectedDistrict && selectedDistrict.wards) {
                            populateSelect(wardSelect, selectedDistrict.wards, 'Chọn Phường/Xã');
                            wardSelect.disabled = false;

                            const oldWard = wardSelect.getAttribute('data-old');
                            if (oldWard) {
                                wardSelect.value = oldWard;
                                wardSelect.removeAttribute('data-old');
                                districtSelect.removeAttribute('data-old');
                                provinceSelect.removeAttribute('data-old');
                            }
                        }
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>



</html> --}}


<!DOCTYPE html>
<html lang="vi" class="layout-menu-fixed layout-compact layout-menu-100vh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/admin/css/iconify-icons.css') }}" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/cropper.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/assets/css/toastr.min.css') }}" rel="stylesheet">

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('/admin/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/css/demo.css') }}" />
<link href="{{ asset('/assets/css/select2.min.css') }}" rel="stylesheet" />
    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('/admin/css/perfect-scrollbar.css') }}" />
 <link href="{{ asset('/assets/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('/admin/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('/admin/js/config.js') }}"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('admin.sidebar')

            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('admin.header')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Layout Demo -->
                        @yield('contentadmin')
                        <!--/ Layout Demo -->
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by
                                    <a href="https://themeselection.com" target="_blank"
                                        class="footer-link">ThemeSelection</a>
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="https://themeselection.com/item/category/admin-templates/" target="_blank"
                                        class="footer-link me-4">Admin Templates</a>

                                    <a href="https://themeselection.com/license/" class="footer-link me-4"
                                        target="_blank">License</a>
                                    <a href="https://themeselection.com/item/category/bootstrap-admin-templates/"
                                        target="_blank" class="footer-link me-4">Bootstrap Dashboard</a>

                                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                                        target="_blank" class="footer-link me-4">Documentation</a>

                                    <a href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free/issues"
                                        target="_blank" class="footer-link">Support</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle">

        </div>
    </div>
    <script src="{{ asset('/admin/js/jquery.js') }}"></script>

    <script src="{{ asset('/admin/js/popper.js') }}"></script>
    <script src="{{ asset('/admin/js/bootstrap.js') }}"></script>

    <script src="{{ asset('/admin/js/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('/admin/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{ asset('/admin/js/main.js') }}"></script>
    <script src="{{ asset('/assets/js/toastr.min.js') }}"></script>



    <script type="text/javascript" src="{{ asset('/assets/js/monment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.min.js') }}"></script>
    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
    <script src="{{ asset('/assets/js/style.js') }}"></script>
    <script src="{{ asset('/assets/js/cropper.min.js') }}"></script>
    <script src="{{ asset('/source/tinymce/tinymce.min.js') }}"></script>
    @if (session('generation_status'))
        <script>
            // Đảm bảo rằng đoạn mã này chạy sau khi DOM đã sẵn sàng
            document.addEventListener('DOMContentLoaded', function() {

                const status = @json(session('generation_status'));

                // Cấu hình chung cho Toastr (tùy chọn)
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": 5000, // 5 giây cho thông báo tóm tắt
                };

                // 1. Hiển thị TOAST TÓM TẮT
                // Tin nhắn chính là tiêu đề, còn phần tóm tắt là nội dung
                toastr.success(
                    `Thành công: ${status.success_count} hóa đơn.<br>Bỏ qua: ${status.skipped_count} phòng.`,
                    status.message // "Tạo hóa đơn hoàn tất cho tháng 8/2023!"
                );

                // 2. Nếu có lỗi, hiển thị TOAST CHI TIẾT
                if (status.skipped_count > 0 && status.errors) {
                    // Xây dựng chuỗi HTML chứa danh sách lỗi
                    let errorDetailsHtml = '<ul>';
                    // Lặp qua đối tượng lỗi
                    for (const [roomName, reason] of Object.entries(status.errors)) {
                        errorDetailsHtml += `<li><strong>${roomName}:</strong> ${reason}</li>`;
                    }
                    errorDetailsHtml += '</ul>';

                    // Hiển thị toast cảnh báo với các tùy chọn đặc biệt
                    toastr.warning(errorDetailsHtml, "Chi tiết các phòng đã bỏ qua", {
                        "timeOut": 7000, // 0 = không tự động đóng
                        "extendedTimeOut": 0, // 0 = không tự động đóng khi hover
                        "escapeHtml": false, // QUAN TRỌNG: Cho phép hiển thị HTML
                        "closeButton": true,
                        "tapToDismiss": false
                    });
                }
            });
        </script>
    @endif
    <script type="text/javascript">
        tinymce.init({
            selector: '#tyni',
            plugins: 'advlist autolink lists link charmap preview anchor table image',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | table | link image | blocks fontfamily fontsize',
            images_upload_url: "/admin/upload-image",
            relative_urls: false,
            document_base_url: "{{ url('/') }}",
            automatic_uploads: true,
            setup: function(editor) {
                editor.on('NodeChange', function(event) {
                    const currentImages = Array.from(editor.getDoc().querySelectorAll('img')).map(img =>
                        img.src);

                    if (!editor.oldImages) editor.oldImages = currentImages;

                    const removedImages = editor.oldImages.filter(img => !currentImages.includes(img));
                    editor.oldImages = currentImages;

                    removedImages.forEach(imageUrl => {
                        fetch('admin/delete-image', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    image: imageUrl
                                })
                            })
                            .then(response => response.json())
                            .then(data => console.log(data.message))
                            .catch(error => console.error('Lỗi khi xóa ảnh:', error));
                    });
                });
            }
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const croppedImageInput = document.getElementById('croppedImage');
            if (imageInput && previewImage && croppedImageInput) {

                let cropper;

                if (imageInput && previewImage && croppedImageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            previewImage.src = event.target.result;
                            previewImage.style.display = 'block';


                            if (cropper) cropper.destroy();

                            cropper = new Cropper(previewImage, {
                                aspectRatio: 16 / 9,
                                viewMode: 1,
                                autoCropArea: 1,
                                cropend() {
                                    const canvas = cropper.getCroppedCanvas({
                                        width: 1280,
                                        height: 720,
                                    });
                                    croppedImageInput.value = canvas.toDataURL('image/png');
                                }
                            });
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }

            const provinceSelect = document.getElementById('province-select');
            const districtSelect = document.getElementById('district-select');
            const wardSelect = document.getElementById('ward-select');

            if (provinceSelect && districtSelect && wardSelect) {
                let provinceData = [];

                function populateSelect(selectElement, items, defaultOptionText) {
                    selectElement.innerHTML = `<option value="">-- ${defaultOptionText} --</option>`;
                    items.forEach(item => {
                        const option = new Option(item.name, item.name);
                        selectElement.add(option);
                    });
                }

                fetch("{{ asset('data/tinh_thanh.json') }}")
                    .then(response => response.json())
                    .then(data => {
                        provinceData = data;
                        populateSelect(provinceSelect, provinceData, 'Chọn Tỉnh/Thành phố');

                        const oldProvince = provinceSelect.getAttribute('data-old');
                        if (oldProvince) {
                            provinceSelect.value = oldProvince;
                            provinceSelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => console.error('Lỗi khi tải dữ liệu tỉnh thành:', error));

                provinceSelect.addEventListener('change', function() {
                    const selectedProvinceName = this.value;
                    districtSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
                    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                    districtSelect.disabled = true;
                    wardSelect.disabled = true;

                    if (selectedProvinceName) {
                        const selectedProvince = provinceData.find(p => p.name === selectedProvinceName);
                        if (selectedProvince && selectedProvince.districts) {
                            populateSelect(districtSelect, selectedProvince.districts, 'Chọn Quận/Huyện');
                            districtSelect.disabled = false;

                            const oldDistrict = districtSelect.getAttribute('data-old');
                            if (oldDistrict) {
                                districtSelect.value = oldDistrict;
                                districtSelect.dispatchEvent(new Event('change'));
                            }
                        }
                    }
                });

                districtSelect.addEventListener('change', function() {
                    const selectedProvinceName = provinceSelect.value;
                    const selectedDistrictName = this.value;

                    wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                    wardSelect.disabled = true;

                    if (selectedDistrictName) {
                        const selectedProvince = provinceData.find(p => p.name === selectedProvinceName);
                        const selectedDistrict = selectedProvince?.districts.find(d => d.name ===
                            selectedDistrictName);
                        if (selectedDistrict && selectedDistrict.wards) {
                            populateSelect(wardSelect, selectedDistrict.wards, 'Chọn Phường/Xã');
                            wardSelect.disabled = false;

                            const oldWard = wardSelect.getAttribute('data-old');
                            if (oldWard) {
                                wardSelect.value = oldWard;
                                wardSelect.removeAttribute('data-old');
                                districtSelect.removeAttribute('data-old');
                                provinceSelect.removeAttribute('data-old');
                            }
                        }
                    }
                });
            }
        });
    </script>
    
      @if (session('generation_status'))
        <script>
            // Đảm bảo rằng đoạn mã này chạy sau khi DOM đã sẵn sàng
            document.addEventListener('DOMContentLoaded', function() {
             
                const status = @json(session('generation_status'));

                // Cấu hình chung cho Toastr (tùy chọn)
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": 5000, // 5 giây cho thông báo tóm tắt
                };

                // 1. Hiển thị TOAST TÓM TẮT
                // Tin nhắn chính là tiêu đề, còn phần tóm tắt là nội dung
                toastr.success(
                    `Thành công: ${status.success_count} hóa đơn.<br>Bỏ qua: ${status.skipped_count} phòng.`,
                    status.message // "Tạo hóa đơn hoàn tất cho tháng 8/2023!"
                );

                // 2. Nếu có lỗi, hiển thị TOAST CHI TIẾT
                if (status.skipped_count > 0 && status.errors) {
                    // Xây dựng chuỗi HTML chứa danh sách lỗi
                    let errorDetailsHtml = '<ul>';
                    // Lặp qua đối tượng lỗi
                    for (const [roomName, reason] of Object.entries(status.errors)) {
                        errorDetailsHtml += `<li><strong>${roomName}:</strong> ${reason}</li>`;
                    }
                    errorDetailsHtml += '</ul>';

                    // Hiển thị toast cảnh báo với các tùy chọn đặc biệt
                    toastr.warning(errorDetailsHtml, "Chi tiết các phòng đã bỏ qua", {
                        "timeOut": 7000, // 0 = không tự động đóng
                        "extendedTimeOut": 0, // 0 = không tự động đóng khi hover
                        "escapeHtml": false, // QUAN TRỌNG: Cho phép hiển thị HTML
                        "closeButton": true,
                        "tapToDismiss": false
                    });
                }
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
