<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/Ataraxialogo.jpg') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">

    <style>
        .dropdown-menu.notifications {
            min-width: 370px !important;
            max-width: 420px;
            padding: 0.6rem 0.7rem;
            max-height: 350px;
            overflow-y: auto;
        }
        .dropdown-menu.notifications .notification-item {
            white-space: normal;
        }
        @media (max-width: 500px) {
            .dropdown-menu.notifications {
                min-width: 90vw !important;
                max-width: 98vw;
            }
        }
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/indexadmin" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/Ataraxialogo.jpg') }}" alt="">
                <span class="d-none d-lg-block">Ataraxia</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <!-- Notification Icon -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger badge-number">{{ count($notifications) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        @forelse ($notifications as $notification)
                            @php
                                switch($notification->type) {
                                    case 'booking':
                                        $notifUrl = url('/tables-data?detail_id=');
                                        break;
                                    case 'review':
                                        $notifUrl = url('/kelola-review?review_id=');
                                        break;
                                    case 'reservation':
                                        $notifUrl = $notifUrl = route('admin.index') . '?reservation_id=';
                                        break;
                                    default:
                                        $notifUrl = '#';
                                }
                            @endphp
                            <li class="notification-item p-0"
                                style="border-radius:8px;">
                                <a href="{{ $notifUrl }}{{ $notification->reference_id }}" class="d-flex p-2 text-decoration-none text-dark notification-link" style="width:100%;border-radius:8px;">
                                    <i class="bi bi-envelope text-primary me-2 mt-1"></i>
                                    <div>
                                        <h6 style="margin-bottom:2px;">{{ $notification->title }}</h6>
                                        <span style="display:inline-block; font-size:0.98em; color:#6c757d; font-weight: 500; margin-bottom:2px;">
                                            {{ $notification->type }}
                                        </span>
                                        <p style="margin-bottom:2px;">{{ $notification->message }}</p>
                                        <small class="text-muted">
                                            {{ $notification->time ?? $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @empty
                            <li class="notification-item text-center text-muted">
                                Tidak ada notifikasi baru
                            </li>
                        @endforelse
                        <li class="notification-item text-center">
                            <a href="#" id="mark-read-btn" class="btn btn-primary btn-sm">Tandai Sudah Dibaca</a>
                        </li>
                    </ul>
                </li>
                <!-- End Notification Nav -->

                <!-- Profile Nav -->
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/Roberto.jpg') }}" alt="Profile" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Roberto Samuel</h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/indexadmin">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/tables-data">
                    <i class="bi bi-cart"></i>
                    <span>Pemesanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kelola-event">
                    <i class="bi bi-calendar-event"></i>
                    <span>Event</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kelola-menu">
                    <i class="bi bi-cup-straw"></i>
                    <span>Menu</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kelola-review">
                    <i class="bi bi-star"></i>
                    <span>Ulasan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/kelola-about">
                    <i class="bi bi-book"></i>
                    <span>About</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.index') }}">
                    <i class="bi bi-bookmark-check"></i>
                    <span>Reservation</span>
                </a>
            </li>
            @auth
                @if(auth()->user()->role === 'super_admin')
                    <li class="nav-item">
                        <a class="nav-link" href="/kelola-akun">
                            <i class="bi bi-person-workspace"></i>
                            <span>Kelola Akun</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.rekening.index') }}">
                            <i class="bi bi-bank"></i>
                            <span>Kelola Rekening</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </aside>

    <!-- ======= Script ======= -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // "Tandai Sudah Dibaca" semua
            $('#mark-read-btn').on('click', function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin.notifications.markRead') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('.badge-number').remove();
                        $('.notifications').html('<li class="notification-item text-center text-muted">Tidak ada notifikasi baru</li>');
                        $('#mark-read-btn').remove();
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan, silakan coba lagi.');
                    }
                }); 
            });

        });
    </script>
</body>
</html>
