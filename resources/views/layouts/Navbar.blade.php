<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ataraxia Cafe</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="{{ asset('assets/img/Ataraxialogo.jpg') }}" rel="icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />

    <style>
        /* Navbar Styles */
        .navbar {
            background-color: #fff;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-toggler {
            border: none;
        }

        .logo-img {
            height: 40px;
            width: auto;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.8rem 1.5rem;
            color: #333;
        }

        /* Navbar Menu */
        .navbar-collapse {
            justify-content: flex-end;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-item {
            display: inline-block;
            margin-left: 20px;
        }

        /* Mobile View */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
                width: 100%;
                margin-top: 10px;
            }

            .navbar-nav .nav-link {
                padding: 1rem;
                font-size: 1.2rem;
            }

            .navbar-collapse .navbar-nav {
                flex-grow: 1;
                justify-content: center;
            }

            .navbar-toggler {
                border: 1px solid #333;
                border-radius: 5px;
            }

            .navbar-nav .nav-link.active {
                background-color: #e9ecef;
            }
        }

        /* Notification Badge */
        #notificationBadge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 50%;
        }

        /* User and Notification dropdown */
        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            min-width: 320px;
            max-width: 360px;
            backdrop-filter: blur(10px);
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 15px;
        }

        /* Smooth Hover Effect */
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }
    </style>
</head>

<body class="index-page">
    <header id="header" class="header sticky-top py-3 bg-white shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="{{ route('index') }}" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('assets/img/logoo.png') }}" alt="Ataraxia Logo" class="logo-img" />
                <h1 class="sitename ms-2 mb-0">Ataraxia</h1>
            </a>

            <!-- Navbar menu + toggle -->
            <nav class="navbar navbar-expand-xl ms-3">
                <div class="container-fluid p-0">
                    <!-- Toggle Button -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                        aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Menu Items -->
                    <div class="collapse navbar-collapse" id="navbarMenu">
                        <ul class="navbar-nav ms-auto mb-2 mb-xl-0">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('events*') ? 'active' : '' }}" href="#" id="navEventsLink">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('menu') ? 'active' : '' }}" href="#" id="navMenuLink">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('reservation') ? 'active' : '' }}" href="/reservation">Reservation</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Icon Notifikasi dan User di sebelah kanan -->
            <div class="d-flex align-items-center ms-3 gap-3">
                @auth
                    <!-- Notifikasi -->
                    <div class="nav-item dropdown position-relative">
                        <a class="nav-link dropdown-toggle d-flex align-items-center position-relative" href="#" id="notificationDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell-fill fs-4 text-dark"></i>
                            <span id="notificationBadge"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm"
                                style="display: none;">
                                1
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown"
                            style="min-width: 320px; max-width: 360px;">
                            <li class="dropdown-header fw-bold text-dark px-3 pt-2">🔔 Notifikasi Terbaru</li>
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-start gap-3 hover-highlight" href="#">
                                    <i class="bi bi-info-circle-fill text-muted fs-5 mt-1"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-muted text-truncate-2-lines">Belum ada notifikasi</div>
                                        <small class="text-muted">Kamu akan melihatnya di sini</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn p-0 border-0 bg-transparent d-flex align-items-center" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fs-5 text-dark"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 border-0 mt-2" aria-labelledby="userDropdown">
                            <li><button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#accountModal">Akun Saya</button>
                            </li>
                            <li><a class="dropdown-item py-2" href="/histori">Histori</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                @guest
                    <a href="/login" class="btn p-0 border-0 bg-transparent d-flex align-items-center" style="line-height: 1;">
                        <i class="fas fa-user fs-5 text-dark"></i>
                    </a>
                @endguest
            </div>
        </div>
    </header>

    <!-- Add JS for Navbar and User actions here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
