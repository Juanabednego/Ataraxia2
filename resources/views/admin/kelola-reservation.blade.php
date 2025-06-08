<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kelola Reservation</title>
    <link href="{{ asset('assets/img/Ataraxialogo.jpg') }}" rel="icon">
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 40px 30px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #363949;
            letter-spacing: 1px;
        }
        .table {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(60,60,60,0.04);
            overflow: hidden;
        }
        .table thead {
            background: linear-gradient(90deg, #cfd9df 0%, #e2ebf0 100%);
            font-weight: 600;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 0.85rem 1.2rem;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9fafc;
        }
        .table tbody tr:hover {
            background-color: #e9f2ff !important;
            transition: background 0.25s;
        }
        .action-btns .btn {
            min-width: 90px;
            border-radius: 6px;
            margin-right: 6px;
            font-size: 0.97rem;
            box-shadow: none;
        }
        .status-text {
            font-weight: 600;
            font-size: 1em;
        }
        .status-confirmed { color: #047857; }
        .status-cancelled { color: #991b1b; }
        .status-pending { color: #b45309; }
        .text-final {
            color: #888;
            font-style: italic;
            font-size: 0.95em;
        }
        .highlight-reservation {
            background: linear-gradient(90deg,#2563eb30 0%,#7dd3fc30 100%) !important;
            color: #222 !important;
            transition: background 0.8s, color 0.8s;
        }
        .modal-content {
            border-radius: 1.1rem;
            box-shadow: 0 6px 24px rgba(0,0,0,0.11);
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        .modal-title {
            font-weight: 600;
            font-size: 1.13rem;
        }
        .modal-footer {
            border-top: none;
        }
        .footer {
            background: #eef1f5;
            font-size: 1em;
        }
        @media (max-width: 900px) {
            .content-wrapper {
                margin-left: 0;
                padding: 24px 8px;
            }
            .page-title {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 600px) {
            .table th, .table td {
                font-size: 0.98rem;
                padding: 0.5rem 0.6rem;
            }
        }
    </style>
</head>

@include('layouts.AdminNav')

<body>
<main id="main" class="main">
<div class="container content-wrapper mt-4">
    <div class="page-title">Kelola Reservasi</div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $res)
                <tr id="reservation-row-{{ $res->id }}">
                    <td>{{ $res->name }}</td>
                    <td>{{ $res->email }}</td>
                    <td>{{ $res->date }}</td>
                    <td>{{ $res->time }}</td>
                    <td>{{ $res->people }}</td>
                    <td>
                        <span class="status-text
                            {{ $res->status == 'confirmed' ? 'status-confirmed' : 
                               ($res->status == 'cancelled' ? 'status-cancelled' : 'status-pending') }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </td>
                    <td>
                        @if($res->status === 'pending')
                        <div class="action-btns d-flex">
                            <button class="btn btn-success btn-sm" onclick="openConfirmModal({{ $res->id }})">
                                <i class="bi bi-check-circle me-1"></i>Confirm
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="openCancelModal({{ $res->id }})">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </button>
                        </div>
                        @else
                        <span class="text-final">Status Final</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
</main>

<!-- Modal Alasan Penolakan -->
<div class="modal fade" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="cancelForm" method="POST">
      @csrf
      @method('PATCH')
      <input type="hidden" name="status" value="cancelled">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelReasonLabel">Alasan Penolakan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="reason" class="form-label">Masukkan alasan penolakan:</label>
            <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Kirim</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="confirmForm" method="POST">
      @csrf
      @method('PATCH')
      <input type="hidden" name="status" value="confirmed">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Reservasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Pastikan pesanan nya sesuai sebelum Anda mengonfirmasi reservasi ini.</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Konfirmasi</button>
        </div>
      </div>
    </form>
  </div>
</div>

<footer id="footer" class="footer mt-auto py-3">
    <div class="container">
        <div class="text-center text-muted">
            &copy; {{ date('Y') }} <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openCancelModal(reservationId) {
        const form = document.getElementById('cancelForm');
        form.action = `/admin/kelola-reservation/${reservationId}`;
        document.getElementById('reason').value = '';
        const modal = new bootstrap.Modal(document.getElementById('cancelReasonModal'));
        modal.show();
    }

    function openConfirmModal(reservationId) {
        const form = document.getElementById('confirmForm');
        form.action = `/admin/kelola-reservation/${reservationId}`;
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    }

    // AUTO SCROLL & HIGHLIGHT BIRU
    document.addEventListener("DOMContentLoaded", function() {
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
        const reservationId = getQueryParam('reservation_id');
        if (reservationId) {
            const row = document.getElementById('reservation-row-' + reservationId);
            if (row) {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.classList.add('highlight-reservation');
                setTimeout(() => {
                    row.classList.remove('highlight-reservation');
                }, 3000);
            }
        }
    });
</script>
</body>
</html>
