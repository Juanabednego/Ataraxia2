<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reservasi Restoran</title>
  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ede7f6 0%, #fff 100%);
      min-height: 100vh;
      padding: 40px 0;
    }
    .reservation-container {
      background: #fff;
      border-radius: 22px;
      padding: 40px 30px 32px 30px;
      max-width: 600px;
      margin: 32px auto 32px auto;
      box-shadow: 0 10px 40px 0 rgba(129, 116, 160, 0.13);
      transition: box-shadow .2s;
    }
    .reservation-container:hover {
      box-shadow: 0 18px 56px 0 rgba(129, 116, 160, 0.22);
    }
    .step-indicator {
      display: flex;
      justify-content: space-between;
      margin-bottom: 36px;
      gap: 10px;
    }
    .step {
      text-align: center;
      flex: 1;
      position: relative;
    }
    .step-number {
      background: #8174A0;
      color: #fff;
      font-weight: bold;
      width: 46px;
      height: 46px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      font-size: 1.15rem;
      box-shadow: 0 3px 12px rgba(129,116,160,0.13);
      margin-bottom: 8px;
      border: 3px solid #ede7f6;
      transition: background .3s;
    }
    .step.inactive .step-number {
      background: #e4e1ed;
      color: #c1b6d3;
    }
    .step:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 23px;
      right: -50%;
      width: 95%;
      height: 3px;
      background: #e4e1ed;
      z-index: 0;
      border-radius: 2px;
    }
    .step:not(.inactive) .step-number {
      background: #ffc107;
      color: #fff;
    }
    .house-rules {
      background: #f7f4fc;
      border-left: 4px solid #8174A0;
      padding: 16px 24px;
      border-radius: 11px;
      font-size: 15px;
      margin-bottom: 20px;
      color: #7360a8;
    }
    label.form-label {
      font-weight: 500;
      color: #564789;
      font-size: 1.01rem;
      margin-bottom: .4em;
    }
    .form-control, .form-select {
      border-radius: 16px;
      min-height: 44px;
      border: 1.5px solid #e1dbef;
      box-shadow: none;
      font-size: 1rem;
      color: #413c5c;
      background: #f9f6fc;
      transition: border .2s;
    }
    .form-control:focus, .form-select:focus {
      border: 1.5px solid #8174A0;
      background: #fff;
      box-shadow: 0 0 0 1.5px #8174A022;
    }
    textarea.form-control { min-height: 75px;}
    .form-check-input:checked {
      background-color: #8174A0;
      border-color: #8174A0;
    }
    .btn-primary {
      background: linear-gradient(90deg, #8174A0 0%, #ffc107 100%);
      border: none;
      color: #fff;
      font-weight: 600;
      letter-spacing: .5px;
      border-radius: 18px;
      padding: 11px 0;
      transition: background .2s, box-shadow .2s;
      box-shadow: 0 2px 10px #e2d4ff23;
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(90deg, #ffc107 0%, #8174A0 100%);
      color: #fff;
      box-shadow: 0 6px 30px #f5cfff29;
    }
    .btn-secondary {
      border-radius: 18px;
          font-weight: 500;
      background: #ede7f6;
      color: #6d4a98;
      border: none;
      padding: 11px 0;
      transition: background .2s, color .2s;
    }
    .btn-secondary:hover, .btn-secondary:focus {
      background: #8174A0;
      color: #fff;
    }
    .form-check-label {
      font-size: .98rem;
      color: #7665a8;
    }
    .modal-content {
      border-radius: 16px;
      box-shadow: 0 8px 40px rgba(129, 116, 160, 0.19);
    }
    .modal-header {
      background: linear-gradient(90deg, #8174A0 0%, #ffc107 100%);
      color: #fff;
      border-radius: 16px 16px 0 0;
    }
    .modal-title {
      font-weight: 600;
      letter-spacing: .5px;
    }
    .modal-footer .btn {
      min-width: 110px;
    }
    .alert {
      border-radius: 16px;
      box-shadow: 0 2px 10px #e2d4ff23;
    }
    @media (max-width:600px) {
      .reservation-container {
        padding: 22px 6px;
        max-width: 100vw;
        margin: 14px 6px;
      }
    }
  </style>
</head>

<body>
  @include('layouts.Navbar')
  <main class="reservation-container">
    <!-- Step indicator -->
    <div class="step-indicator">
      <div class="step" id="step-label-1">
        <div class="step-number">1</div>
        <div>Reservasi</div>
      </div>
      <div class="step inactive" id="step-label-2">
        <div class="step-number">2</div>
        <div>Detail</div>
      </div>
    </div>

    <!-- Step 1 -->
    <section id="step1">
      <form id="step1Form" onsubmit="event.preventDefault(); if(validateStep1()) showStep(2);">
        <div class="mb-3">
          <label for="totalSeats" class="form-label">Jumlah Kursi</label>
          <input type="number" name="totalSeats" class="form-control" id="totalSeats" min="1" max="75" value="1" required placeholder="Masukkan jumlah kursi" onfocus="clearZero(this)" />
        </div>
        <div class="mb-3">
          <label for="date" class="form-label">Tanggal</label>
          <input type="date" name="date" class="form-control" id="date" required min="{{ date('Y-m-d') }}" />
        </div>
        <div class="mb-3">
          <label for="time" class="form-label">Jam</label>
          <input type="text" name="time" class="form-control" id="time" placeholder="Pilih jam (01:00 - 23:59)" required />
        </div>

        <div class="house-rules mb-3">
          <strong>Peraturan :</strong>
          <ul class="mb-0 mt-1">
            <li><strong>Reservasi akan diproses 15 menit setelah waktu pemesanan</strong></li>
            <li>Untuk Request Posisi Kursi, Silahkan Hubungi Admin Melalui Whatsapp</li>
            <li>Untuk rombongan di atas 10 orang, silakan hubungi kami via WhatsApp</li>
          </ul>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="agree" required />
          <label class="form-check-label" for="agree">Saya telah membaca dan menyetujui syarat dan ketentuan di atas.</label>
        </div>

        <div class="d-flex justify-content-between gap-2 mt-4">
          <a href="/" class="btn btn-secondary px-4">Kembali</a>
          <button type="submit" class="btn btn-primary px-4">Selanjutnya</button>
        </div>
      </form>
    </section>

    <!-- Step 2 -->
    <section id="step2" style="display: none;">
      <form id="step2Form" onsubmit="event.preventDefault(); showConfirmationModal();">
        <div class="row mb-3">
          <div class="col-md-2">
            <select name="title" class="form-select" id="title" required>
              <option value="" disabled selected>Pilih</option>
              <option value="Mr.">Mr.</option>
              <option value="Mrs.">Mrs.</option>
              <option value="Ms.">Ms.</option>
            </select>
          </div>
          <div class="col-md-5">
            <input type="text" name="firstName" class="form-control" placeholder="Nama Depan" id="firstName" required />
          </div>
          <div class="col-md-5">
            <input type="text" name="lastName" class="form-control" placeholder="Nama Belakang" id="lastName" />
          </div>
        </div>

        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Alamat Email" id="email" required />
        </div>

        <div class="mb-3 row">
          <div class="col-md-3">
            <input type="text" class="form-control" value="+62" disabled />
          </div>
          <div class="col-md-9">
            <input type="tel" name="phone" class="form-control" placeholder="Nomor Telepon" id="phone" required />
          </div>
        </div>

        <div class="mb-3">
          <textarea name="note" class="form-control" maxlength="85" placeholder="Pesan (Maksimal 85 Karakter)" id="note"></textarea>
        </div>

        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="promotions" />
          <label class="form-check-label" for="promotions">
            Saya ingin sekali menerima rekomendasi dan penawaran tempat makan yang dipersonalisasi!
          </label>
        </div>

        <div class="d-flex justify-content-between gap-2 mt-4">
          <button type="button" class="btn btn-secondary px-4" onclick="showStep(1)">Kembali</button>
          <button type="submit" class="btn btn-primary px-4">Konfirmasi Booking</button>
        </div>
      </form>
    </section>
  </main>
  @include('layouts.footer')

  <!-- Modal Konfirmasi -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Detail Reservasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p><strong>Jumlah Kursi:</strong> <span id="confirmTotalSeats"></span></p>
          <p><strong>Tanggal:</strong> <span id="confirmDate"></span></p>
          <p><strong>Waktu:</strong> <span id="confirmTime"></span></p>
          <p><strong>Title:</strong> <span id="confirmTitle"></span></p>
          <p><strong>Nama Depan:</strong> <span id="confirmFirstName"></span></p>
          <p><strong>Nama Belakang:</strong> <span id="confirmLastName"></span></p>
          <p><strong>Email:</strong> <span id="confirmEmail"></span></p>
          <p><strong>Telepon:</strong> <span id="confirmPhone"></span></p>
          <p><strong>Catatan:</strong> <span id="confirmNote"></span></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
          <button class="btn btn-primary" id="confirmBookingBtn">Lanjutkan Pemesanan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Section -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#time", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
      time_24hr: true,
      minTime: "01:00",
      maxTime: "23:59",
      defaultHour: 10,
      defaultMinute: 0
    });

    function showStep(step) {
      document.getElementById("step1").style.display = step === 1 ? "block" : "none";
      document.getElementById("step2").style.display = step === 2 ? "block" : "none";
      document.getElementById("step-label-1").classList.toggle("inactive", step !== 1);
      document.getElementById("step-label-2").classList.toggle("inactive", step !== 2);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function clearZero(input) {
      if (input.value === "0") input.value = "";
    }

    function validateStep1() {
      const totalSeats = parseInt(document.getElementById("totalSeats").value);
      const date = document.getElementById("date").value;
      const time = document.getElementById("time").value;
      const agree = document.getElementById("agree").checked;

      if (isNaN(totalSeats) || totalSeats <= 0 || !date || !time || !agree) {
        alert("Harap lengkapi semua kolom dan centang persetujuan.");
        return false;
      }
      const selectedDate = new Date(date);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      if (selectedDate < today) {
        alert("Tanggal tidak boleh di masa lalu.");
        return false;
      }
      return true;
    }

    function showConfirmationModal() {
      const totalSeats = document.getElementById("totalSeats").value;
      const date = document.getElementById("date").value;
      const time = document.getElementById("time").value;
      const title = document.getElementById("title").value;
      const firstName = document.getElementById("firstName").value;
      const lastName = document.getElementById("lastName").value;
      const email = document.getElementById("email").value;
      const phone = document.getElementById("phone").value;
      const note = document.getElementById("note").value;
      if (!title || !firstName || !email || !phone) {
        alert("Harap lengkapi semua kolom informasi.");
        return;
      }
      document.getElementById("confirmTotalSeats").innerText = totalSeats;
      document.getElementById("confirmDate").innerText = date;
      document.getElementById("confirmTime").innerText = time;
      document.getElementById("confirmTitle").innerText = title;
      document.getElementById("confirmFirstName").innerText = firstName;
      document.getElementById("confirmLastName").innerText = lastName || "-";
      document.getElementById("confirmEmail").innerText = email;
      document.getElementById("confirmPhone").innerText = phone;
      document.getElementById("confirmNote").innerText = note || "-";
      const modal = new bootstrap.Modal(document.getElementById("confirmationModal"));
      modal.show();
      document.getElementById("confirmBookingBtn").onclick = submitReservation;
    }

    async function submitReservation() {
      const totalSeats = document.getElementById("totalSeats").value;
      const title = document.getElementById("title").value;
      const firstName = document.getElementById("firstName").value;
      const lastName = document.getElementById("lastName").value;
      const name = `${title} ${firstName} ${lastName}`.trim();
      const data = {
        name: name,
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        date: document.getElementById("date").value,
        time: document.getElementById("time").value,
        people: totalSeats,
        note: document.getElementById("note").value,
        _token: document.querySelector('meta[name="csrf-token"]').content,
      };
      try {
        const response = await fetch("{{ route('reservation.store') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": data._token,
          },
          body: JSON.stringify(data),
        });
        if (response.ok) {
          alert("Reservasi berhasil dikonfirmasi!");
          window.location.href = "/histori";
        } else {
          const err = await response.json();
          alert(err.message || "Gagal mengirim reservasi.");
        }
      } catch (error) {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat mengirim reservasi.");
      }
    }
  </script>
</body>
</html>

     
