@extends('layouts.master-without-nav')

@section('title', 'Login')

@section('content')
<div class="container-fluid authentication-bg overflow-hidden">
    <div class="bg-overlay"></div>
    <div class="row align-items-center justify-content-center min-vh-100">
        <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center">
                        <a href="/" class="d-block mb-3">
                            <img src="{{ secure_asset('assets/images/logo-dark.png') }}" alt="Logo" height="48" class="auth-logo mx-auto d-block">
                        </a>
                        <h4 class="mt-4">Selamat Datang Kembali <i class="mdi mdi-heart text-danger"></i></h4>
                        <p class="text-muted">Login untuk melanjutkan ke Dashboard TK Marhamah Hasanah 2</p>
                    </div>

                    <div class="p-2 mt-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            @if (session('error'))
                                <div class="alert alert-danger text-center small mb-3">
                                    <strong>{{ session('error') }}</strong>
                                </div>
                            @endif

                            {{-- Email --}}
                            <div class="input-group auth-form-group-custom mb-3">
                                <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="email-addon">
                                    <i class="mdi mdi-account-outline"></i>
                                </span>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="Masukkan Email" required autofocus aria-describedby="email-addon">
                            </div>
                            @error('email')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            {{-- Password --}}
                            <div class="input-group auth-form-group-custom mb-3">
                                <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="password-addon">
                                    <i class="mdi mdi-lock-outline"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Masukkan Password" required aria-describedby="password-addon">
                            </div>
                            @error('password')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            {{-- Remember Me dan Lupa Password --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label" for="remember_me">Ingat Saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-muted">Lupa Password?</a>
                                @endif
                            </div>

                            {{-- Tombol Login --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('register') }}" class="text-muted">Belum punya akun?</a>
                                <button type="submit" class="btn btn-primary w-md">Login</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-5 text-center">
                        <p class="text-muted mb-0">
                            &copy; <script>document.write(new Date().getFullYear())</script>
                            TK Marhamah Hasanah 2 <i class="mdi mdi-heart text-danger"></i> by Hartono
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ secure_asset('assets/js/app.js') }}"></script>
@endsection
