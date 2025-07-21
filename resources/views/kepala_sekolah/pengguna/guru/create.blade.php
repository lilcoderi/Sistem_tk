@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Data Guru
@endsection

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
        <h4 class="mb-4">Tambah Data Guru</h4>

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

        <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Pilih User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Guru</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Guru</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
            </div>

            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" name="kontak" class="form-control" value="{{ old('kontak') }}">
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto (Opsional)</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const namaInput = document.getElementById('nama');
            const emailInput = document.getElementById('email');

            userSelect.addEventListener('change', function() {
                const userId = this.value;

                if (!userId) {
                    // Reset input jika kosong
                    namaInput.value = '';
                    emailInput.value = '';
                    return;
                }

                fetch(`/get-user/${userId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        namaInput.value = data.name || '';
                        emailInput.value = data.email || '';
                    })
                    .catch(() => {
                        alert('Gagal mengambil data user.');
                        namaInput.value = '';
                        emailInput.value = '';
                    });
            });
        });
    </script>
@endsection
