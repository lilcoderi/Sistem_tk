@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Prediksi DDTK
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Sistem Pakar</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('ddtk.index') }}">Data DDTK</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Detail Prediksi DDTK
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">
            <i class="bi bi-activity me-2"></i> Hasil Prediksi DDTK
        </h2>
        <p class="text-muted">Berikut adalah hasil analisis dan rekomendasi sistem pakar berdasarkan perkembangan anak.</p>
    </div>

    {{-- Identitas Siswa --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Identitas Siswa</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nama Siswa:</strong> {{ $ddtk->siswa->nama_lengkap ?? '-' }}</li>
                <li class="list-group-item"><strong>Tanggal Proses:</strong> {{ $ddtk->updated_at->format('d M Y, H:i') }}</li>
            </ul>
        </div>
    </div>

    {{-- Hasil Prediksi --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Hasil Prediksi</h5>
            <div class="alert alert-info">
                {{ $ddtk->hasil_ddtk ?? 'Belum ada hasil prediksi.' }}
            </div>
        </div>
    </div>

    {{-- Rekomendasi --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Rekomendasi Sistem</h5>
            @if (!empty($ddtk->rekomendasi))
                <ul>
                    @foreach (explode("\n", $ddtk->rekomendasi) as $rek)
                        @if (!empty(trim($rek)))
                            <li>{{ $rek }}</li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p class="text-muted fst-italic">Tidak ada rekomendasi khusus.</p>
            @endif
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Keterangan Sistem Pakar</h5>
            @if (!empty($ddtk->keterangan))
                <p>{!! nl2br(e($ddtk->keterangan)) !!}</p>
            @else
                <p class="text-muted fst-italic">Tidak ada keterangan tambahan.</p>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="text-center">
        <a href="{{ route('ddtk.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data DDTK
        </a>
    </div>
@endsection
