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
        <div>Reservation</div>
      </div>
      <div class="step inactive" id="step-label-2">
        <div class="step-number">2</div>
        <div>Information</div>
      </div>
    </div>

    <!-- Step 1 -->
    <div id="step1">
      <form id="step1Form" onsubmit="event.preventDefault(); if(validateStep1()) showStep(2);">
        <div class="mb-3">
          <label class="form-label">Adults</label>
          <input type="number" name="adults" class="form-control" id="adults" min="0" max="75" value="0" required placeholder="Masukkan jumlah dewasa" onfocus="clearZero(this)" />
        </div>
        <div class="mb-3">
          <label class="form-label">Children</label>
          <input type="number" name="children" class="form-control" id="children" min="0" max="75" value="0" required placeholder="Masukkan jumlah anak-anak" onfocus="clearZero(this)" />
        </div>
        <div class="mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date" class="form-control" id="date" required min="{{ date('Y-m-d') }}" />
        </div>
        <div class="mb-3">
          <label class="form-label">Time</label>
          <input type="time" name="time" class="form-control" id="time" required />
        </div>

        <div class="house-rules mb-3">
          <strong>House Rules:</strong>
          <ul>
            <li>Restaurant dining time is limited to 2 hours</li>
            <li><strong>Please state your preferred dining area (smoking/non-smoking)</strong> in the special request box. This request is not guaranteed and subject to availability.</li>
            <li>Reservation will be held for 15 minutes past booking time</li>
            <li>For groups above 10 people, please contact us directly on WhatsApp</li>
          </ul>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="agree" required />
          <label class="form-check-label">I have read and agree to the above terms and conditions.</label>
        </div>

        <div class="d-flex justify-content-between">
          <a href="/" class="btn btn-secondary">Back</a>
          <button type="submit" class="btn btn-primary">Next</button>
        </div>
      </form>
    </div>

    <!-- Step 2 -->
    <div id="step2" style="display: none">
      <form id="step2Form" onsubmit="event.preventDefault(); showConfirmationModal();">
        <h5 class="mb-4">We have a table for you at <strong>Ataraxia</strong></h5>

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
            <input type="text" name="firstName" class="form-control" placeholder="First Name" id="firstName" required />
          </div>
          <div class="col-md-5">
            <input type="text" name="lastName" class="form-control" placeholder="Last Name" id="lastName" />
          </div>
        </div>

        <div class="mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" required />
        </div>

        <div class="mb-3 row">
          <div class="col-md-3">
            <input type="text" class="form-control" value="+62" disabled />
          </div>
          <div class="col-md-9">
            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" id="phone" required />
          </div>
        </div>

        <div class="mb-3">
          <textarea name="note" class="form-control" maxlength="85" placeholder="Message (Maximum 85 characters.)" id="note"></textarea>
        </div>

        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="promotions" />
          <label class="form-check-label">
            I’d love to receive personalised dining recommendations and deals!
          </label>
        </div>

        <div class="d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" onclick="showStep(1)">Back</button>
          <button type="submit" class="btn btn-primary">Confirm Booking</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Konfirmasi Detail -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Detail Reservasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p><strong>Jumlah Dewasa:</strong> <span id="confirmAdults"></span></p>
          <p><strong>Jumlah Anak:</strong> <span id="confirmChildren"></span></p>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit Lagi</button>
          <button type="button" class="btn btn-primary" id="confirmBookingBtn">Lanjutkan Pemesanan</button>
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
    const adults = document.getElementById("adults").value;
    const children = document.getElementById("children").value;
    const date = document.getElementById("date").value;
    const time = document.getElementById("time").value;
    const agree = document.getElementById("agree").checked;

    if(adults === '' || children === '' || date === '' || time === '' || !agree) {
      alert("Harap lengkapi semua kolom dan centang persetujuan.");
      return false;
    }

    // Validasi tanggal tidak boleh masa lalu
    const selectedDate = new Date(date);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    if(selectedDate < today) {
      alert("Tanggal tidak boleh di masa lalu.");
      return false;
    }

    showStep(2);
    return true;
  }

  function showConfirmationModal() {
    // Ambil data dari form step 1 dan 2
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

    // Validasi field wajib di step 2
    if(!title || !firstName || !email || !phone) {
      alert("Harap lengkapi semua kolom informasi.");
      return;
    }

    // Tampilkan data di modal
    document.getElementById("confirmAdults").innerText = adults;
    document.getElementById("confirmChildren").innerText = children;
    document.getElementById("confirmDate").innerText = date;
    document.getElementById("confirmTime").innerText = time;
    document.getElementById("confirmTitle").innerText = title;
    document.getElementById("confirmFirstName").innerText = firstName;
    document.getElementById("confirmLastName").innerText = lastName ? lastName : '-';
    document.getElementById("confirmEmail").innerText = email;
    document.getElementById("confirmPhone").innerText = phone;
    document.getElementById("confirmNote").innerText = note ? note : '-';

    // Tampilkan modal
    const confirmationModal = new bootstrap.Modal(document.getElementById("confirmationModal"));
    confirmationModal.show();

    // Pasang event submit ketika klik tombol lanjutkan
    document.getElementById("confirmBookingBtn").onclick = submitReservation;
  }

  async function submitReservation() {
    // Kumpulkan data form
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
        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": data._token },
        body: JSON.stringify(data)
      });

      if (response.ok) {
        alert("Reservasi berhasil dikonfirmasi!");
        window.location.href = "/";  // Redirect setelah sukses
      } else {
        alert("Gagal mengirim reservasi, coba lagi.");
      }
    } catch (error) {
      console.error("Error saat submit:", error);
      alert("Terjadi kesalahan.");
    }
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
