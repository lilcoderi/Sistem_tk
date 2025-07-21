@extends('kepala_sekolah.layouts.app')

@section('title')
    Penilaian Pembelajaran
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <a href="{{ route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa]) }}">Penilaian
                                Pembelajaran</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-success">
                <i class="bi bi-card-checklist me-2"></i> Detail Penilaian - {{ $asesmen->siswa->nama_lengkap ?? '-' }}
            </h3>
            <a href="{{ route('detail-asesmen.create', ['id_siswa' => $asesmen->id_siswa]) }}"
                class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Penilaian
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Filter Lingkup --}}
        <form method="GET" action="{{ route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa]) }}"
            class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="lingkup_id" class="form-label fw-semibold">Filter Lingkup Perkembangan</label>
                    <select name="lingkup_id" id="lingkup_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Lingkup --</option>
                        @foreach ($lingkupOptions as $lingkup)
                            <option value="{{ $lingkup->id }}" {{ $selectedLingkup == $lingkup->id ? 'selected' : '' }}>
                                {{ $lingkup->nama_lingkup }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- Tombol Kembali --}}
        <a href="{{ route('asesmen.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        {{-- Tabel Penilaian --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Rencana Pembelajaran</th>
                        <th style="width: 130px;">Skala Nilai</th> {{-- Lebar cukup untuk 4 bintang --}}
                        <th>Waktu Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{!! nl2br(e($item->modulAjar->rencana_pembelajaran ?? '-')) !!}</td>
                            <td class="text-center" style="white-space: nowrap;">
                                @php
                                    $skalaMap = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
                                    $bintang = $skalaMap[$item->skala_nilai] ?? 0;
                                @endphp
                                <div class="d-flex justify-content-center gap-1">
                                    @for ($i = 1; $i <= 4; $i++)
                                        <i
                                            class="bi bi-star-fill {{ $i <= $bintang ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td class="text-center">{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('detail-asesmen.edit', $item->id_detail) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('detail-asesmen.destroy', $item->id_detail) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Data detail asesmen akan dihapus secara permanen.')"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon rounded shadow-sm"
                                            title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data detail asesmen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>



        {{-- Styling Pagination (opsional jika pakai paginate) --}}
        {{-- 
    <div class="d-flex justify-content-center mt-3">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
    --}}

        {{-- Custom Style --}}
        <style>
            .btn-icon {
                width: 36px;
                height: 36px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmHapusUmum(event, form, pesan = 'Data akan dihapus.') {
            event.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: pesan,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

            return false;
        }
    </script>

@endsection
