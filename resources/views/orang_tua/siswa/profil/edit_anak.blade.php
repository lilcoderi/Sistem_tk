@extends('orang_tua.layouts.app')

@section('title')
    Edit Profil Anak
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
                            <a href="javascript:void(0)">Siswa/Siswi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('profil-siswa.orangtua') }}">Profil Siswa</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Edit Profil Anak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h1 class="mb-4">Edit Profil Anak</h1>

        <form action="{{ route('profil-anak.update', $siswa->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ $siswa->nama_lengkap }}" required>
            </div>

            <div class="mb-3">
                <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                <input type="text" name="nama_panggilan" class="form-control" value="{{ $siswa->nama_panggilan }}">
            </div>

            <div class="mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ $siswa->tempat_lahir }}">
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $siswa->tanggal_lahir }}">
            </div>

            <div class="mb-3">
                <label for="alamat_rumah" class="form-label">Alamat Rumah</label>
                <textarea name="alamat_rumah" class="form-control">{{ $siswa->alamat_rumah }}</textarea>
            </div>

            <div class="mb-3">
                <label for="agama" class="form-label">Agama</label>
                <input type="text" name="agama" class="form-control" value="{{ $siswa->agama }}">
            </div>

            <div class="mb-3">
                <label for="anak_ke" class="form-label">Anak ke-</label>
                <input type="number" name="anak_ke" class="form-control" value="{{ $siswa->anak_ke }}">
            </div>

            <div class="mb-3">
                <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                <input type="number" name="jumlah_saudara" class="form-control" value="{{ $siswa->jumlah_saudara }}">
            </div>

            <div class="mb-3">
                <label for="bahasa_sehari_hari" class="form-label">Bahasa Sehari-hari</label>
                <input type="text" name="bahasa_sehari_hari" class="form-control"
                    value="{{ $siswa->bahasa_sehari_hari }}">
            </div>

            <div class="mb-3">
                <label for="golongan_darah" class="form-label">Golongan Darah</label>
                <input type="text" name="golongan_darah" class="form-control" value="{{ $siswa->golongan_darah }}">
            </div>

            <div class="mb-3">
                <label for="ciri_khusus" class="form-label">Ciri Khusus</label>
                <textarea name="ciri_khusus" class="form-control">{{ $siswa->ciri_khusus }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('profil-siswa.orangtua') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
