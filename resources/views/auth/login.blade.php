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
                            <a href="/" class="d-block mb-3">
                                <img src="{{ secure_asset('build/images/logo-dark.png') }}" alt="Logo Dark" height="48"
                                    class="auth-logo logo-dark mx-auto d-block">
                                <img src="{{ secure_asset('build/images/logo-light.png') }}" alt="Logo Light" height="48"
                                    class="auth-logo logo-light mx-auto d-block">
                            </a>

                            <h4 class="mt-4">Selamat Datang Kembali <i class="mdi mdi-heart text-danger"></i></h4>
                            <p class="text-muted">Login untuk melanjutkan ke Dashboard TK Marhamah Hasanah 2</p>
                        </div>

                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                @if (session('error'))
                                    <div class="alert alert-danger text-center small mb-3">
                                        <strong>Username atau password salah.</strong>
                                    </div>
                                @endif

                                {{-- Email --}}
                                <div class="input-group auth-form-group-custom mb-2">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="email-addon">
                                        <i class="mdi mdi-account-outline auti-custom-input-icon"></i>
                                    </span>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}" required autofocus
                                        placeholder="Masukkan Email" aria-describedby="email-addon">
                                </div>
                                @error('email')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror

                                {{-- Password --}}
                                <div class="input-group auth-form-group-custom mt-3 mb-2">
                                    <span class="input-group-text bg-primary bg-opacity-10 fs-16" id="password-addon">
                                        <i class="mdi mdi-lock-outline auti-custom-input-icon"></i>
                                    </span>
                                    <input type="password" name="password" id="password" class="form-control" required
                                        placeholder="Masukkan Password" aria-describedby="password-addon">
                                </div>
                                @error('password')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror

                                {{-- Remember Me & Forgot Password --}}
                                <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember_me" class="form-check-input">
                                        <label class="form-check-label" for="remember_me">Ingat Akun</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-muted">
                                            <i class="mdi mdi-lock me-1"></i> Lupa Password?
                                        </a>
                                    @endif
                                </div>

                                {{-- Button & Register --}}
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
                            <p class="text-muted mb-0">
                                &copy;
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
    <script src="{{ secure_asset('build/js/app.js') }}"></script>
@endsection
