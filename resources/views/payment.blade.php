<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px #8174A0;
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
        }
        .btn-primary {
            background-color: #4CAF50;
            border: none;
        }
        .form-label {
            font-weight: bold;
        }
        .modal-content {
            background-color: rgb(255, 255, 255);
            color: rgb(21, 21, 21);
        }
        .form-select, .form-control {
            background-color: rgb(248, 250, 248);
            color: #000;
        }
        .payment-details {
            margin-top: 20px;
            padding: 10px;
            background-color: rgb(255, 255, 255);
            color: #000;
            border-radius: 8px;
            display: none;
        }
        .payment-details div {
            display: flex;
            align-items: center;
        }
        .payment-details span {
            margin-right: 10px;
        }
        .payment-details .copy-btn {
            margin-left: 10px;
            cursor: pointer;
        }
        .payment-details .copy-btn i {
            font-size: 18px;
            color: #B5338A;
        }
        .payment-details .copy-btn:hover i {
            color: rgb(255, 255, 255);
        }
    </style>
</head>
<body>
<div class="container text-center">
    <h2 class="mb-4" style="color: #4CAF50;">Pembayaran</h2>

    <p><strong>Kursi yang Dipilih:</strong> {{ implode(', ', json_decode($booking->seats)) }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_price) }}</p>

    <form id="paymentForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">


            <!-- PILIH REKENING DARI DATABASE -->
<div class="mb-3">
    <label class="form-label">Pilih Rekening Tujuan:</label>
    <select name="payment_method" id="payment_method" class="form-select" required>
        <option value="">-- Pilih Rekening --</option>
        @foreach($accounts as $acc)
            <option value="{{ $acc->method }}"
                    data-number="{{ $acc->account_number }}"
                    data-name="{{ $acc->account_name }}">
                {{ strtoupper($acc->method) }} - {{ $acc->account_name }}
            </option>
        @endforeach
    </select>
</div>


      

        <div id="paymentDetails" style="display: none;">
            <div>
                <span id="accountNumber"></span>
                <button id="copyButton" class="copy-btn" type="button">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <span id="accountName"></span><br>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Bukti Transfer:</label>
            <input type="file" name="proof_of_payment" accept="image/*" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100" >Konfirmasi Pembayaran</button>
    </form>

    <!-- Tombol Kembali dengan konfirmasi -->
    <button id="btnCancel" class="btn btn-back w-100 mt-3">Kembali</button>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Pembayaran Diproses</h5>
            </div>
            <div class="modal-body text-center">
                <p>Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi dari Admin.</p>
            </div>
            <div class="modal-footer">
                <a href="/histori" class="btn btn-success w-100">Kembali</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    
   $(document).ready(function () {
    // Saat metode pembayaran dipilih
    $("#payment_method").change(function () {
        const selected = $(this).find("option:selected");
        const accountNumber = selected.data("number");
        const accountName = selected.data("name");

        if (accountNumber && accountName) {
            $("#accountNumber").text("Nomor Rekening: " + accountNumber);
            $("#accountName").text("Nama Rekening: " + accountName);
            $("#paymentDetails").show();

            $("#copyButton").off("click").on("click", function () {
                navigator.clipboard.writeText(accountNumber)
                    .then(() => alert("Nomor rekening disalin: " + accountNumber))
                    .catch(err => alert("Gagal menyalin: " + err));
            });
        } else {
            $("#paymentDetails").hide();
        }
    });

    // Submit pembayaran
    $("#paymentForm").submit(function (event) {
        event.preventDefault();

        let formData = new FormData(this);
        let selectedBank = $("#payment_method").val();
        if (!selectedBank) {
            alert("Silakan pilih rekening tujuan terlebih dahulu.");
            return;
        }

        $.ajax({
            url: "{{ route('payment.process') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                $("#confirmationModal").modal("show");
            },
            error: function () {
                alert("Terjadi kesalahan, silakan coba lagi.");
            }
        });
    });

    // Tombol kembali
    $("#btnCancel").click(function (e) {
        e.preventDefault();
        if (confirm("Ada pembayaran yang belum selesai. Apakah Anda yakin ingin membatalkan?")) {
            history.back();
        }
    });
});

</script>
</body>
</html>
