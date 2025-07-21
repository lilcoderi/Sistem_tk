@php
    if (auth()->user()->hasRole('orang tua')) {
        $layout = 'orang_tua.layouts.app';
    } elseif (auth()->user()->hasRole('guru')) {
        $layout = 'guru.layouts.app';
    } elseif (auth()->user()->hasRole('kepala sekolah')) {
        $layout = 'kepala_sekolah.layouts.app';
    } else {
        $layout = 'layouts.app'; // fallback jika tidak punya role
    }
@endphp

@extends($layout)


@section('title')
    Profil Saya
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Akun</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('profile.view') }}">Lihat Profil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold text-primary"><i class="bi bi-person-circle me-2"></i>Profil Saya</h2>
        </div>

        <div class="bg-white p-4 rounded shadow-sm border-start border-4 border-primary">
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <strong><i class="bi bi-person-fill me-1"></i> Nama:</strong> {{ $user->name }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong><i class="bi bi-envelope me-1"></i> Email:</strong> {{ $user->email }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <strong><i class="bi bi-calendar-check me-1"></i> Terdaftar Sejak:</strong> {{ $user->created_at->format('d M Y') }}
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
@endsection
