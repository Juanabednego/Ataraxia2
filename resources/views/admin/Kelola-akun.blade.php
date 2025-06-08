<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
@include('layouts.AdminNav')
<body>
<main id="main" class="main p-4">
    <div class="container">
        <h2 class="mb-4">Kelola Akun</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Filter -->
        <div class="mb-4">
            <form method="GET" action="{{ route('superadmin.kelola-akun') }}">
                <label for="filter" class="form-label me-2">Tampilkan:</label>
                <select name="filter" id="filter" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                    <option value="active" {{ $filter === 'active' ? 'selected' : '' }}>Akun Aktif</option>
                    <option value="nonaktif" {{ $filter === 'nonaktif' ? 'selected' : '' }}>Akun Nonaktif</option>
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua Akun</option>
                </select>
            </form>
        </div>

        <!-- Form Tambah Akun -->
        <form method="POST" action="{{ route('superadmin.kelola-akun.store') }}" class="mb-4">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-2">
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </div>
            </div>
        </form>

        <!-- Tabel Akun -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            @if($user->trashed())
                                <span class="badge bg-secondary">Nonaktif</span>
                            @else
                                <span class="badge bg-success">Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if($user->role !== 'superadmin')
                                @if($user->trashed())
                                    <form method="POST" action="{{ route('superadmin.kelola-akun.restore', $user->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm" onclick="return confirm('Pulihkan akun ini?')">Pulihkan</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('superadmin.kelola-akun.destroy', $user->id) }}" onsubmit="return confirm('Nonaktifkan akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Nonaktifkan</button>
                                    </form>
                                @endif
                            @else
                                <em>Superadmin</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center text-muted">
        &copy; {{ date('Y') }} <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
