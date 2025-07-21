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
                            <a href="{{ route('tematk.index') }}">Tema Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detail Tema
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">📚 Detail Subtema</h2>
                    <p class="text-muted">Informasi lengkap mengenai subtema yang dipilih</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-info-circle-fill me-2"></i>Informasi Subtema</span>
                    </div>
                    <div class="card-body">

                        <h4 class="card-title mb-3">{{ $subtema->sub_tema }}</h4>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <strong>🕒 Waktu (per minggu):</strong>
                                <span class="badge bg-info text-dark">{{ $subtema->waktu }}</span>
                            </li>
                            <li class="list-group-item">
                                <strong>📌 Tema:</strong>
                                {{ $subtema->tematk->tema ?? '-' }}
                            </li>
                            <li class="list-group-item">
                                <strong>📓 Kelas:</strong>
                                {{ $subtema->tematk->kelas ?? '-' }}
                            </li>
                            @if ($subtema->tanggal_mulai)
                                <li class="list-group-item">
                                    <strong>📅 Tanggal Mulai:</strong>
                                    {{ \Carbon\Carbon::parse($subtema->tanggal_mulai)->format('d M Y') }}
                                </li>
                                @if (isset($tanggal_berakhir))
                                    <li class="list-group-item">
                                        <strong>📅 Tanggal Berakhir:</strong>
                                        {{ $tanggal_berakhir->format('d M Y') }}
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer bg-light text-end">
                        <a href="{{ route('subtema.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('subtema.edit', $subtema->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
