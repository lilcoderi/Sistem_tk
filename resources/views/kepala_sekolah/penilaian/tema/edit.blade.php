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

    <!-- Form Card -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-header bg-gradient-primary text-white text-center rounded-top-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-fill me-2"></i> Edit Tema TK
                        </h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form method="POST" action="{{ route('tematk.update', $tematk->id) }}"  novalidate>
                            @csrf
                            @method('PUT')
                            

                            <div class="mb-4">
                                <label for="tema" class="form-label fw-semibold text-success">
                                    <i class="bi bi-bookmark-fill me-1"></i> Tema
                                </label>
                                <input type="text" id="tema" name="tema"
                                    class="form-control form-control-lg border-3 shadow-sm" value="{{ $tematk->tema }}"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="kelas" class="form-label fw-semibold text-success">
                                    <i class="bi bi-people-fill me-1"></i> Kelas
                                </label>
                                <input type="text" id="kelas" name="kelas"
                                    class="form-control form-control-lg border-3 shadow-sm" value="{{ $tematk->kelas }}"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="usia" class="form-label fw-semibold text-success">
                                    <i class="bi bi-calendar3 me-1"></i> Usia (tahun)
                                </label>
                                <input type="number" id="usia" name="usia" min="1"
                                    class="form-control form-control-lg border-3 shadow-sm" value="{{ $tematk->usia }}"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="waktu" class="form-label fw-semibold text-success">
                                    <i class="bi bi-clock-history me-1"></i> Waktu (minggu)
                                </label>
                                <input type="text" id="waktu" name="waktu"
                                    class="form-control form-control-lg border-3 shadow-sm" value="{{ $tematk->waktu }}"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_mulai" class="form-label fw-semibold text-success">
                                    <i class="bi bi-calendar-event me-1"></i> Tanggal Mulai
                                </label>
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                    class="form-control form-control-lg border-3 shadow-sm"
                                    value="{{ $tematk->tanggal_mulai }}" required>
                            </div>

                            <div class="mb-5">
                                <label for="guru_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-person-badge-fill me-1"></i> Guru
                                </label>
                                <select id="guru_id" name="guru_id" class="form-select form-select-lg border-3 shadow-sm"
                                    required>
                                    @foreach ($guru as $g)
                                        <option value="{{ $g->id }}"
                                            {{ $tematk->guru_id == $g->id ? 'selected' : '' }}>
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
                                    <i class="bi bi-check2-circle me-2"></i> Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional CSS for Gradient -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(90deg, #198754 0%, #20c997 100%);
        }
    </style>
@endsection
