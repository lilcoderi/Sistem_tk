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
                            <a href="javascript:void(0)">Penilaian Asesmen</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('lingkup.index') }}">Lingkup Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('lingkup.create') }}">Edit Lingkup Pembelajaran</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-header bg-gradient-primary text-white text-center rounded-top-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-box-seam me-2"></i> Edit Lingkup Perkembangan
                        </h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('lingkup.update', $lingkup->id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="nama_lingkup" class="form-label fw-semibold text-success">
                                    <i class="bi bi-tag-fill me-1"></i> Nama Lingkup
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg border-3 shadow-sm @error('nama_lingkup') is-invalid @enderror"
                                    id="nama_lingkup" name="nama_lingkup"
                                    value="{{ old('nama_lingkup', $lingkup->nama_lingkup) }}" required>
                                @error('nama_lingkup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tujuan_pembelajaran" class="form-label fw-semibold text-success">
                                    <i class="bi bi-flag-fill me-1"></i> Tujuan Pembelajaran
                                </label>
                                <textarea class="form-control form-control-lg border-3 shadow-sm @error('tujuan_pembelajaran') is-invalid @enderror"
                                    id="tujuan_pembelajaran" name="tujuan_pembelajaran" rows="4">{{ old('tujuan_pembelajaran', $lingkup->tujuan_pembelajaran) }}</textarea>
                                @error('tujuan_pembelajaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="deskripsi" class="form-label fw-semibold text-success">
                                    <i class="bi bi-card-text me-1"></i> Deskripsi
                                </label>
                                <textarea class="form-control form-control-lg border-3 shadow-sm @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $lingkup->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('lingkup.index') }}"
                                    class="btn btn-outline-danger fw-semibold shadow-sm px-4">
                                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success fw-semibold shadow-sm px-5">
                                    <i class="bi bi-check2-circle me-2"></i> Perbarui
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(90deg, #198754 0%, #20c997 100%);
        }
    </style>
@endsection
