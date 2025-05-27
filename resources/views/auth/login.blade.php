@extends('layouts.blank')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/dash-horizon" rel="stylesheet">
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
        .google-btn {
            border: 2px solid #DB4437;
            color: #DB4437;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }
        .google-btn:hover {
            background-color: rgba(219, 68, 55, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .login-left,
            .login-right {
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="d-flex min-vh-100 login-wrapper">
    <!-- Left Side: Logo -->
    <div class="d-flex justify-content-center align-items-center bg-dark login-left" style="width: 50%;">
        <div class="text-center text-white">
            <img src="{{ asset('assets/img/Ataraxia.jpg') }}" alt="Ataraxia Logo" class="img-fluid" style="max-width: 80%;">
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="d-flex flex-column justify-content-center align-items-center bg-white login-right" style="width: 50%;">
        <div class="w-100 px-4" style="max-width: 400px;">
            <h3 class="text-center fw-bold mb-4">LOGIN</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input id="email" type="email"
                           class="form-control rounded-pill ps-4 @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autofocus
                           placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <input id="password" type="password"
                           class="form-control rounded-pill ps-4 pe-5 @error('password') is-invalid @enderror"
                           name="password" required
                           placeholder="Password" autocomplete="current-password">
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer;">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-dark" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}" style="color: #8e7ab5;">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn w-100 fw-bold text-white rounded-pill custom-btn">
                        <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                    </button>
                </div>

                <a href="{{ route('login.google') }}"
                   class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-pill google-btn mb-2">
                    <i class="fab fa-google"></i> Login dengan Google
                </a>

                <div class="text-center mt-3">
                    <p class="text-dark">Belum punya akun?
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #8174A0;">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
