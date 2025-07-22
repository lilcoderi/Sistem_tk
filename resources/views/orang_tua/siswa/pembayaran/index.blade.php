@extends('orang_tua.layouts.app')

@section('title')
    Riwayat Pembayaran
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <!-- Breadcrumb -->
    <div class="page-header mb-4">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="#"><i class="bi bi-wallet2 me-1"></i> Pembayaran</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('orangtua.pembayaran.index') }}">Riwayat</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container py-3">
        <h3 class="fw-bold text-success mb-4">
            <i class="bi bi-cash-stack me-2"></i>Riwayat Pembayaran Anak
        </h3>

        @if ($pembayaranList->count() > 0)
            @foreach ($pembayaranList as $pembayaran)
                <div class="bg-white p-4 rounded shadow-sm mb-4 border-start border-4 border-success">
                    <h5 class="text-primary fw-bold mb-3">
                        <i class="bi bi-person-fill me-2"></i>{{ $pembayaran->identitas_anak->nama_lengkap ?? '-' }}
                    </h5>

                    <div class="row fs-6">
                        <div class="col-md-4 mb-2">
                            <i class="bi bi-card-heading text-success me-2"></i><strong>ID Pendaftaran:</strong>
                            {{ $pembayaran->id_pendaftaran }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="bi bi-calendar-event text-success me-2"></i><strong>Tanggal:</strong>
                            {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->translatedFormat('d F Y') }}
                        </div>
                        <div class="col-md-4 mb-2">
                            <i class="bi bi-flag text-success me-2"></i><strong>Status:</strong>
                            @if ($pembayaran->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($pembayaran->status === 'verifikasi')
                                <span class="badge bg-success">Diterima</span>
                            @elseif ($pembayaran->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Status Tidak Diketahui</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <strong><i class="bi bi-file-image me-2 text-success"></i>Bukti Pembayaran:</strong><br>
                        @if ($pembayaran->bukti_pembayaran)
                            <div class="text-center mt-2">
                                <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                    class="img-fluid rounded border" style="max-height: 250px; object-fit: cover;">
                            </div>
                        @else
                            <div class="text-muted mt-2">Belum ada bukti pembayaran.</div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle me-2"></i>Belum ada data pembayaran ditemukan.
            </div>
        @endif
    </div>
@endsection
