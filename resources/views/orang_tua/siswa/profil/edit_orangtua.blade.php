@extends('orang_tua.layouts.app')

@section('title')
    Edit Data Orang Tua
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('profil-siswa.orangtua') }}">Profil</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Data Orang Tua
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container py-5">
        <h1 class="fw-bold text-success mb-4">
            <i class="bi bi-people-fill me-2"></i> Edit Data Orang Tua
        </h1>

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('profil-orangtua.update', $orangtua->id_orangtua) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Data Ayah -->
            <h4 class="text-primary fw-bold mb-3">Data Ayah</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" name="nama_ayah" id="nama_ayah"
                        class="form-control @error('nama_ayah') is-invalid @enderror"
                        value="{{ old('nama_ayah', $orangtua->nama_ayah) }}">
                    @error('nama_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="nik_ayah" class="form-label">NIK Ayah</label>
                    <input type="text" name="nik_ayah" id="nik_ayah"
                        class="form-control @error('nik_ayah') is-invalid @enderror"
                        value="{{ old('nik_ayah', $orangtua->nik_ayah) }}">
                    @error('nik_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                    <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah"
                        class="form-control @error('tempat_lahir_ayah') is-invalid @enderror"
                        value="{{ old('tempat_lahir_ayah', $orangtua->tempat_lahir_ayah) }}">
                    @error('tempat_lahir_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                    <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah"
                        class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror"
                        value="{{ old('tanggal_lahir_ayah', $orangtua->tanggal_lahir_ayah) }}">
                    @error('tanggal_lahir_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="agama_ayah" class="form-label">Agama Ayah</label>
                    <input type="text" name="agama_ayah" id="agama_ayah"
                        class="form-control @error('agama_ayah') is-invalid @enderror"
                        value="{{ old('agama_ayah', $orangtua->agama_ayah) }}">
                    @error('agama_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="kewarganegaraan_ayah" class="form-label">Kewarganegaraan Ayah</label>
                    <input type="text" name="kewarganegaraan_ayah" id="kewarganegaraan_ayah"
                        class="form-control @error('kewarganegaraan_ayah') is-invalid @enderror"
                        value="{{ old('kewarganegaraan_ayah', $orangtua->kewarganegaraan_ayah) }}">
                    @error('kewarganegaraan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    fifteenth
                    <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                    <input type="text" name="pendidikan_ayah" id="pendidikan_ayah"
                        class="form-control @error('pendidikan_ayah') is-invalid @enderror"
                        value="{{ old('pendidikan_ayah', $orangtua->pendidikan_ayah) }}">
                    @error('pendidikan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah"
                        class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                        value="{{ old('pekerjaan_ayah', $orangtua->pekerjaan_ayah) }}">
                    @error('pekerjaan_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="no_telepon_ayah" class="form-label">No. Telepon Ayah</label>
                    <input type="text" name="no_telepon_ayah" id="no_telepon_ayah"
                        class="form-control @error('no_telepon_ayah') is-invalid @enderror"
                        value="{{ old('no_telepon_ayah', $orangtua->no_telepon_ayah) }}">
                    @error('no_telepon_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="alamat_rumah_ayah" class="form-label">Alamat Ayah</label>
                    <textarea name="alamat_rumah_ayah" id="alamat_rumah_ayah"
                        class="form-control @error('alamat_rumah_ayah') is-invalid @enderror">{{ old('alamat_rumah_ayah', $orangtua->alamat_rumah_ayah) }}</textarea>
                    @error('alamat_rumah_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Data Ibu -->
            <h4 class="text-primary fw-bold mt-4 mb-3">Data Ibu</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" name="nama_ibu" id="nama_ibu"
                        class="form-control @error('nama_ibu') is-invalid @enderror"
                        value="{{ old('nama_ibu', $orangtua->nama_ibu) }}">
                    @error('nama_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="nik_ibu" class="form-label">NIK Ibu</label>
                    <input type="text" name="nik_ibu" id="nik_ibu"
                        class="form-control @error('nik_ibu') is-invalid @enderror"
                        value="{{ old('nik_ibu', $orangtua->nik_ibu) }}">
                    @error('nik_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                    <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu"
                        class="form-control @error('tempat_lahir_ibu') is-invalid @enderror"
                        value="{{ old('tempat_lahir_ibu', $orangtua->tempat_lahir_ibu) }}">
                    @error('tempat_lahir_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                    <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu"
                        class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror"
                        value="{{ old('tanggal_lahir_ibu', $orangtua->tanggal_lahir_ibu) }}">
                    @error('tanggal_lahir_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="agama_ibu" class="form-label">Agama Ibu</label>
                    <input type="text" name="agama_ibu" id="agama_ibu"
                        class="form-control @error('agama_ibu') is-invalid @enderror"
                        value="{{ old('agama_ibu', $orangtua->agama_ibu) }}">
                    @error('agama_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="kewarganegaraan_ibu" class="form-label">Kewarganegaraan Ibu</label>
                    <input type="text" name="kewarganegaraan_ibu" id="kewarganegaraan_ibu"
                        class="form-control @error('kewarganegaraan_ibu') is-invalid @enderror"
                        value="{{ old('kewarganegaraan_ibu', $orangtua->kewarganegaraan_ibu) }}">
                    @error('kewarganegaraan_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                    <input type="text" name="pendidikan_ibu" id="pendidikan_ibu"
                        class="form-control @error('pendidikan_ibu') is-invalid @enderror"
                        value="{{ old('pendidikan_ibu', $orangtua->pendidikan_ibu) }}">
                    @error('pendidikan_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu"
                        class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                        value="{{ old('pekerjaan_ibu', $orangtua->pekerjaan_ibu) }}">
                    @error('pekerjaan_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="no_telepon_ibu" class="form-label">No. Telepon Ibu</label>
                    <input type="text" name="no_telepon_ibu" id="no_telepon_ibu"
                        class="form-control @error('no_telepon_ibu') is-invalid @enderror"
                        value="{{ old('no_telepon_ibu', $orangtua->no_telepon_ibu) }}">
                    @error('no_telepon_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="alamat_rumah_ibu" class="form-label">Alamat Ibu</label>
                    <textarea name="alamat_rumah_ibu" id="alamat_rumah_ibu"
                        class="form-control @error('alamat_rumah_ibu') is-invalid @enderror">{{ old('alamat_rumah_ibu', $orangtua->alamat_rumah_ibu) }}</textarea>
                    @error('alamat_rumah_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('profil-siswa.orangtua') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
