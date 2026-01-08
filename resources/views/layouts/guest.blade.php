<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>biiproject - Login</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Outfit:wght@600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <script defer src="{{ asset('assets/js/app.js') }}"></script>
    <style>
    :root {
        --adminuiux-content-font: "Open Sans", sans-serif;
        --adminuiux-title-font: "Outfit", sans-serif;
    }
    </style>
    <style>
    .pageloader {
        background: #262e38 !important;
        backdrop-filter: blur(0.5px);
    }

    .btn-primary {
        --bs-btn-color: #fff !important;
        --bs-btn-bg: #1e1e1e !important;
        --bs-btn-border-color: #1e1e1e !important;
        --bs-btn-hover-color: #fff !important;
        --bs-btn-hover-bg: #1e1e1e !important;
        --bs-btn-hover-border-color: #1e1e1e !important;
        --bs-btn-focus-shadow-rgb: 49, 132, 253 !important;
        --bs-btn-active-color: #fff !important;
        --bs-btn-active-bg: #1e1e1e !important;
        --bs-btn-active-border-color: #1e1e1e !important;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, .125) !important;
        --bs-btn-disabled-color: #fff !important;
        --bs-btn-disabled-bg: #1e1e1e !important;
        --bs-btn-disabled-border-color: #1e1e1e !important;
    }

    .text-primary {
        --bs-text-opacity: 1;
        color: #1e1e1e !important;
    }
    </style>
</head>

<body
    class="main-bg main-bg-opac roundedui adminuiux-header-boxed adminuiux-header-transparent adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-black bg-gradient-1 scrollup"
    data-theme="theme-black">
    {{-- page loader --}}
    <div class="pageloader">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center text-center h-100">
                <div class="col-12 mb-auto pt-4"></div>
                <div class="col-auto">
                    <div class="loader5 mb-2 mx-auto"></div>
                </div>
                <div class="col-12 mt-auto pb-4">
                    <p class="text-secondary">Please wait for awesome things...</p>
                </div>
            </div>
        </div>
    </div>
    <header class="adminuiux-header">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a href="{{ url('/') }}" class="btn btn-square btn-link text-white me-2"><i
                        class="bi bi-arrow-left"></i></a>
            </div>
        </nav>
    </header>

    <div class="adminuiux-wrap z-index-0 position-relative bg-theme-1 ">
        <figure class="position-absolute top-0 start-0 w-100 h-100 coverimg z-index-0">
            <img style="-webkit-filter: invert(1);filter: invert(1);"
                src="{{ asset('assets/img/background-image/bg1.png') }}" alt="">
        </figure>
        <main class="adminuiux-content z-index-1 position-relative animate__animated animate__pulse animate__slower">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center mt-auto z-index-1 height-dynamic"
                    style="--h-dynamic: calc(100vh - 60px)">
                    <div class="col login-box maxwidth-400 text-dark pb-ios">

                        {{ $slot }}

                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- page js --}}
    <script src="assets/js/mobileux/mobileux-auth.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false,
    });
    </script>
    @endif

    @if (session('info'))
    <script>
    Swal.fire({
        icon: 'info',
        title: 'Notice',
        text: "{{ session('info') }}",
        timer: 2000,
        showConfirmButton: false,
    });
    </script>
    @endif

    @if (session('error'))
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('error') }}",
    });
    </script>
    @endif

</body>

</html>