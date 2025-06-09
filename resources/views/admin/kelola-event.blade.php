<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kelola Event</title>
  <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <style>
    body {
      background: #f6f8fa;
      font-family: 'Poppins', Arial, sans-serif;
    }
    .main {
      margin-left: 300px;
      padding-top: 48px;
      min-height: 100vh;
      background: #f6f8fa;
    }
    .card {
      border-radius: 14px;
      box-shadow: 0 4px 14px rgba(60,70,130,0.09);
      border: 0;
      margin-top: 20px;
    }
    .card-body {
      padding: 2rem 1.3rem;
      background: #fff;
      border-radius: 14px;
    }
    .page-header-title {
      font-weight: 700;
      font-size: 2rem;
      letter-spacing: 0.5px;
      color: #22223b;
      margin-bottom: 0;
    }
    .table th {
      font-weight: 700;
      background: #f5f6fa;
      color: #444;
      border-bottom: 1.5px solid #e3e7ef;
      font-size: 1.02rem;
    }
    .table td, .table th {
      vertical-align: middle;
      padding: 13px 14px;
    }
    .table-striped>tbody>tr:nth-of-type(odd) {
      background-color: #f9fafc;
    }
    .table-hover tbody tr:hover {
      background: #edf4fa !important;
      transition: background 0.25s;
    }
    .event-img-thumb {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(80,120,180,0.10);
      border: 1px solid #e7e7ec;
      background: #fafafa;
      transition: box-shadow 0.2s;
    }
    .event-img-thumb:hover {
      box-shadow: 0 4px 20px rgba(80,120,180,0.14);
    }
    .fw-bold { font-weight: 600!important; }
    .action-btns .btn {
      border-radius: 6px;
      font-size: 0.97rem;
      min-width: 85px;
      margin-right: 7px;
      box-shadow: none;
      font-weight: 500;
      letter-spacing: 0.1px;
      display: flex;
      align-items: center;
    }
    .action-btns .btn:last-child {
      margin-right: 0;
    }
    .modal-header, .modal-footer {
      border: none;
    }
    .modal-header.bg-primary, .modal-header.bg-danger {
      border-radius: 1rem 1rem 0 0;
    }
    .modal-content {
      border-radius: 1rem;
      box-shadow: 0 6px 24px rgba(0,0,0,0.12);
    }
    .modal-title {
      font-size: 1.15rem;
      font-weight: 600;
      letter-spacing: 0.4px;
    }
    .form-label { font-weight: 500; }
    @media (max-width:900px) {
      .main { margin-left: 0; padding-top: 16px;}
      .card-body { padding: 1rem 0.6rem; }
    }
    @media (max-width:576px) {
      .table th, .table td { font-size: 0.97rem; padding: 8px 7px; }
    }
  </style>
</head>
@include('layouts.AdminNav')

<body>
  <main class="main">
    <div class="container-fluid px-4 py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-header-title">Kelola Event</h2>
        <button class="btn btn-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addEventModal">
          <i class="bi bi-plus-circle me-2"></i>Tambah Event
        </button>
      </div>
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <div class="card shadow-sm border-0">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th width="120">Foto</th>
                  <th>Judul</th>
                  <th>Deskripsi</th>
                  <th>Harga</th>
                  <th width="120">Tanggal</th>
                  <th width="180">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($events as $index => $event)
                <tr>
                  <td class="align-middle">{{ $index + 1 }}</td>
                  <td class="align-middle">
                    <img src="{{ asset($event->image) }}" class="event-img-thumb" alt="Foto Event">
                  </td>
                  <td class="align-middle fw-bold">{{ $event->name }}</td>
                  <td class="align-middle" style="max-width:250px; white-space:pre-line;">{{ $event->description }}</td>
                  <td class="align-middle">Rp{{ number_format($event->harga, 0, ',', '.') }}</td>
                  <td class="align-middle">{{ $event->date ? $event->date->format('d/m/Y') : '-' }}</td>
                  <td class="align-middle">
                    <div class="action-btns d-flex">
                      <button class="btn btn-warning btn-sm me-2"
                        data-bs-toggle="modal"
                        data-bs-target="#editEventModal-{{ $event->id }}">
                        <i class="bi bi-pencil-square"></i> Edit
                      </button>
                      <button type="button" class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteEventModal-{{ $event->id }}">
                        <i class="bi bi-trash"></i> Hapus
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @if($events->isEmpty())
          <div class="text-center py-5">
            <div class="mb-4">
              <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted mb-2">Belum ada event</h4>
            <p class="text-muted">Tambahkan event baru dengan mengklik tombol "Tambah Event" di atas</p>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Modal Tambah Event -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form action="{{ route('kelola-event.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Event Baru</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Judul Event</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Tanggal Event</label>
                  <input type="date" name="date" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Harga</label>
                  <input type="number" name="harga" class="form-control" placeholder="Contoh: 50000" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Deskripsi</label>
                  <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-12">
                  <label class="form-label">Gambar Event</label>
                  <input type="file" name="image" class="form-control" accept="image/*" required>
                  <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Edit Event -->
    @foreach($events as $event)
    <div class="modal fade" id="editEventModal-{{ $event->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form action="{{ route('kelola-event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Event</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Judul Event</label>
                  <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Tanggal Event</label>
                  <input type="date" name="date" class="form-control"
                    value="{{ $event->date ? $event->date->format('Y-m-d') : '' }}" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Deskripsi</label>
                  <textarea name="description" class="form-control" rows="3" required>{{ $event->description }}</textarea>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Harga</label>
                  <input type="number" name="harga" class="form-control" value="{{ $event->harga }}" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Gambar Event</label>
                  <input type="file" name="image" class="form-control" accept="image/*">
                  <div class="mt-2 d-flex align-items-center gap-3">
    @if($event->image)
        <img src="{{ asset($event->image) }}" width="80" class="event-img-thumb">
    @else
        <span class="text-muted">Tidak ada gambar</span>
    @endif
    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
</div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach

    <!-- Modal Hapus Event -->
    @foreach($events as $event)
    <div class="modal fade" id="deleteEventModal-{{ $event->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Event</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus event <strong>{{ $event->name }}</strong>?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <form action="{{ route('kelola-event.destroy', $event->id) }}" method="POST" class="m-0 d-inline"
              id="deleteForm-{{ $event->id }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Ya, Hapus</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach

  </main>

  <footer id="footer" class="footer bg-white py-3 mt-4">
    <div class="container text-center text-muted small">
      &copy; {{ date('Y') }} <strong><span>Ataraxia</span></strong>. All Rights Reserved
    </div>
  </footer>

  <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
