<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kelola Review</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <style>
        .main {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out;
            border: none;
            overflow: hidden;
        }
        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            padding: 12px 16px;
        }
        .table td {
            padding: 12px 16px;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        /* Highlight biru */
        .highlight-review {
            background-color:rgb(6, 101, 185) !important;
            transition: background-color 1s;
        }
        @media (max-width: 992px) {
            .main {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
@include('layouts.AdminNav')
<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Review</h1>
        </div>
        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Review Pengguna</h5>
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Rating</th>
                                            <th>Comment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reviews as $review)
                                        <tr id="review-row-{{ $review->id }}">
                                            <td>{{ ($reviews->currentPage()-1)*$reviews->perPage() + $loop->iteration }}</td>
                                            <td>{{ $review->user->name }}</td>
                                            <td>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td>{{ \Illuminate\Support\Str::limit($review->comment, 50) }}</td>
                                            <td>
                                                @if($review->status == 'pending')
                                                    <form action="{{ route('admin.kelola-review.update', $review->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="action" value="approve">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Tampilkan review ini ke user?')">Tampilkan</button>
                                                    </form>
                                                @elseif($review->status == 'approved' && !$review->is_hidden)
                                                    <form action="{{ route('admin.kelola-review.update', $review->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="action" value="hide">
                                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Sembunyikan review ini?')">Hide</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Pagination -->
                               <div class="mt-3">
    {{ $reviews->links('pagination::bootstrap-5') }}
</div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="text-center text-muted">
                &copy; {{ date('Y') }} <strong><span>Ataraxia</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
        const reviewId = getQueryParam('review_id');
        if (reviewId) {
            const row = document.getElementById('review-row-' + reviewId);
            if (row) {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.classList.add('highlight-review');
                setTimeout(() => {
                    row.classList.remove('highlight-review');
                }, 8000);
            }
        }
    });
    </script>
</body>
</html>
