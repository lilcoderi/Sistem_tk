@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Data Guru
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
                            <a href="javascript:void(0)">Manajemen Pengguna</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('guru.index') }}">Manajemen Data Guru</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('guru.create') }}">Tambah Data Guru</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h4 class="mb-4">Edit Data Guru</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $guru->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $guru->nama) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $guru->email) }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip) }}">
            </div>

            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $guru->kontak) }}">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto Baru (Opsional)</label>
                <input type="file" name="photo" class="form-control">
            </div>

            @if ($guru->photo)
                <div class="mb-3">
                    <label class="form-label d-block">Foto Saat Ini:</label>
                    <img src="{{ asset('storage/' . $guru->photo) }}" alt="Foto Guru" width="150" class="img-thumbnail">
                </div>
            @endif

            <button type="submit" class="btn btn-success">
                <i class="bi bi-arrow-repeat"></i> Perbarui
            </button>
            <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
