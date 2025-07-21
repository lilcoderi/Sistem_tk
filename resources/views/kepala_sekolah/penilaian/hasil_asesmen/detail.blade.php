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
                            <a href="{{ route('hasil-asesmen.index') }}">Daftar Penilaian</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Hasil Sistem Pakar
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    {{-- Alert error jika ada --}}
    @if (session('error'))
        <div class="alert alert-danger text-center">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">
            <i class="bi bi-robot me-2"></i> Hasil Asesmen Sistem Pakar
        </h2>
        <p class="text-muted">Tampilan hasil analisis perkembangan siswa berdasarkan asesmen ceklis</p>
    </div>

    {{-- Identitas Siswa --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-success mb-3">Identitas Siswa</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nama Siswa:</strong> {{ $hasil['nama_siswa'] ?? $nama_siswa }}</li>
                <li class="list-group-item"><strong>ID Siswa:</strong> {{ $hasil['id_siswa'] ?? $id_siswa }}</li>
                @if (!empty($hasil['tanggal_proses']))
                    <li class="list-group-item"><strong>Tanggal Proses:</strong> {{ $hasil['tanggal_proses'] }}</li>
                @endif
            </ul>
        </div>
    </div>

    @if (!$hasil)
        <div class="alert alert-warning text-center">
            <i class="bi bi-info-circle me-2"></i>
            Belum ada hasil sistem pakar untuk subtema ini.
        </div>
    @else
        {{-- Tabel Hasil Per Lingkup --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-success mb-3">Hasil Per Lingkup Perkembangan</h5>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>No</th>
                            <th>Lingkup Perkembangan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hasil['hasil_per_lingkup'] as $lingkup => $nilai)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $lingkup }}</td>
                                <td class="text-center">{{ $nilai }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted fst-italic">
                                    Belum ada data asesmen yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Rekomendasi --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-success mb-3">Rekomendasi Sistem</h5>
                @if (!empty($hasil['rekomendasi']))
                    <ul>
                        @foreach ($hasil['rekomendasi'] as $rek)
                            <li>{{ $rek }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted fst-italic">Tidak ada rekomendasi khusus.</p>
                @endif
            </div>
        </div>

        {{-- Catatan --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-success mb-3">Catatan Sistem Pakar</h5>
                @if (!empty($hasil['catatan']))
                    <ul>
                        @foreach ($hasil['catatan'] as $cat)
                            <li>{{ $cat }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted fst-italic">Tidak ada catatan tambahan.</p>
                @endif
            </div>
        </div> 
    @endif

    {{-- Tombol kembali --}}
    <div class="text-center">
        <a href="{{ route('hasil-asesmen.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Asesmen
        </a>
    </div>
@endsection
