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
                    <h2 class="fw-bold text-success">
                        <i class="bi bi-journal-text me-2"></i> Detail Tema
                    </h2>
                    <p class="text-muted">Informasi lengkap mengenai tema yang dipilih</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-bookmark-check-fill me-2"></i> Informasi Tema</span>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title mb-3 text-success fw-bold">
                            {{ $tematk->tema }}
                        </h4>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <i class="bi bi-person-fill me-2 text-secondary"></i>
                                <strong>Kelas:</strong> {{ $tematk->kelas }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-person-badge-fill me-2 text-secondary"></i>
                                <strong>Usia:</strong> {{ $tematk->usia }} tahun
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-clock-history me-2 text-secondary"></i>
                                <strong>Waktu (minggu):</strong> {{ $tematk->waktu }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-person-workspace me-2 text-secondary"></i>
                                <strong>Guru:</strong> {{ $tematk->guru->nama ?? '-' }}
                            </li>
                            @if ($tematk->tanggal_mulai)
                                <li class="list-group-item">
                                    <i class="bi bi-calendar-event me-2 text-secondary"></i>
                                    <strong>Tanggal Mulai:</strong>
                                    {{ \Carbon\Carbon::parse($tematk->tanggal_mulai)->format('d M Y') }}
                                </li>
                                @if (isset($tanggal_berakhir))
                                    <li class="list-group-item">
                                        <i class="bi bi-calendar-check me-2 text-secondary"></i>
                                        <strong>Tanggal Berakhir:</strong>
                                        {{ $tanggal_berakhir->format('d M Y') }}
                                    </li>
                                @endif
                            @endif
                        </ul>

                        <div class="border-top pt-3 mb-3">
                            <p class="mb-1">
                                <span class="badge bg-dark">
                                    <i class="bi bi-clock me-1"></i> Waktu Input
                                </span>
                                <small class="text-muted ms-2">
                                    {{ $tematk->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </small>
                            </p>
                            <p class="mb-0">
                                <span class="badge bg-dark">
                                    <i class="bi bi-clock-history me-1"></i> Waktu Update
                                </span>
                                <small class="text-muted ms-2">
                                    {{ $tematk->updated_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </small>
                            </p>
                        </div>

                    </div>

                    <div class="card-footer bg-light text-end">
                        <a href="{{ route('tematk.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('tematk.edit', $tematk->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
