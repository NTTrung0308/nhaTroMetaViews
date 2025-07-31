<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

    <div class="floating-buttons">
        <button class="floating-btn back-to-top" onclick="topFunction()" title="Back to top" aria-label="Back to top">
            <i class="bi bi-arrow-up"></i>
        </button>

        <div class="btn-group">
            <div class="floating-btn sub-btn" title="Option 1"><i class="bi bi-messenger"></i></div>
            <div class="floating-btn sub-btn" title="Option 2"><i class="bi bi-whatsapp"></i></div>
            <div class="floating-btn sub-btn" title="Option 3"><i class="bi bi-chat-text"></i></div>
            <div class="floating-btn main-btn" id="mainBtn" aria-label="Toggle menu"><i class="bi bi-plus-lg"></i>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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