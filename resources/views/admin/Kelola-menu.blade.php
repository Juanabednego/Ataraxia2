<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Menu</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
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
        .main-section {
            padding: 40px 0 30px 0;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .main-section h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #363949;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
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
            transition: background 0.2s;
        }
        .img-thumb {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(60,60,60,0.05);
            border: 1px solid #e3e8ef;
            background: #fafafa;
        }
        .action-btns .btn {
            border-radius: 6px;
            font-size: 0.97rem;
            min-width: 85px;
            margin-right: 7px;
            box-shadow: none;
        }
        .action-btns .btn:last-child {
            margin-right: 0;
        }
        .modal-content {
            border-radius: 1.1rem;
            box-shadow: 0 6px 24px rgba(0,0,0,0.10);
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0.4rem;
        }
        .modal-title {
            font-weight: 600;
            font-size: 1.13rem;
        }
        .modal-footer {
            border-top: none;
        }
        .form-label {
            font-weight: 500;
            color: #36454f;
        }
        .btn-primary, .btn-success {
            font-weight: 500;
            letter-spacing: 0.3px;
        }
        @media (max-width: 900px) {
            .main-section { padding: 18px 2px 12px 2px; }
            .main-section h2 { font-size: 1.5rem; }
        }
        @media (max-width: 576px) {
            .table th, .table td {
                font-size: 0.99rem;
                padding: 0.6rem 0.4rem;
            }
        }
    </style>
</head>
@include('layouts.AdminNav')
<body>
<main id="main" class="main">
    <div class="container main-section">
        <h2>Kelola Makanan & Minuman</h2>

        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Button untuk tambah makanan/minuman -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addMakananModal">
            <i class="bi bi-plus-circle me-1"></i>Tambah Makanan/Minuman
        </button>

        <!-- Table List Makanan/Minuman -->
        <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($makanans as $makanan)
                <tr>
                    <td>
                        @if($makanan->foto)
                            <img src="{{ asset('uploads/' . $makanan->foto) }}" alt="Foto" class="img-thumb">
                        @else
                            <span class="text-muted fst-italic">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ $makanan->nama_makanan }}</td>
                    <td style="max-width: 250px;">
                        <span style="display:inline-block; white-space:pre-line;">{{ $makanan->deskripsi }}</span>
                    </td>
                    <td>Rp {{ number_format($makanan->harga , 0 , ',' , '.') }}</td>
                    <td>
                        <div class="action-btns d-flex">
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editMakananModal-{{ $makanan->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('kelola-menu.destroy', $makanan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <!-- Modal Add Makanan/Minuman -->
    <div class="modal fade" id="addMakananModal" tabindex="-1" aria-labelledby="addMakananModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addMakananModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Makanan/Minuman
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelola-menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role" class="form-label">Jenis</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="makanan">Makanan</option>
                                <option value="minuman">Minuman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nama_makanan" class="form-label">Nama Makanan/Minuman</label>
                            <input type="text" class="form-control" id="nama_makanan" name="nama_makanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Makanan/Minuman -->
    @foreach($makanans as $makanan)
    <div class="modal fade" id="editMakananModal-{{ $makanan->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('kelola-menu.update', $makanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Makanan/Minuman</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Makanan/Minuman</label>
                                <input type="text" name="nama_makanan" class="form-control" value="{{ $makanan->nama_makanan }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis</label>
                                <select class="form-control" name="role" required>
                                    <option value="makanan" {{ $makanan->role == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="minuman" {{ $makanan->role == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" required>{{ $makanan->deskripsi }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" value="{{ $makanan->harga }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Gambar Makanan/Minuman</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <div class="mt-2 d-flex align-items-center gap-3">
                                    @if($makanan->foto)
                                        <img src="{{ asset('uploads/' . $makanan->foto) }}" width="80" class="rounded border">
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

</main>

<footer id="footer" class="footer mt-auto py-3 bg-light">
    <div class="container">
        <div class="text-center text-muted">
            &copy; {{ date('Y') }} <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
