@extends('layouts.app')

@section('content')
<div class="d-flex min-vh-100">
    <!-- Left Side (Logo) -->
    <div class="d-none d-md-flex flex-column justify-content-center align-items-center bg-dark text-white col-md-6" style="background-color: #3a3a3a;">
        <img src="{{ asset('assets/img/Ataraxia.jpg') }}" alt="Logo">
    </div>

    <!-- Right Side (Form Register) -->
    <div class="d-flex flex-column justify-content-center align-items-center col-md-6 bg-white">
        <div class="w-75" style="max-width: 400px;">
            <h3 class="text-center fw-bold mb-4">Register</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <input type="text" name="name" class="form-control rounded-pill @error('name') is-invalid @enderror" placeholder="Nama" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control rounded-pill @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="phone" class="form-control rounded-pill @error('phone') is-invalid @enderror" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
                    @error('phone')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block text-muted">Jenis Kelamin</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderLaki" value="laki-laki" {{ old('gender') == 'laki-laki' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="genderLaki">laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderPerempuan" value="perempuan" {{ old('gender') == 'perempuan' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="genderPerempuan">perempuan</label>
                    </div>
                    @error('gender')
                        <div><span class="text-danger small">{{ $message }}</span></div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="username" class="form-control rounded-pill @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control rounded-pill @error('password') is-invalid @enderror" placeholder="Password" autocomplete="new-password" required>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" name="password_confirmation" class="form-control rounded-pill" placeholder="Konfirmasi Password" required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn text-white fw-bold rounded-pill custom-btn">
                        Daftar
                    </button>
                </div>

                <div class="text-center">
                    <span class="text-muted small">sudah punya akun? </span>
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold small" style="color: #8174A0;">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font & Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link href="https://fonts.cdnfonts.com/css/dash-horizon" rel="stylesheet">

<!-- Custom Button Hover Style -->
<style>
    .custom-btn {
        background-color: #8174A0;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #7c5c99;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(152, 131, 163, 0.25);
        border-color: #8174A0;
    }

    .btn-outline-danger:hover {
        background-color: #DB4437;
        color: #fff !important;
        border-color: #c03b30;
    }

    .btn-outline-danger {
        transition: all 0.3s ease;
    }
</style>
@endsection
