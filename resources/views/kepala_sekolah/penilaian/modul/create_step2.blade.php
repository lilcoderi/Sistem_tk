@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Tema Pembelajaran
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
                            <a href="{{ route('modulAjar.createStep1') }}">Modul Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Modul Pembelajaran ke 2
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
                            <i class="bi bi-journal-bookmark me-2"></i> Input {{ $jumlah }} Modul Ajar
                        </h3>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('modulAjar.store') }}" method="POST" novalidate>
                            @csrf

                            <input type="hidden" name="lingkup_id" value="{{ $lingkup_id }}">
                            <input type="hidden" name="subtema_id" value="{{ $subtema_id }}">
                            <input type="hidden" name="ceklis_anekdot" value="{{ $ceklis_anekdot }}">
                            <input type="hidden" name="jumlah" value="{{ $jumlah }}">

                            @for ($i = 0; $i < $jumlah; $i++)
                                <div class="card mb-4 border-3 shadow-sm">
                                    <div class="card-header bg-success text-white fw-semibold">
                                        Modul Ajar #{{ $i + 1 }}
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="moduls_{{ $i }}_rencana"
                                                class="form-label fw-semibold text-success">
                                                <i class="bi bi-pencil-square me-1"></i> Rencana Pembelajaran
                                            </label>
                                            <textarea name="moduls[{{ $i }}][rencana_pembelajaran]" id="moduls_{{ $i }}_rencana"
                                                class="form-control form-control-lg border-3 shadow-sm" rows="4" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success fw-semibold shadow-sm px-5">
                                    <i class="bi bi-check2-circle me-2"></i> Simpan Semua Modul
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
