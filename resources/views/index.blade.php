<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="#" name="#">
  <title>Ataraxia Cafe</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/Ataraxialogo.jpg') }}" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
/* Truncate teks jadi max 2 baris */
.text-truncate-2-lines {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Hover lembut untuk UX bagus */
.hover-highlight:hover {
  background-color: #f8f9fa;
  transition: all 0.3s ease-in-out;
  border-left: 4px solid #0d6efd;
}

/* Bayangan dan radius lembut */
.dropdown-menu {
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  padding: 0.5rem 0;
  max-height: 400px;
  overflow-y: auto;
  backdrop-filter: blur(10px);
}

/* Badge animasi pulse */
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
.btn-login i {
    font-size: 28px; /* Ukuran ikon, bisa disesuaikan */
}

.nav-bold li a {
    font-weight: bold;
}

.sticker-harga {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: radial-gradient(circle at center, #7a2680, #a033a0);
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    z-index: 2;
    font-size: 0.9rem;
  }

</style>
</head>

<body class="index-page" >
<header id="header" class="header d-flex align-items-center sticky-top py-3">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center me-auto">
      <img src="assets/img/logoo.png" alt="Ataraxia Logo" class="logo-img">
      <h1 class="sitename">Ataraxia</h1>
    </a>

    <nav id="navmenu" class="navmenu ms-auto nav-bold">
      <ul class="d-flex align-items-center mb-0">
        <li><a href="{{ route('index') }}" class="active">Home</a></li>
        <li><a href="#events">Events</a></li>
        <li><a href="/menu">Menu</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="/reservation">Reservation</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    {{-- Notifikasi untuk user login --}}
    @auth
    <div class="nav-item dropdown position-relative ms-3">
      <a class="nav-link dropdown-toggle d-flex align-items-center position-relative"
         href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell-fill fs-4 text-dark"></i>
        <span id="notificationBadge"
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm"
              style="display: none;">
          1
        </span>
      </a>

      <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn"
          aria-labelledby="notificationDropdown"
          id="notificationDropdownList"
          style="min-width: 340px; max-width: 380px;">
        <li class="dropdown-header fw-bold text-dark px-3 pt-2">🔔 Notifikasi Terbaru</li>
        <li>
          <a class="dropdown-item py-2 px-3 d-flex align-items-start gap-3 hover-highlight" href="#">
            <i class="bi bi-info-circle-fill text-muted fs-5 mt-1"></i>
            <div class="flex-grow-1">
              <div class="fw-semibold text-muted text-truncate-2-lines">Belum ada notifikasi</div>
              <small class="text-muted">Kamu akan melihatnya di sini</small>
            </div>
          </a>
        </ul>
        </li>
    </div>
    @endauth

    @auth
    <div class="dropdown d-inline ms-3">
      <button class="btn p-0 border-0 bg-transparent d-flex align-items-center"
              type="button" id="userDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false">
        <i class="fas fa-user fs-5 text-dark"></i>
      </button>

      <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 border-0 mt-2" aria-labelledby="userDropdown">
        <li>
          <button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#accountModal">
            Akun Saya
          </button>
        </li>
        <li>
          <a class="dropdown-item py-2" href="/histori">
            Histori
          </a>
        </li>
        <li>
          <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="dropdown-item py-2 text-danger">
              Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
    @endauth

    @guest
    <div class="d-inline ms-3">
      <a href="/login"
         class="btn p-0 border-0 bg-transparent d-flex align-items-center"
         style="line-height: 1;">
        <i class="fas fa-user fs-5 text-dark"></i>
      </a>
    </div>
    @endguest

  </div>
</header>

<main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section light-background">
      <div class="container">
          <div class="hero-background">
              <img src="assets/img/bgstory.jpg" alt="Ataraxia Balige">
              <div class="overlay"></div>
          </div>
          <div class="hero-content">
              <h1 style="font-family: 'Dash Horizon', sans-serif" >Ataraxia</h1><br>
              <p style="color: white">ATARAKAN PERASAANMU DI ATARAXIA</p>
              <p class="open-hours" style="color: white">We are open from <br> 10.00 AM until 12.00 AM</p>
              <a href="/reservation"
              class="btn btn-lg mt-3"
              style="background-color:#cd02caca; color:rgb(255, 255, 255); border-radius: 30px; padding: 12px 32px; font-weight: bold; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.3s;">
              Reservation
              </a>
          </div>
      </div>
  </section>
  <!-- /Hero Section -->
     
 
<!-- Events Section -->
<section id="events" class="events section py-5">
  <div class="container" data-aos="fade-up">
    <h2 class="text-center fw-bold mb-5">Upcoming Event</h2>

    <div class="row g-4 justify-content-center">
      @foreach($events as $event)
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 shadow-sm border-0 d-flex flex-column position-relative overflow-hidden">
            
            <!-- Sticker Harga -->
            <div class="sticker-harga position-absolute top-0 start-0 m-3 d-flex flex-column align-items-center justify-content-center text-white text-center">
              <small style="font-size: 0.75rem;">HARGA MULAI</small>
              <span style="font-size: 1.2rem; font-weight: bold;">
                Rp. {{ number_format($event->harga, 0, ',', '.') }}
              </span>
            </div>

            <!-- Sticker Tanggal -->
            <div class="position-absolute top-0 end-0 m-2 px-3 py-1 bg-dark text-white rounded-pill" style="z-index: 2; font-size: 0.85rem;">
              {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
            </div>

            <img src="{{ asset($event->image) }}" class="card-img-top" alt="{{ $event->name }}" style="height: 400px; object-fit: cover;">

            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title mb-3">{{ $event->name }}</h5>
              <p>{{ $event->description }}</p> <br>

              @php
                $link = auth()->check() ? route('pilihkursi') : route('login');
              @endphp
              <a href="{{ route('pilih-kursi', ['event_id' => $event->id]) }}" class="btn-event">Beli Tiket</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
  <!-- /Events Section -->

  <!-- Menu Section -->
    <section id="menu" class="hero section light-background">
      <div class="container">
        <div class="hero-background">
          <img src="assets/img/about-2.jpg" alt="Ataraxia Balige">
          <div class="overlay"></div>
        </div>
        <div class="hero-content">
          <p style="color: white; font-weight: bold">Endless Delicious, Savor Every Bite</p>
          <a href="/menu" class="btn btn-lg mt-3"
          style="background-color:#cd02caca; color:rgb(255, 255, 255); border-radius: 30px; padding: 12px 32px; font-weight: bold; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.3s;">
          Explore Menu
          </a>
          </div>
      </div>
    </section>
  <!-- /Menu Section -->

  <!-- About Section -->
<section id="about" class="about section">
  <div class="container section-title" data-aos="fade-up">
    <h1 class="story-title">Our Story</h1>
  </div>

  @if($about)
    <div class="container-story" data-aos="fade-up">
      @if($about->image_position == 'left')
        <div class="image-container">
          <img src="{{ asset($about->image_url) }}" alt="Marsada Band Story">
        </div>
        <div class="content">
          <p class="fst-italic">{{ $about->paragraph1 }}</p><br><br>
          <p class="fst-italic">{{ $about->paragraph2 }}</p><br><br>
          <p class="fst-italic">{{ $about->paragraph3 }}</p>
        </div>
      @else
        <div class="content">
          <p class="fst-italic">{{ $about->paragraph1 }}</p>
          <p class="fst-italic">{{ $about->paragraph2 }}</p>
          <p class="fst-italic">{{ $about->paragraph3 }}</p>
        </div>
        <div class="image-container">
          <img src="{{ asset($about->image_url) }}" alt="Marsada Band Story">
        </div>
      @endif
    </div>
  @else
    <div class="container" data-aos="fade-up">
      <p>Tidak ada data "Our Story" yang tersedia.</p>
    </div>
  @endif
</section>

<!-- Gallery Section -->
<section id="gallery" class="gallery section light-background">

<!-- Section Title -->
<div class="container section-title" data-aos="fade-up">
  <h2>Gallery</h2>
  <p><span>Check</span> <span class="description-title">Our Gallery</span></p>
</div><!-- End Section Title -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="swiper init-swiper">
    <script type="application/json" class="swiper-config">
      {
        "loop": true,
        "speed": 600,
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": "auto",
        "centeredSlides": true,
        "pagination": {
          "el": ".swiper-pagination",
          "type": "bullets",
          "clickable": true
        },
        "breakpoints": {
          "320": {
            "slidesPerView": 1,
            "spaceBetween": 0
          },
          "768": {
            "slidesPerView": 3,
            "spaceBetween": 20
          },
          "1200": {
            "slidesPerView": 5,
            "spaceBetween": 20
          }
        }
      }
    </script>
    <div class="swiper-wrapper align-items-center">
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-1.jpg"><img src="assets/img/gallery/gallery-1.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-2.jpg"><img src="assets/img/gallery/gallery-2.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-3.jpg"><img src="assets/img/gallery/gallery-3.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-4.jpg"><img src="assets/img/gallery/gallery-4.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-5.jpg"><img src="assets/img/gallery/gallery-5.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-6.jpg"><img src="assets/img/gallery/gallery-6.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-7.jpg"><img src="assets/img/gallery/gallery-7.jpg" class="img-fluid" alt=""></a></div>
      <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery" href="assets/img/gallery/gallery-8.jpg"><img src="assets/img/gallery/gallery-8.jpg" class="img-fluid" alt=""></a></div>
    </div>
    <div class="swiper-pagination"></div>
  </div>

</div>

</section><!-- /Gallery Section -->


 <!-- Testimonials Section -->
 <section id="testimonials" class="testimonials section-bg">
  <div class="container text-center" data-aos="fade-up">
    <h1 class="mb-5">Ulasan</h1>

    <div class="swiper init-swiper mx-auto" style="max-width: 700px;">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": 1,
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>

      <div class="swiper-wrapper">
        @foreach($reviews as $review)
        <div class="swiper-slide">
          <div class="testimonial-item p-4">
            <div class="testimonial-content text-center">
              <p class="fst-italic">
                <i class="bi bi-quote quote-icon-left"></i>
                <span>{{ $review->comment }}</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
              <h3 class="fw-bold">{{ $review->user->name ?? 'Pengguna' }}</h3>
              <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <= $review->rating)
                    <i class="bi bi-star-fill text-warning"></i>
                  @else
                    <i class="bi bi-star text-warning"></i>
                  @endif
                @endfor
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination mt-3"></div>
    </div>
  </div>
</section>


<style>
  .reservation-container {
    position: relative;
    width: 100%;
    height: 600px; /* Sesuaikan tinggi sesuai kebutuhan */
    overflow: hidden;
  }

  .reservation-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    
  }

  .reservation-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.4); /* Efek gelap transparan */
  }

  .reservation-button {
    background: #ff9900;
    color: white;
    border: none;
    padding: 15px 30px;
    font-size: 18px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .reservation-button:hover {
    background: #e68a00;
  }
  #notificationBadge {
    position: absolute;
    top: 0;
    right: 0;
    font-size: 12px;
    background-color: red;
    color: white;
    padding: 5px;
    border-radius: 50%;
}

.fa-star {
    color: gray;
    cursor: pointer;
}
.fa-star.checked {
    color: gold;
}


</style>

    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p><span class="description-title">Lokasi</span></p>
      </div><!-- End Section Title -->
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="mb-5">
        <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.4874271235694!2d99.09521957472714!3d2.341378597638207!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0500723a496d%3A0x16648aa653b349cf!2sAtaraxia%20Cafe!5e0!3m2!1sid!2sid!4v1746665637033!5m2!1sid!2sid" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>  
        </div><!-- End Google Maps --> <br><br>

        <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p><span class="description-title">Contact us & Feedback</span></p>
        </div>
        @auth
        @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
<form action="{{ route('review.store') }}" method="POST" class="review-form" data-aos="fade-up" data-aos-delay="600">
    @csrf
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

    <div class="row gy-4">
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ auth()->user()->name }}" readonly>
        </div>

        <div class="col-md-6">
            <input type="email" class="form-control" name="email" placeholder="Your Email" value="{{ auth()->user()->email }}" readonly>
        </div>

        <div class="col-md-12">
            <!-- Menampilkan Rating dalam Bentuk Bintang -->
            <div class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="fa fa-star {{ $i <= old('rating', 0) ? 'checked' : '' }}" data-rating="{{ $i }}"></span>
                @endfor
            </div>
            <!-- Hidden input untuk rating -->
            <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}" required>
        </div>

        <div class="col-md-12">
            <textarea class="form-control" name="comment" rows="6" placeholder="Message" required>{{ old('comment') }}</textarea>
        </div>

        <div class="col-md-12 text-center">
            <button type="submit">Send Message</button>
        </div>
    </div>
</form>


@endauth

<!-- End Contact Form -->
      </div>
    </section><!-- /Contact Section -->

  </main>
 @include('layouts.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.fa-star');
    const ratingInput = document.getElementById('rating');

    // Sorot bintang berdasarkan nilai sebelumnya atau nilai yang ada
    const currentRating = parseInt(ratingInput.value) || 0;
    stars.forEach(function(star, index) {
        if (index < currentRating) {
            star.classList.add('checked');
        } else {
            star.classList.remove('checked');
        }
    });

    stars.forEach(function(star, index) {
        star.addEventListener('click', function() {
            const rating = index + 1;
            ratingInput.value = rating;

            stars.forEach((s, i) => {
                s.classList.toggle('checked', i < rating);
            });
        });
    });
});
</script>




  <script>
  function loadUserNotifikasi() {
    $.get("{{ route('load-notifikasi') }}", function (data) {
      let html = "";

      if (data.length > 0) {
        $("#notificationBadge").show().text(data.length);

        data.forEach(n => {
          html += `
            <li>
              <a href="#" 
                 class="dropdown-item py-2 px-3 d-flex align-items-start gap-3 hover-highlight view-notif-detail"
                 data-message="${n.message}" 
                 data-time="${n.created_at}">
                <i class="bi bi-check-circle-fill text-success fs-5 mt-1"></i>
                <div class="flex-grow-1">
                  <div class="fw-semibold text-dark text-truncate-2-lines">${n.message}</div>
                  <small class="text-muted">${n.created_at}</small> <br>
                  <small class="text-muted">"Klik to detail"</small>
                </div>
              </a>
            </li>
          `;
        });

      } else {
        html = `<li>
          <a class="dropdown-item py-2 px-3 text-muted">Tidak ada notifikasi</a>
        </li>`;
        $("#notificationBadge").hide();
      }

      $("#notificationDropdownList").html(html);
    });
  }

  loadUserNotifikasi();
  setInterval(loadUserNotifikasi, 10000); // 10 detik
  </script>

  <script>
    $(document).on("click", ".view-notif-detail", function (e) {
      e.preventDefault();
      const message = $(this).data("message");
      const time = $(this).data("time");

      $("#notificationDetailMessage").text(message);
      $("#notificationDetailTime").text("Diterima: " + time);
      $("#notificationDetailModal").modal("show");
    });
  </script>
  <!-- Modal Informasi Akun -->
  @auth
  <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="accountModalLabel">Informasi Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
          <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>
        <div class="modal-footer">
          <a href="{{ route('akun') }}" class="btn btn-primary">Lihat Selengkapnya</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endauth

  <!-- MODAL DETAIL NOTIFIKASI -->
  <div class="modal fade" id="notificationDetailModal" tabindex="-1" aria-labelledby="notificationDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content shadow rounded-3">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="notificationDetailLabel">Detail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p class="mb-1 fw-semibold" id="notificationDetailMessage">...</p>
          <p style="font-size: 12px;">Mohon tunjukkan detail ini kepada tim penulis guna keperluan verifikasi akses Anda.</p>
          <br>
          <small class="text-muted" id="notificationDetailTime">...</small>
        </div>
      </div>
    </div>
  </div>
  </body>
</html>