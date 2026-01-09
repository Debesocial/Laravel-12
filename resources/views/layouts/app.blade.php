<!DOCTYPE html>
<html lang="en">

<head>
    {{-- meta --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $app_name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    {{-- font --}}
    @vite(['resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Outfit:wght@300;500;600;700&display=swap"
        rel="stylesheet">

    {{-- custom root --}}
    <style>
    :root {
        --adminuiux-content-font: "Open Sans", sans-serif;
        --adminuiux-title-font: "Outfit", sans-serif;
    }

    .card {
        background-color: #ffffff8f !important;
    }

    .markdown-body {
        font-size: 15px;
        line-height: 1.6;
        font-family: var(--adminuiux-content-font);
    }

    .swal2-popup {
        border-radius: 30px !important;
        padding: 2rem 2.2rem !important;
    }

    .swal2-cancel {
        background: transparent !important;
        color: #1e1e1e !important;
        border: 2px solid #1e1e1e !important;
        font-weight: 600;
        border-radius: 8px !important;
    }

    .swal2-cancel:hover {
        background: #eee !important;
        color: #000 !important;
    }

    .swal2-confirm {
        border-radius: 8px !important;
        font-weight: 600 !important;
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

    .dt-buttons {
        float: right !important;
    }

    div.dt-button-collection {
        border-radius: 12px;
        padding: 6px;
    }

    div.dt-button-collection button.dt-button {
        font-size: 14px;
        line-height: 1.3;
    }
    
    .permission-clamp {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .permission-clamp .badge {
        margin-right: 4px;
        margin-bottom: 2px;
    }
    </style>

    {{-- apps css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    {{-- markdown --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/5.2.0/github-markdown.min.css">

    {{-- datatables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body
    class="main-bg main-bg-opac roundedui adminuiux-header-boxed adminuiux-header-transparent adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-black bg-gradient-1 scrollup"
    data-theme="theme-black" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll"
    data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0"
    data-sidebarlayout="adminuiux-sidebar-boxed" data-headerlayout="adminuiux-header-standard"
    data-headerfill="adminuiux-header-transparent" data-bggradient="bg-gradient-1">

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

    {{-- header --}}
    <header class="adminuiux-header">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                {{-- sidebar toggle --}}
                <button class="btn btn-link btn-square sidebar-toggler" type="button" onclick="initSidebar()">
                    <i class="sidebar-svg" data-feather="menu"></i>
                </button>
                {{-- logo --}}
                <a class="navbar-brand" href="#">
                    <div class="d-block ps-2">
                        <h6 class="mb-1">{{ $app_name }}</h6>
                        <p class="company-tagline">{{ $app_tagline }}</p>
                    </div>
                </a>
                {{-- right icons --}}
                <div class="ms-auto">
                    <button class="btn btn-link btn-square btnsunmoon btn-link-header" id="btn-layout-modes-dark-page">
                        <i class="sun mx-auto" data-feather="sun"></i>
                        <i class="moon mx-auto" data-feather="moon"></i>
                    </button>
                    <div class="dropdown d-none d-sm-inline-block">
                        <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-translate"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" data-value="EN">EN - English</a></li>
                            <li><a class="dropdown-item" data-value="ID">ID - Indonesia</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-link btn-square btn-icon btn-link-header position-relative"
                        data-bs-toggle="offcanvas">
                        <i data-feather="bell"></i>
                        <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger p-1">
                            <small>9+</small>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    @include('layouts.navigation')

    {{-- page content --}}
    <main class="adminuiux-content has-sidebar " onclick="contentClick()">
        {{ $slot }}
    </main>

    {{-- notification --}}
    <div class="offcanvas offcanvas-end shadow border-0 maxwidth-300 pt-ios" tabindex="-1" id="view-notification"
        data-bs-scroll="true">
        <div class="offcanvas-header">
            <div class="flex-grow-1">
                <h6 class="mb-0">Notifications</h6>
                <p class="small text-secondary">6 new updates</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="small text-center px-3 pb-2">
            <div class="input-group">
                <input type="text" class="form-control" id="daterangepicker" />
                <span class="input-group-text text-secondary">
                    <i class="bi bi-calendar-week"></i>
                </span>
            </div>
        </div>
        <div class="offcanvas-body px-0 pb-ios">
            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    <div class="row gx-3">
                        <div class="col-auto">
                            <figure class="avatar avatar-30 coverimg rounded-circle">
                                <img src="assets/img/mobileux/user-f-3.jpeg" alt="" />
                            </figure>
                        </div>
                        <div class="col">
                            <p class="small mb-2">
                                <a href="mobileux-profile.html">Alex Smith</a>,
                                <a href="mobileux-profile.html">John McMillan</a> and
                                <span class="fw-medium">36 others</span> are also ordered from
                                same website
                            </p>

                            <div class="row gx-3 gx-lg-4 align-items-center">
                                <div class="col">
                                    <p class="text-secondary small">2:14 pm</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-square btn-link theme-red"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row gx-3">
                        <div class="col-auto">
                            <figure class="avatar avatar-30 rounded-circle bg-theme-1 border border-theme-1">
                                <p class="h6 fw-medium">JM</p>
                            </figure>
                        </div>
                        <div class="col">
                            <p class="small mb-2">
                                <a href="mobileux-profile.html">Jack Mario</a> commented:
                                "This one is most usable design with great user experience.
                                w..."
                            </p>

                            <div class="row gx-3 gx-lg-4 align-items-center">
                                <div class="col">
                                    <p class="text-secondary small">2 days ago</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-square btn-link theme-red"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item bg-theme-1-subtle theme-yellow">
                    <div class="row gx-3">
                        <div class="col-auto">
                            <figure class="avatar avatar-30 rounded-circle bg-warning text-white">
                                <i class="bi bi-bell"></i>
                            </figure>
                        </div>
                        <div class="col">
                            <p class="small mb-2">
                                Your subscription going to expire soon. Please
                                <a href="mobileux-subscription.html">upgrade</a> to get
                                service interrupt free.
                            </p>

                            <div class="row gx-3 gx-lg-4 align-items-center">
                                <div class="col">
                                    <p class="text-secondary small">4 days ago</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-square btn-link theme-red"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row gx-3">
                        <div class="col-auto">
                            <figure class="avatar avatar-30 coverimg rounded-circle">
                                <img src="assets/img/mobileux/user-m-2.jpeg" alt="" />
                            </figure>
                        </div>
                        <div class="col">
                            <p class="small mb-2">
                                <a href="mobileux-invoices.html">Roberto Carlos</a> has
                                requested to send $120.00 money.
                            </p>

                            <div class="row gx-3 gx-lg-4 align-items-center">
                                <div class="col">
                                    <p class="text-secondary small">6 days ago</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-square btn-link theme-red"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-30 rounded-circle bg-theme-1-subtle text-theme-1 theme-orange">
                                <i class="bi bi-calendar-event"></i>
                            </figure>
                        </div>
                        <div class="col ps-0">
                            <h6 class="mb-1">Adminuiux: #1 HTML Templates</h6>
                            <p class="small mb-2">
                                Learning for better user experience on Universal app.
                                development
                            </p>
                            <div class="avatar-group mb-2">
                                <figure class="avatar avatar-20 coverimg rounded-circle" data-bs-toggle="tooltip"
                                    title="Mickey">
                                    <img src="assets/img/mobileux/user-m-3.jpeg" alt="" style="display: none" />
                                </figure>
                                <figure class="avatar avatar-20 coverimg rounded-circle" data-bs-toggle="tooltip"
                                    title="Jacky">
                                    <img src="assets/img/mobileux/user-f-4.jpeg" alt="" />
                                </figure>
                                <div class="avatar avatar-20 bg-theme-1 rounded-circle">
                                    <small class="fs-10 vm">9+</small>
                                </div>
                                <span class="text-secondary small"> are attending</span>
                            </div>

                            <div class="row gx-3 gx-lg-4 align-items-center">
                                <div class="col">
                                    <p class="text-secondary small">7 days ago</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-square btn-link theme-red"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-30 coverimg rounded-circle">
                                <img src="assets/img/mobileux/user-m-3.jpeg" alt="" />
                            </figure>
                        </div>
                        <div class="col ps-0">
                            <p class="small mb-2">
                                <a href="profile.html">The AdminUIUX</a> commented: "Thank you
                                so much for this deep view at Adminuiux..."
                            </p>

                            <div class="row gx-3 gx-lg-4 align-items-center">
                                <div class="col">
                                    <p class="text-secondary small">1 year ago</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-square btn-link theme-red"><i
                                            class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- page footer --}}
    {{-- footer --}}
    <footer class="adminuiux-footer has-adminuiux-sidebar mt-auto">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md col-lg py-3">
                    <span class="small">
                        {{ $footer_text }}
                    </span>
                </div>
                <div class="col-12 col-md-auto col-lg-auto align-self-center">
                    <ul class="nav small">
                        <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                        <li class="nav-item">|</li>
                        <li class="nav-item"><a class="nav-link" href="#">Terms of Use</a></li>
                        <li class="nav-item">|</li>
                        <li class="nav-item"><a class="nav-link" href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    {{-- theming action --}}
    <div class="position-fixed bottom-0 end-0 m-3 z-index-5" id="fixedbuttons">
        <button class="btn btn-square btn-theme shadow rounded-circle" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#theming" aria-controls="theming">
            <i class="bi bi-palette"></i>
        </button>
        <br />
        <button class="btn btn-theme btn-square shadow mt-2 d-none rounded-circle" id="backtotop">
            <i class="bi bi-arrow-up"></i>
        </button>
    </div>
    {{-- theming offcanvas --}}
    <div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="theming" data-bs-scroll="true"
        data-bs-backdrop="false" aria-labelledby="theminglabel">
        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title" id="theminglabel">Personalize</h5>
                <p class="text-secondary small">Make it more like your own</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h6 class="offcanvas-title">Colors</h6>
            <p class="text-secondary small mb-4">Change colors of templates</p>

            <div class="row gx-3 mb-4 theme-select">
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-default">
                            <i class="bi bi-arrow-clockwise"></i>
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-blue">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-blue"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-indigo">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-indigo"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-purple">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-purple"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-pink">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-pink"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-red">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-red"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-orange">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-orange"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-yellow">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-yellow"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-green">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-green"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-teal">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-teal"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-pista">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-pista"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-cyan">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-cyan"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-grey">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-grey"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-brown">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-brown"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-chocolate">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-chocolate"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="theme-black">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-dark"></span>
                    </div>
                </div>
            </div>

            <h6 class="offcanvas-title">Backgrounds</h6>
            <p class="text-secondary small mb-4">Change color for background</p>
            <div class="row gx-3 mb-4 theme-background">
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-default">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i
                                class="bi bi-arrow-clockwise"></i></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-white">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-white"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-r-gradient">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-r-gradient"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-1">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-1"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-2">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-2"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-3">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-3"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-4">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-4"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-5">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-5"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-6">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-6"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-7">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-7"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-8">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-8"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-9">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-9"></span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="gradient-box text-center mb-2" data-title="bg-gradient-10">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-10"></span>
                    </div>
                </div>
            </div>

            <h6 class="offcanvas-title">Sidebar Layout</h6>
            <p class="text-secondary small mb-4">Change sidebar layout style</p>

            <div class="row gx-3 mb-4 sidebar-layout">
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-standard"
                        data-bs-toggle="tooltip" title="None">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-default">
                            <i class="bi bi-arrow-clockwise"></i>
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-iconic"
                        data-bs-toggle="tooltip" title="Iconic">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-default">
                            <i class="bi bi-bezier h4"></i>
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-boxed"
                        data-bs-toggle="tooltip" title="Boxed">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-default">
                            <i class="bi bi-box h5"></i>
                        </span>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="select-box text-center mb-2"
                        data-title="adminuiux-sidebar-boxed adminuiux-sidebar-iconic" data-bs-toggle="tooltip"
                        title="Iconic+Boxed">
                        <span class="avatar avatar-40 rounded-circle mb-2 bg-default">
                            <i class="bi bi-bounding-box h5"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <a href="mobileux-personalization.html" class="btn btn-sm btn-outline-theme">More options <i
                        class="bi bi-arrow-right-short"></i></a>
            </div>
        </div>
    </div>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Markdown JS --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    {{-- app js --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    {{-- datatables filter --}}
    <script>
    document.addEventListener("DOMContentLoaded", () => {

        let table = $('#datatables').DataTable({

            // basic setup
            responsive: true,
            fixedHeader: true,
            autoWidth: false,
            stateSave: false,
            pageLength: 25,
            lengthMenu: [10, 25, 50, 100, 250, 500],

            // tampilan dan posisi tombol
            dom: `
            <"row mb-3"
                <"col-md-4"l>
                <"col-md-8 text-end"B>
            >
            <"row"<"col-12"tr>>
            <"row mt-3"
                <"col-md-6"i>
                <"col-md-6 text-end"p>
            >`,

            // tombol export
            buttons: [{
                    extend: "colvis",
                    text: "Columns",
                    className: "btn btn-dark btn-sm",
                    columns: "[data-hide='audit']"
                }, {
                    extend: "copy",
                    text: "Copy",
                    className: "btn btn-light btn-sm"
                },
                {
                    extend: "excel",
                    text: "Excel",
                    className: "btn btn-success btn-sm",
                    filename: "roles_export_" + new Date().toISOString().slice(0, 10)
                },
                {
                    extend: "csv",
                    text: "CSV",
                    className: "btn btn-info btn-sm"
                },
                {
                    extend: "print",
                    text: "Print",
                    className: "btn btn-primary btn-sm"
                }
            ],

            // pengaturan kolom
            columnDefs: [{
                targets: "[data-hide='audit']",
                visible: false
            }],

            // urutkan berdasarkan tanggal terbaru
            order: [],
            language: {
                emptyTable: "{{ __('No notifications found.') }}",
                zeroRecords: "{{ __('No matching records found.') }}"
            },
            // tambah class ke row
            createdRow: row => row.classList.add("align-middle"),
        });

        // filter berdasarkan input per kolom
        $("#datatables thead tr.filter-row th").each(function(i) {
            $(this).find("input,select").on("keyup change", function() {
                table.column(i).search(this.value).draw();
            });
        });

        // filter tanggal (>= tanggal input)
        $.fn.dataTable.ext.search.push((settings, data) => {
            const input = $(".filter-row input[type=date]").val();
            const dateCol = data[3]?.split(" ")[0];
            return !input || dateCol >= input;
        });

        $(".filter-row input[type=date]").on("change", () => table.draw());
    });

    // prevent sorting when clicking inside search inputs (header filter)
    $('#datatables thead').on('click', 'input, select', function(e) {
        e.stopPropagation();
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- SweetAlert untuk success / error biasa --}}
    @if (session('success') || session('error'))
    <script>
    Swal.fire({
        icon: "{{ session('success') ? 'success' : 'error' }}",
        title: "{{ session('success') ? 'Success' : 'Error' }}",
        text: "{{ session('success') ?? session('error') }}",
        showConfirmButton: "{{ session('success') ? false : true }}",
        timer: "{{ session('success') ? 1200 : null }}",
        confirmButtonText: "OK",
        confirmButtonColor: "#1e1e1e",
        timerProgressBar: true
    }).then((result) => {
        window.location.reload();
    });
    </script>
    @endif

    {{-- SweetAlert untuk error validasi (seperti unique) --}}
    @if ($errors->any())
    <script>
    Swal.fire({
        icon: "error",
        title: "Error Validation",
        html: `
        <ul style="text-align:left;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    `,
        showConfirmButton: true,
        confirmButtonText: "OK",
        confirmButtonColor: "#1e1e1e"
    });
    </script>
    @endif

</body>

</html>