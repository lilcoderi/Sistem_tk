@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Rapor DDTK
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Sistem Pakar</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rapor.index') }}">Data DDTK</a></li>
                        <li class="breadcrumb-item active">Detail Rapor DDTK</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <h2 class="fw-bold text-success"><i class="bi bi-book me-2"></i> Laporan Rapor Siswa</h2>
        <p class="text-muted">Berikut adalah hasil deskriptif perkembangan siswa berdasarkan hasil asesmen.</p>
    </div>

    {{-- Identitas Siswa --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Identitas Siswa</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nama Siswa:</strong> {{ $siswa->nama_lengkap }}</li>
                <li class="list-group-item"><strong>Tanggal Lahir:</strong>
                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</li>
                <li class="list-group-item"><strong>Umur:</strong> {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }}
                    Tahun</li>
            </ul>
        </div>
    </div>

    {{-- Pertumbuhan --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Pertumbuhan</h5>
            <ul>
                <li><strong>Berat Badan:</strong> {{ $tumbuh->berat_badan }} kg</li>
                <li><strong>Tinggi Badan:</strong> {{ $tumbuh->tinggi_badan }} cm</li>
                <li><strong>Lingkar Kepala:</strong> {{ $tumbuh->lingkar_kepala }} cm</li>
            </ul>
            <p>{{ $rapor->pertumbuhan }}</p>
        </div>
    </div>

    {{-- Nilai Agama dan Budi Pekerti --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Nilai Agama dan Budi Pekerti</h5>
            <p>{{ $rapor->nilai_agama }}</p>
        </div>
    </div>

    {{-- Jati Diri --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Jati Diri</h5>
            <p>{{ $rapor->jati_diri }}</p>
        </div>
    </div>

    {{-- Literasi dan STEAM --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Dasar Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni</h5>
            <p>{{ $rapor->literasi }}</p>
        </div>
    </div>

    {{-- Proyek Profil Pelajar Pancasila --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Proyek Penguatan Profil Pelajar Pancasila</h5>
            <p>{{ $rapor->profil_pancasila }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Saran, Rekomendasi, dan Harapan</h5>
            <p>{{ $rapor->saran }}</p>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="text-center mt-4">
        <a href="{{ route('rapor.cetak', $siswa->id) }}" class="btn btn-outline-danger me-2">
            <i class="bi bi-file-earmark-pdf"></i> Unduh PDF Rapor
        </a>
        <a href="{{ route('rapor.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Index
        </a>
    </div>
@endsection
