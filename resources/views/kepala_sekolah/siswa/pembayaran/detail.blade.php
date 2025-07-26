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
                            <a href="{{ route('konfirmasi-pembayaran.index') }}">Tema Pembelajaran</a>
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
            <div class="col-md-10">

                {{-- Judul Halaman --}}
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">
                        <i class="bi bi-receipt-cutoff me-2"></i> Detail Pembayaran
                    </h2>
                    <p class="text-muted">Informasi lengkap mengenai pembayaran siswa</p>
                </div>

                {{-- Informasi Pembayaran --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-wallet-fill me-2"></i> Informasi Pembayaran</span>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="bi bi-person-fill text-secondary me-2"></i>
                                <strong>Nama Siswa:</strong> {{ $pembayaran->identitas_anak->nama_lengkap ?? '-' }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-calendar-event-fill text-secondary me-2"></i>
                                <strong>Tanggal Pembayaran:</strong> {{ $pembayaran->tanggal_pembayaran }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-info-circle-fill text-secondary me-2"></i>
                                <strong>Status Saat Ini:</strong> {{ ucfirst($pembayaran->status) }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-card-image text-secondary me-2"></i>
                                <strong>Bukti Pembayaran:</strong><br>
                                @if ($pembayaran->bukti_pembayaran)
                                    <img src="{{ $pembayaran->bukti_pembayaran }}"
                                        alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm mt-2"
                                        style="max-width: 400px;">
                                @else
                                    <span class="text-muted">Tidak ada bukti pembayaran.</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Form Ubah Status --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light fw-bold">
                        <i class="bi bi-pencil-square me-2 text-success"></i>Ubah Status Pembayaran
                    </div>
                    <div class="card-body">
                        <form action="{{ route('konfirmasi-pembayaran.update', $pembayaran->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="status" class="form-label"><strong>Status:</strong></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ $pembayaran->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="verifikasi" {{ $pembayaran->status == 'verifikasi' ? 'selected' : '' }}>
                                        Verifikasi</option>
                                    <option value="ditolak" {{ $pembayaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('konfirmasi-pembayaran.index') }}"
                                    class="btn btn-outline-secondary ms-2">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
