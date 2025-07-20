<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from bootstrapmade.com/content/demo/NiceAdmin/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Jun 2025 04:55:42 GMT -->

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="https://bootstrapmade.com/content/demo/NiceAdmin/assets/img/favicon.png" rel="icon">
    <link href="https://bootstrapmade.com/content/demo/NiceAdmin/assets/img/apple-touch-icon.png"
        rel="apple-touch-icon">

 

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



    <!-- Theme Bootstrap 5 -->
    <link href="{{ asset('/assets/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />

</head>

<body>

    <!-- ======= Header ======= -->
    @include('admin.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">
        @yield('contentadmin')
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('admin.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    {{-- <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script> --}}

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Toastr JS -->
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
    
    <script type="text/javascript">
        tinymce.init({
            selector: '#tyni',
            plugins: 'advlist autolink lists link charmap preview anchor table image',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | table | link image | blocks fontfamily fontsize',
            images_upload_url: "/upload-image",
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
                        fetch('/delete-image', {
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
            // === PHẦN CROP ẢNH ===
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const croppedImageInput = document.getElementById('croppedImage');
            if (imageInput && previewImage && croppedImageInput) {

                // 🟢 Khai báo trước
                let cropper;

                if (imageInput && previewImage && croppedImageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = function(event) {
                            previewImage.src = event.target.result;
                            previewImage.style.display = 'block';

                            // 🟢 Biến cropper đã được khai báo trước, nên có thể gọi
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

            // === PHẦN CHỌN TỈNH/QUẬN/XÃ ===
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



</html>
