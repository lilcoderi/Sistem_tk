@extends('kepala_sekolah.layouts.app')

@section('title')
    Tema Pembelajaran
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
                            <a href="{{ route('konfirmasi-pembayaran.index') }}">Pembayaran Pendaftaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">

        {{-- Judul halaman --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-cash-stack me-2"></i> Daftar Pembayaran
            </h2>
            <p class="text-muted">Pantau dan verifikasi status pembayaran siswa</p>
        </div>

        <form action="{{ route('konfirmasi-pembayaran.index') }}" method="GET"
            class="mb-4 d-flex flex-wrap gap-2 justify-content-center">

            {{-- Filter Status --}}
            <select name="status" class="form-select shadow-sm w-auto">
                <option value="">-- Semua Status --</option>
                @foreach ($statusOptions as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            {{-- Filter Tahun dari id_pendaftaran --}}
            <select name="tahun" class="form-select shadow-sm w-auto">
                <option value="">-- Semua Tahun --</option>
                @foreach ($tahunOptions as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-outline-success shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-filter-circle"></i> <span>Filter</span>
            </button>
            <a href="{{ route('konfirmasi-pembayaran.index') }}"
                class="btn btn-outline-secondary shadow-sm d-flex align-items-center gap-1">
                <i class="bi bi-x-circle"></i> <span>Reset</span>
            </a>
        </form>


        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayaran as $index => $p)
                        <tr>
                            <td class="text-center">{{ $p->id_pendaftaran }}</td>
                            <td>{{ $p->identitas_anak->nama_lengkap ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d M Y') }}
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge bg-{{ $p->status == 'verifikasi' ? 'success' : ($p->status == 'ditolak' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($p->bukti_pembayaran)
                                    <button type="button" class="btn btn-outline-info btn-sm shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalPreview{{ $p->id }}">
                                        <i class="bi bi-image"></i> Lihat
                                    </button>

                                    {{-- Modal Preview --}}
                                    <div class="modal fade" id="modalPreview{{ $p->id }}" tabindex="-1"
                                        aria-labelledby="previewLabel{{ $p->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="previewLabel{{ $p->id }}">Bukti
                                                        Pembayaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $p->bukti_pembayaran) }}"
                                                        alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('konfirmasi-pembayaran.show', $p->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('konfirmasi-pembayaran.show', $p->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit Status">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted fst-italic py-4">
                                Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Styling Pagination (jika pakai pagination) --}}
        <style>
            .pagination .page-item.active .page-link {
                background-color: #198754;
                border-color: #198754;
                color: white;
            }

            .pagination .page-link:hover {
                background-color: #d1e7dd;
                color: #198754;
            }

            .pagination .page-link {
                border: 1px solid #198754;
                color: #198754;
            }
        </style>

    </div>
@endsection
