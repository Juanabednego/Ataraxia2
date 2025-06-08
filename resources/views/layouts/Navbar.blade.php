<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ataraxia Cafe</title>

  <!-- Favicon -->
  <link href="{{ asset('assets/img/Ataraxialogo.jpg') }}" rel="icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Vendor CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />

  <style>
    .text-truncate-2-lines {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .hover-highlight:hover {
      background-color: #f8f9fa;
      transition: all 0.3s ease-in-out;
      border-left: 4px solid #0d6efd;
    }
    .dropdown-menu {
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      padding: 0.5rem 0;
      max-height: 400px;
      overflow-y: auto;
      backdrop-filter: blur(10px);
    }
    #notificationBadge {
      animation: pulseBadge 1.5s infinite;
      font-size: 0.65rem;
      padding: 0.3em 0.5em;
    }
    @keyframes pulseBadge {
      0% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.2); opacity: 0.8; }
      100% { transform: scale(1); opacity: 1; }
    }
    .logo-img { height: 40px; width: auto; }
    .sitename { font-weight: 700; font-size: 1.5rem; }
  </style>
</head>

<body>
  <header class="header sticky-top py-3 bg-white shadow-sm">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="{{ route('index') }}" class="d-flex align-items-center text-decoration-none">
        <img src="{{ asset('assets/img/logoo.png') }}" class="logo-img" alt="Logo">
        <h1 class="sitename ms-2 mb-0">Ataraxia</h1>
      </a>

      <nav class="navbar navbar-expand-xl ms-3">
        <div class="container-fluid p-0">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-xl-0">
              <li class="nav-item"><a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#" id="navEventsLink">Events</a></li>
              <li class="nav-item"><a class="nav-link" href="#" id="navMenuLink">Menu</a></li>
              <li class="nav-item"><a class="nav-link" href="/reservation">Reservation</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="d-flex align-items-center ms-3 gap-3">
        @auth
        <div class="nav-item dropdown position-relative">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-bell-fill fs-4 text-dark"></i>
            <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" style="display: none;">1</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" id="notificationDropdownList" aria-labelledby="notificationDropdown" style="min-width: 320px; max-width: 360px;">
            <!-- Akan diisi dinamis oleh JS -->
          </ul>
        </div>

        <div class="dropdown">
          <button class="btn p-0 border-0 bg-transparent" type="button" id="userDropdown" data-bs-toggle="dropdown">
            <i class="fas fa-user fs-5 text-dark"></i>
          </button> 
          <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 border-0 mt-2" aria-labelledby="userDropdown">
            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#accountModal">Akun Saya</button></li>
            <li><a class="dropdown-item" href="/histori">Histori</a></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
              </form>
            </li>
          </ul>
        </div>
        @endauth

        @guest
        <a href="/login" class="btn p-0 border-0 bg-transparent">
          <i class="fas fa-user fs-5 text-dark"></i>
        </a>
        @endguest
      </div>
    </div>
  </header>

  <!-- Modal Notifikasi Detail -->
  <div class="modal fade" id="notificationDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title">Detail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="fw-semibold" id="notificationDetailMessage">...</p>
          <p class="small">Tunjukkan ini ke tim support untuk verifikasi akses.</p>
          <small class="text-muted" id="notificationDetailTime">...</small>
        </div>
      </div>
    </div>
  </div>

  <!-- JS CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Events -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('navEventsLink').addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = '/#events';
      });

      document.getElementById('navMenuLink').addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = '/menu';
      });
    });

    function loadUserNotifikasi() {
      $.get("{{ route('load-notifikasi') }}", function (data) {
        let html = "";

        if (data.length > 0) {
          $("#notificationBadge").show().text(data.length);
          data.forEach(n => {
            html += `
              <li>
                <a href="#" class="dropdown-item py-2 px-3 d-flex align-items-start gap-3 hover-highlight view-notif-detail"
                   data-message="${n.message}" data-time="${n.created_at}">
                  <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                  <div class="flex-grow-1">
                    <div class="fw-semibold text-dark text-truncate-2-lines">${n.message}</div>
                    <small class="text-muted">${n.created_at}</small><br>
                    <small class="text-muted">Klik untuk detail</small>
                  </div>
                </a>
              </li>`;
          });
        } else {
          html = `<li><a class="dropdown-item text-muted">Tidak ada notifikasi</a></li>`;
          $("#notificationBadge").hide();
        }

        $("#notificationDropdownList").html(html);
      });
    }

    loadUserNotifikasi();
    setInterval(loadUserNotifikasi, 10000);

    $(document).on("click", ".view-notif-detail", function (e) {
  e.preventDefault();
  window.location.href = '/histori';
});

  </script>
</body>

</html>
