<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reservasi Restoran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9f9f9;
      padding: 40px 20px;
    }

    .reservation-container {
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      max-width: 700px;
      margin: auto;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .step-indicator {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .step {
      text-align: center;
      flex: 1;
    }

    .step-number {
      background: #ffc107;
      color: #fff;
      font-weight: bold;
      width: 40px;
      height: 40px;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      margin-bottom: 5px;
    }

    .step.inactive .step-number {
      background: #ddd;
    }

    .house-rules {
      background: #f1f1f1;
      padding: 15px;
      border-radius: 10px;
      font-size: 14px;
    }

    .btn-primary,
    .btn-secondary {
      width: 100%;
      margin-top: 20px;
    }

    .btn-primary {
      background: #ffc107;
      border: none;
    }
  </style>
</head>

<body>
@include('layouts.Navbar')

<div class="reservation-container">
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
  <div id="step1">
    <form id="step1Form" onsubmit="event.preventDefault(); if(validateStep1()) showStep(2);">
      <div class="mb-3">
        <label class="form-label">Dewasa</label>
        <input type="number" name="adults" class="form-control" id="adults" min="0" max="75" value="0" required placeholder="Masukkan jumlah dewasa" onfocus="clearZero(this)" />
      </div>
      <div class="mb-3">
        <label class="form-label">Anak-Anak</label>
        <input type="number" name="children" class="form-control" id="children" min="0" max="75" value="0" required placeholder="Masukkan jumlah anak-anak" onfocus="clearZero(this)" />
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="date" class="form-control" id="date" required min="{{ date('Y-m-d') }}" />
      </div>
      <div class="mb-3">
        <label class="form-label">Jam</label>
        <input type="time" name="time" class="form-control" id="time" required />
      </div>

      <div class="house-rules mb-3">
        <strong>Peraturan :</strong>
        <ul>
          <li>Waktu makan di restoran dibatasi hingga 2 jam</li>
          <li><strong>Sebutkan area pilihan Anda (merokok/tidak merokok)</strong></li>
          <li>Reservation will be held for 15 minutes past booking time</li>
          <li>Untuk rombongan di atas 10 orang, silakan hubungi kami via WhatsApp</li>
        </ul>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="agree" required />
        <label class="form-check-label">Saya telah membaca dan menyetujui syarat dan ketentuan di atas.</label>
      </div>

      <div class="d-flex justify-content-between">
        <a href="/" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Selanjutnya</button>
      </div>
    </form>
  </div>

  <!-- Step 2 -->
  <div id="step2" style="display: none">
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
        <label class="form-check-label">
          Saya ingin sekali menerima rekomendasi dan penawaran tempat makan yang dipersonalisasi!
        </label>
      </div>

      <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" onclick="showStep(1)">Kembali</button>
        <button type="submit" class="btn btn-primary">Konfirmasi Booking</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Detail Reservasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Dewasa:</strong> <span id="confirmAdults"></span></p>
        <p><strong>Anak:</strong> <span id="confirmChildren"></span></p>
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

@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function showStep(step) {
    document.getElementById("step1").style.display = step === 1 ? "block" : "none";
    document.getElementById("step2").style.display = step === 2 ? "block" : "none";
    document.getElementById("step-label-1").classList.toggle("inactive", step !== 1);
    document.getElementById("step-label-2").classList.toggle("inactive", step !== 2);
  }

  function clearZero(input) {
    if(input.value === "0") input.value = "";
  }

  function validateStep1() {
    const adults = parseInt(document.getElementById("adults").value);
    const children = parseInt(document.getElementById("children").value);
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    const agree = document.getElementById("agree").checked;

    if (isNaN(adults) || adults <= 0 || isNaN(children) || !date || !time || !agree) {
      alert("Harap lengkapi semua kolom dan centang persetujuan.");
      return false;
    }

    const selectedDate = new Date(date);
    const today = new Date();
    today.setHours(0,0,0,0);
    if (selectedDate < today) {
      alert("Tanggal tidak boleh di masa lalu.");
      return false;
    }

    return true;
  }

  function showConfirmationModal() {
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;
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

    document.getElementById("confirmAdults").innerText = adults;
    document.getElementById("confirmChildren").innerText = children;
    document.getElementById("confirmDate").innerText = date;
    document.getElementById("confirmTime").innerText = time;
    document.getElementById("confirmTitle").innerText = title;
    document.getElementById("confirmFirstName").innerText = firstName;
    document.getElementById("confirmLastName").innerText = lastName || '-';
    document.getElementById("confirmEmail").innerText = email;
    document.getElementById("confirmPhone").innerText = phone;
    document.getElementById("confirmNote").innerText = note || '-';

    const modal = new bootstrap.Modal(document.getElementById("confirmationModal"));
    modal.show();

    document.getElementById("confirmBookingBtn").onclick = submitReservation;
  }

  async function submitReservation() {
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;
    const people = `${adults} Adults, ${children} Children`;
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
      people: people,
      note: document.getElementById("note").value,
      _token: document.querySelector('meta[name="csrf-token"]').content
    };

    try {
      const response = await fetch("{{ route('reservation.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": data._token
        },
        body: JSON.stringify(data)
      });

      if (response.ok) {
        alert("Reservasi berhasil dikonfirmasi!");
        window.location.href = "/";
      } else {
        alert("Gagal mengirim reservasi.");
      }
    } catch (error) {
      console.error("Error:", error);
      alert("Terjadi kesalahan saat mengirim reservasi.");
    }
  }
</script>

</body>
</html>
