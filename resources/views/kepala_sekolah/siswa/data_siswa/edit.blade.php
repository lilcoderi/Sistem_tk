@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Tema Pembelajaran
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
                            <a href="javascript:void(0)">Penilaian Asesmen</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('tematk.index') }}">Tema Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('tematk.create') }}">Edit Tema Pembelajaran</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h3>Edit Data Siswa</h3>

        <form action="{{ route('data-siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Nama Panggilan</label>
                        <input type="text" name="nama_panggilan"
                            value="{{ old('nama_panggilan', $siswa->nama_panggilan) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $siswa->nik) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Alamat Rumah</label>
                        <textarea name="alamat_rumah" class="form-control">{{ old('alamat_rumah', $siswa->alamat_rumah) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Agama</label>
                        <input type="text" name="agama" value="{{ old('agama', $siswa->agama) }}"
                            class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Kelompok</label>
                        <input type="text" name="kelompok" value="{{ old('kelompok', $siswa->kelompok) }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Saudara</label>
                        <input type="number" name="jumlah_saudara"
                            value="{{ old('jumlah_saudara', $siswa->jumlah_saudara) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Anak Ke</label>
                        <input type="number" name="anak_ke" value="{{ old('anak_ke', $siswa->anak_ke) }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Bahasa Sehari-hari</label>
                        <input type="text" name="bahasa_sehari_hari"
                            value="{{ old('bahasa_sehari_hari', $siswa->bahasa_sehari_hari) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Golongan Darah</label>
                        <input type="text" name="golongan_darah"
                            value="{{ old('golongan_darah', $siswa->golongan_darah) }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Ciri Khusus</label>
                        <textarea name="ciri_khusus" class="form-control">{{ old('ciri_khusus', $siswa->ciri_khusus) }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Perbarui</button>
            <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
