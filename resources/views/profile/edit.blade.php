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
    Edit Profil
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
                            <a href="{{ route('profile.edit') }}">Edit Profil</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h2>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i> Profil berhasil diperbarui.
            </div>
        @endif

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="bg-white p-4 rounded shadow-sm border-start border-4 border-warning">
                <div class="mb-3">
                    <label for="name" class="form-label"><i class="bi bi-person-fill me-1"></i>Nama</label>
                    <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
