@extends('layouts.master-without-nav')

@section('title')
    Login
@endsection

@section('css')
@endsection

@section('content')
    <div class="container-fluid authentication-bg overflow-hidden">
        <div class="bg-overlay"></div>
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="/" class="logo-dark">
                                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="48"
                                    class="auth-logo logo-dark mx-auto">
                            </a>
                            <a href="/" class="logo-dark">
                                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="48"
                                    class="auth-logo logo-light mx-auto">
                            </a>

                            <h4 class="mt-4">Selamat Datang Kembali <i class="mdi mdi-heart text-danger"></i></h4>
                            <p class="text-muted">Login untuk melanjutkan ke Dashboard TK Marhamah Hasanah 2</p>
                        </div>

                        <div class="p-2 mt-5">
                            {{-- Form Login --}}
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Error Umum (misal salah login) --}}
                                @if (session('error'))
                                    <div class="alert alert-danger text-center small mb-3">
                                        <strong>Username salah atau password salah.</strong>
                                    </div>
                                @endif

                                {{-- Email --}}
                                <div class="input-group auth-form-group-custom mb-1">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="basic-addon1">
                                        <i class="mdi mdi-account-outline auti-custom-input-icon"></i>
                                    </span>
                                    <input id="email" type="email" name="email" class="form-control"
                                        value="{{ old('email') }}" required autofocus autocomplete="username"
                                        placeholder="Masukkan Email" aria-label="Email" aria-describedby="basic-addon1">
                                </div>
                                @error('email')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror

                                {{-- Password --}}
                                <div class="input-group auth-form-group-custom mb-1 mt-3">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="basic-addon2">
                                        <i class="mdi mdi-lock-outline auti-custom-input-icon"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" id="password" required
                                        autocomplete="current-password" placeholder="Masukkan Password" aria-label="Password"
                                        aria-describedby="basic-addon2">
                                </div>
                                @error('password')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror

                                {{-- Checkbox & Forgot --}}
                                <div class="mb-sm-5 d-flex justify-content-between align-items-center mt-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="remember_me">
                                        <label class="form-check-label" for="remember_me">Ingat Akun</label>
                                    </div>
                                    <div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-muted">
                                                <i class="mdi mdi-lock me-1"></i> Lupa Password?
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tombol Login & Register --}}
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <a href="{{ route('register') }}" class="text-muted">
                                        <i class="mdi mdi-login me-1"></i> Belum punya akun?
                                    </a>
                                    <button type="submit" class="btn btn-primary w-md waves-effect waves-light">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-5 text-center">
                            <p>
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
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
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
