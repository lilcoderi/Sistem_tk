@extends('layouts.master-without-nav')

@section('title', 'Register')

@section('content')
<div class="container-fluid authentication-bg overflow-hidden">
    <div class="bg-overlay"></div>
    <div class="row align-items-center justify-content-center min-vh-100">
        <div class="col-10 col-md-6 col-lg-4 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center">
                        <a href="/" class="d-block mb-3">
                            <img src="{{ secure_asset('assets/images/logo-dark.png') }}" alt="Logo Dark" height="48"
                                class="auth-logo mx-auto d-block">
                        </a>

                        <h4 class="mt-4">Buat Akun Pendaftaran</h4>
                        <p class="text-muted">Register untuk melakukan Pendaftaran TK Marhamah Hasanah 2</p>
                    </div>

                    <div class="p-2 mt-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Button --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="{{ route('login') }}" class="text-muted">
                                    <i class="mdi mdi-login me-1"></i> Sudah punya akun?
                                </a>
                                <button type="submit" class="btn btn-primary w-md waves-effect waves-light">
                                    Register
                                </button>
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
    <script src="{{ secure_asset('build/js/app.js') }}"></script>
@endsection
