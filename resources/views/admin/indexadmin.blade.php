<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard</title>
  <style>
    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 10px;
      border: none;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-icon {
      font-size: 2rem;
      color: #4154f1;
    }
    
    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #6c757d;
    }
    
    .card-value {
      font-size: 1.8rem;
      font-weight: 700;
      color: #012970;
    }
    
    .more-info {
      color: #899bbd;
      font-size: 0.9rem;
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    
    .more-info:hover {
      color: #4154f1;
    }
    
    .more-info i {
      margin-left: 5px;
      transition: transform 0.3s ease;
    }
    
    .more-info:hover i {
      transform: translateX(3px);
    }
  </style>
</head>
@include('layouts/AdminNav')
<body>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
    </nav>  
  </div>
  
  <!-- Dashboard Cards -->
  <section class="section dashboard">
    <div class="row">
      <!-- Pesanan Baru Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-cart"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">Pemesanan Baru</h6>
               <span class="card-value">{{ $pesananBaruCount }}</span>
                <a href="/tables-data" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Event Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-calendar-event"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">Event</h6>
                <span class="card-value">{{ $eventCount }}</span>
                <a href="/kelola-event" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Menu Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card customers-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-cup-straw"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">Menu</h6>
              <span class="card-value">{{ $menuCount }}</span>
                <a href="/kelola-menu" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Meja Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-star"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">Review</h6>
             <span class="card-value">{{ $reviewCount }}</span>
                <a href="/kelola-review" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Reservasi Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-book"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">About</h6>
                <span class="card-value">{{ $aboutCount }}</span>
                <a href="/kelola-about" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-bookmark-check"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">Reservation</h6>
               <span class="card-value">{{ $reservationCount }}</span>
                <a href="{{ route('admin.index') }}" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-workspace"></i>
              </div>
              <div class="ps-3">
                <h6 class="card-title">Kursi</h6>
                <span class="card-value">27</span>
                <a href="/seat-builder" class="more-info">
                  More info <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

 

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a

  <!-- Vendor JS Files -->
  <script src="admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="admin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="admin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="admin/assets/vendor/quill/quill.js"></script>
  <script src="admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="admin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="admin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="admin/assets/js/main.js"></script>
  <script>
    // Fungsi untuk mengambil data dinamis
    document.addEventListener('DOMContentLoaded', function() {
      // Contoh fungsi untuk mengambil data dari API
      // Dalam implementasi nyata, Anda akan mengganti ini dengan fetch/axios ke endpoint Anda
      function fetchDashboardData() {
        // Simulasi data dari backend
        // const data = {
        //   new_orders: 27,
        //   events: 27,
        //   menus: 27,
        //   tables: 27,
        //   abouts: 27,
        //   reservations: 27
        // };
        
        // Update nilai di dashboard
        document.querySelector('.sales-card .card-value').textContent = data.new_orders;
        document.querySelector('.revenue-card .card-value').textContent = data.events;
        document.querySelector('.customers-card .card-value').textContent = data.menus;
        document.querySelectorAll('.info-card .card-value')[3].textContent = data.tables;
        document.querySelectorAll('.info-card .card-value')[4].textContent = data.abouts;
        document.querySelectorAll('.info-card .card-value')[5].textContent = data.reservations;
      }
      
      // Panggil fungsi saat halaman dimuat
      fetchDashboardData();
      
      // Anda bisa menambahkan interval untuk update berkala
      // setInterval(fetchDashboardData, 30000); // Update setiap 30 detik
    });
  </script>
</body>
</html>