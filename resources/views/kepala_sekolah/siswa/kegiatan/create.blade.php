@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Data Siswa
@endsection

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
                            <a href="{{ route('kegiatan.calendar') }}">Kegiatan TK</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('kegiatan.create') }}">Tambah Kegiatan Siswa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="container my-5">
        <h3 class="fw-bold text-success mb-4">
            <i class="bi bi-plus-circle"></i> Tambah Kegiatan TK
        </h3>

        <form action="{{ route('kegiatan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control"
                    value="{{ old('tanggal', $tanggal ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Kegiatan</label>
                <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Kegiatan
                </button>
                <a href="{{ route('kegiatan.calendar') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
