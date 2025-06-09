<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Akun</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background: #f8f9fa;
        }

        .profile-card {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }

        .profile-card h2 {
            font-weight: 700;
            color: #5c4d8a;
            margin-bottom: 1.5rem;
        }

        .profile-card p {
            font-size: 1rem;
            margin-bottom: 0.8rem;
        }

        .profile-card p i {
            width: 24px;
            text-align: center;
            color: #8174A0;
        }

        .btn-edit {
            border-radius: 30px;
            padding-left: 25px;
            padding-right: 25px;
        }

        @media (max-width: 576px) {
            .profile-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

@include('layouts.Navbar')

<div class="container mt-5">
    <div class="profile-card text-center">
        <h2><i class="fas fa-user-circle me-2"></i>Profil Akun</h2>
        
        <p><i class="fas fa-user"></i> <strong>Nama:</strong> {{ Auth::user()->name }}</p>
        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><i class="fas fa-phone"></i> <strong>Nomor Telepon:</strong> {{ Auth::user()->phone }}</p>
        <p><i class="fas fa-calendar-alt"></i> <strong>Dibuat pada:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
        
        <hr>

        <a href="#" class="btn btn-outline-secondary btn-edit mt-2">
            <i class="fas fa-edit me-2"></i>Edit Profil
        </a>
    </div>
</div>
<br>

@include('layouts.footer')

<!-- Bootstrap JS (opsional, untuk komponen interaktif) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
