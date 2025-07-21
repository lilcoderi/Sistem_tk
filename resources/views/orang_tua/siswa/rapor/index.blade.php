@extends('orang_tua.layouts.app')

@section('title')
    Rapor Anak
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
                            <a href="javascript:void(0)">Siswa/Siswa</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('orangtua.rapor.index') }}">Rapor Siswa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="fw-bold text-success"><i class="bi bi-journal-text me-2"></i>Rapor Anak</h2>
            </div>
        </div>

        @if ($siswaList->count() > 0)
            @foreach ($siswaList as $siswa)
                <div class="bg-white p-4 rounded shadow-sm mb-5 border-start border-4 border-success">
                    <h4 class="fw-semibold text-success mb-3">
                        <i class="bi bi-person-circle me-2"></i> {{ $siswa->nama_lengkap }}
                    </h4>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-2"><strong><i class="bi bi-people me-1"></i> Kelompok:</strong>
                            {{ $siswa->kelompok ?? '-' }}</div>
                        <div class="col-md-4 mb-2"><strong><i class="bi bi-card-heading me-1"></i> ID Pendaftaran:</strong>
                            {{ $siswa->id_pendaftaran }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-2"><strong><i class="bi bi-rulers me-1"></i> Tinggi Badan:</strong>
                            {{ $siswa->tumbuhKembang->tinggi_badan ?? '-' }} cm</div>
                        <div class="col-md-4 mb-2"><strong><i class="bi bi-person-fill-down me-1"></i> Berat Badan:</strong>
                            {{ $siswa->tumbuhKembang->berat_badan ?? '-' }} kg</div>
                        <div class="col-md-4 mb-2"><strong><i class="bi bi-circle-half me-1"></i> Lingkar Kepala:</strong>
                            {{ $siswa->tumbuhKembang->lingkar_kepala ?? '-' }} cm</div>
                    </div>

                    @if ($siswa->rapor)
                        <hr>
                        <div class="mb-3">
                            <h5 class="text-success fw-bold">Pertumbuhan:</h5>
                            <p>{{ $siswa->rapor->pertumbuhan }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-success fw-bold">Nilai Agama:</h5>
                            <p>{{ $siswa->rapor->nilai_agama }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-success fw-bold">Jati Diri:</h5>
                            <p>{{ $siswa->rapor->jati_diri }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-success fw-bold">Literasi:</h5>
                            <p>{{ $siswa->rapor->literasi }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-success fw-bold">Profil Pancasila:</h5>
                            <p>{{ $siswa->rapor->profil_pancasila }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-success fw-bold">Saran & Rekomendasi:</h5>
                            <p>{{ $siswa->rapor->saran }}</p>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('rapor.cetak', $siswa->id) }}" class="btn btn-outline-success">
                                <i class="bi bi-download me-1"></i> Unduh PDF
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning mt-3">Rapor belum tersedia.</div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i> Belum ada data rapor yang tersedia.
            </div>
        @endif
    </div>
@endsection
