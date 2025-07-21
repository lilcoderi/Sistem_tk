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
                            <a href="{{ route('tematk.index') }}">Tema Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('tematk.create') }}">Tambah Tema Pembelajaran</a>
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
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-gradient-success text-white text-center rounded-top-3">
                        <h3 class="mb-0 fw-bold">
                            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Tema TK
                        </h3>
                    </div>
                    <div class="card-body px-5 py-4">

                        <form action="{{ route('tematk.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="tema" class="form-label fw-semibold text-success">
                                    <i class="bi bi-bookmark-fill me-1"></i> Tema
                                </label>
                                <input type="text" name="tema" id="tema"
                                    class="form-control form-control-lg border-3 shadow-sm" value="{{ old('tema') }}"
                                    required placeholder="Masukkan tema pembelajaran...">
                            </div>

                            <div class="mb-4">
                                <label for="kelas" class="form-label fw-semibold text-success">
                                    <i class="bi bi-people-fill me-1"></i> Kelas
                                </label>
                                <select name="kelas" id="kelas" class="form-select form-select-lg border-3 shadow-sm"
                                    required>
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                    <option value="A" {{ old('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                                    <option value="B" {{ old('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="usia" class="form-label fw-semibold text-success">
                                    <i class="bi bi-calendar3 me-1"></i> Usia
                                </label>
                                <select name="usia" id="usia" class="form-select form-select-lg border-3 shadow-sm"
                                    required>
                                    <option value="" disabled selected>-- Pilih Usia --</option>
                                    <option value="4" {{ old('usia') == '4' ? 'selected' : '' }}>4 Tahun</option>
                                    <option value="5" {{ old('usia') == '5' ? 'selected' : '' }}>5 Tahun</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="waktu" class="form-label fw-semibold text-success">
                                    <i class="bi bi-clock-history me-1"></i> Waktu (minggu)
                                </label>
                                <input type="number" name="waktu" id="waktu"
                                    class="form-control form-control-lg border-3 shadow-sm" min="1"
                                    value="{{ old('waktu') }}" required placeholder="Masukkan durasi waktu dalam minggu">
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_mulai" class="form-label fw-semibold text-success">
                                    <i class="bi bi-calendar-event me-1"></i> Tanggal Mulai
                                </label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                    class="form-control form-control-lg border-3 shadow-sm"
                                    value="{{ old('tanggal_mulai') }}" required>
                            </div>

                            <div class="mb-5">
                                <label for="guru_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-person-badge-fill me-1"></i> Guru
                                </label>
                                <select name="guru_id" id="guru_id" class="form-select form-select-lg border-3 shadow-sm"
                                    required>
                                    <option value="" disabled selected>-- Pilih Guru --</option>
                                    @foreach ($guru as $g)
                                        <option value="{{ $g->id }}"
                                            {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('tematk.index') }}"
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
            background: linear-gradient(90deg, #198754 0%, #3cd070 100%);
        }
    </style>
@endsection
