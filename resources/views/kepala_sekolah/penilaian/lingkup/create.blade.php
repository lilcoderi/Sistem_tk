@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Lingkup Pembelajaran
@endsection

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
                            <a href="{{ route('lingkup.create') }}">Tambah Lingkup Pembelajaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-header bg-gradient-success text-white text-center rounded-top-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-plus-square-fill me-2"></i> Tambah Lingkup Perkembangan
                        </h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('lingkup.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="kurikulum_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-journals me-1"></i> Kurikulum
                                </label>
                                <select class="form-select form-control-lg border-3 shadow-sm @error('kurikulum_id') is-invalid @enderror"
                                    id="kurikulum_id" name="kurikulum_id" required>
                                    <option value="">-- Pilih Kurikulum --</option>
                                    @foreach ($kurikulums as $kurikulum)
                                        <option value="{{ $kurikulum->id }}"
                                            {{ old('kurikulum_id') == $kurikulum->id ? 'selected' : '' }}>
                                            {{ $kurikulum->nama }} ({{ $kurikulum->tahun }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kurikulum_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nama_lingkup" class="form-label fw-semibold text-success">
                                    <i class="bi bi-tags-fill me-1"></i> Nama Lingkup
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg border-3 shadow-sm @error('nama_lingkup') is-invalid @enderror"
                                    id="nama_lingkup" name="nama_lingkup" value="{{ old('nama_lingkup') }}" required>
                                @error('nama_lingkup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tujuan_pembelajaran" class="form-label fw-semibold text-success">
                                    <i class="bi bi-flag-fill me-1"></i> Tujuan Pembelajaran
                                </label>
                                <textarea class="form-control form-control-lg border-3 shadow-sm @error('tujuan_pembelajaran') is-invalid @enderror"
                                    id="tujuan_pembelajaran" name="tujuan_pembelajaran" rows="3">{{ old('tujuan_pembelajaran') }}</textarea>
                                @error('tujuan_pembelajaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="deskripsi" class="form-label fw-semibold text-success">
                                    <i class="bi bi-card-text me-1"></i> Deskripsi
                                </label>
                                <textarea class="form-control form-control-lg border-3 shadow-sm @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
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
                                    <i class="bi bi-check2-circle me-2"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-success {
            background: linear-gradient(90deg, #198754 0%, #2ecc71 100%);
        }
    </style>
@endsection