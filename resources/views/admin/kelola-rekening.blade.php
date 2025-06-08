<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Rekening</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            color: #4CAF50;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        table thead {
            background-color: #f1f1f1;
        }
        .form-control, .form-select {
            border-radius: 8px;
        }
        .table {
    border: 1.5px solid #dee2e6 !important;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.table th, .table td {
    border: 1px solid #dee2e6 !important;
    padding: 14px 16px !important;
    vertical-align: middle;
    background: #fff;
}

.table thead th {
    background: #4CAF50 !important;
    color: #fff !important;
    font-weight: 600;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #388e3c !important;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f6f8fa !important;
}

.table-hover > tbody > tr:hover {
    background-color: #e7ffe7 !important;
}

    </style>
</head>

<body>
@include('layouts.AdminNav')

<main class="main p-4" style="margin-left:280px; margin-top: 50px;">
    <div class="container">
        <div class="card p-4 mb-4">
            <h2 class="mb-4">Kelola Rekening Pembayaran</h2>

            <!-- Form Tambah Rekening -->
            <form method="POST" action="{{ route('admin.rekening.store') }}" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <input type="text" name="method" class="form-control" placeholder="Metode (bri/ovo/dll)" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="account_number" class="form-control" placeholder="No Rekening / No HP" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="account_name" class="form-control" placeholder="Nama Pemilik Rekening" required>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>

        <!-- Tabel Rekening -->
        <div class="card p-3">
        <table class="table table-bordered table-striped table-hover shadow-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Metode</th>
            <th>No Rekening</th>
            <th>Nama Pemilik</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
                    @forelse($accounts as $index => $account)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ strtoupper($account->method) }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>{{ $account->account_name }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.rekening.destroy', $account->id) }}" onsubmit="return confirm('Hapus rekening ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada data rekening.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
