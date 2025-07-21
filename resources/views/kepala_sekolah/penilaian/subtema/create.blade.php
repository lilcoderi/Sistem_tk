@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Tema Pembelajaran
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
                            <a href="{{ route('subtema.index') }}">Sub Tema Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('subtema.create') }}">Tambah Sub Tema Pembelajaran</a>
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
                    <div class="card-header bg-gradient-primary text-white text-center rounded-top-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Subtema Baru
                        </h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('subtema.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="tema_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-bookmark-fill me-1"></i> Tema
                                </label>
                                <select name="tema_id" id="tema_id"
                                    class="form-select form-select-lg border-3 shadow-sm @error('tema_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Tema --</option>
                                    @foreach ($temats as $tema)
                                        <option value="{{ $tema->id }}"
                                            {{ old('tema_id') == $tema->id ? 'selected' : '' }}>
                                            {{ $tema->tema }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tema_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="sub_tema" class="form-label fw-semibold text-success">
                                    <i class="bi bi-bookmark-check-fill me-1"></i> Sub Tema
                                </label>
                                <input type="text" name="sub_tema" id="sub_tema"
                                    class="form-control form-control-lg border-3 shadow-sm @error('sub_tema') is-invalid @enderror"
                                    value="{{ old('sub_tema') }}" required>
                                @error('sub_tema')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_mulai" class="form-label fw-semibold text-success">
                                    <i class="bi bi-calendar-event me-1"></i> Tanggal Mulai
                                </label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="form-control form-control-lg border-3 shadow-sm @error('tanggal_mulai') is-invalid @enderror"
                                    value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
 
                            <div class="mb-5">
                                <label for="waktu" class="form-label fw-semibold text-success">
                                    <i class="bi bi-clock-history me-1"></i> Waktu (Durasi per minggu)
                                </label>
                                <input type="text" name="waktu" id="waktu"
                                    class="form-control form-control-lg border-3 shadow-sm @error('waktu') is-invalid @enderror"
                                    value="{{ old('waktu') }}" placeholder="Contoh: 3 minggu" required>
                                @error('waktu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('subtema.index') }}"
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
        .bg-gradient-primary {
            background: linear-gradient(90deg, #198754 0%, #20c997 100%);
        }
    </style>
@endsection
