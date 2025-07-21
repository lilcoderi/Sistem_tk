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
        <div class="page-header mb-3">
            <h3>Edit Kegiatan TK</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada masalah dengan inputanmu.<br><br>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
                <input type="date" name="tanggal" class="form-control" id="tanggal"
                    value="{{ old('tanggal', $kegiatan->tanggal) }}" required>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Kegiatan</label>
                <input type="text" name="judul" class="form-control" id="judul"
                    value="{{ old('judul', $kegiatan->judul) }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="4">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('kegiatan.calendar') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
