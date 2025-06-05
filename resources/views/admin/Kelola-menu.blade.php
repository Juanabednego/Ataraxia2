<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Menu</title>
</head>
@include('layouts.AdminNav')
<body>
  <!-- Main Content -->
<main id="main" class="main">
    <div class="container">
        <h2>Kelola Makanan & Minuman</h2>

        <!-- Menampilkan pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Button untuk tambah makanan/minuman -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addMakananModal">Tambah Makanan/Minuman</button>

        <!-- Table List Makanan/Minuman -->
        <table class="table table-striped">
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
        <img src="{{ asset('uploads/' . $makanan->foto) }}" alt="Foto" width="80">
    @else
        Tidak ada
    @endif
</td>
                        <td>{{ $makanan->nama_makanan }} </td>
                        <td>{{ $makanan->deskripsi }}</td>
                        <td>{{ number_format($makanan->harga , 0 , ',' , '.') }}</td>
                        <td>
                            <!-- Tombol Edit -->
                           <button type="button" class="btn btn-warning btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#editMakananModal-{{ $makanan->id }}"
    data-id="{{ $makanan->id }}"
    data-nama="{{ $makanan->nama_makanan }}"
    data-deskripsi="{{ $makanan->deskripsi }}"
    data-harga="{{ $makanan->harga }}"
    data-role="{{ $makanan->role }}"
    data-foto="{{ $makanan->foto }}">Edit</button>


                            <!-- Tombol Hapus -->
                            <form action="{{ route('kelola-menu.destroy', $makanan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Add Makanan/Minuman -->
    <div class="modal fade" id="addMakananModal" tabindex="-1" aria-labelledby="addMakananModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMakananModalLabel">Tambah Makanan/Minuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                  <img src="{{ asset('uploads/' . $makanan->foto) }}" width="80" class="rounded border">
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



@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    var editMakananModal = document.getElementById('editMakananModal');
    editMakananModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        var deskripsi = button.getAttribute('data-deskripsi');
        var harga = button.getAttribute('data-harga');

        var form = document.getElementById('editMakananForm');
        form.action = '/kelola-menu/' + id;

        var role = button.getAttribute('data-role');
document.getElementById('edit_role').value = role;

        document.getElementById('edit_nama_makanan').value = nama;
        document.getElementById('edit_deskripsi').value = deskripsi;
        document.getElementById('edit_harga').value = harga;
    });
});

</script>
@endpush




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