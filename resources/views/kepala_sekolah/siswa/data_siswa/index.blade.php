@extends('kepala_sekolah.layouts.app')

@section('title')
    Data Siswa
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
                            <a href="javascript:void(0)">Siswa/Siswi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('data-siswa.index') }}">Data Siswa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">

        {{-- Header --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-people-fill me-2"></i> Data Siswa
            </h2>
            <p class="text-muted">Informasi lengkap siswa berdasarkan kelompok dan identitas</p>
        </div>

        {{-- Tombol Tambah --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('data-siswa.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-person-plus"></i> Tambah Data
            </a>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Filter Kelompok, Pencarian & Sort --}}
        <form method="GET" class="mb-4">
            <div class="row g-2 align-items-center flex-wrap">

                {{-- Filter Kelompok --}}
                <div class="col-auto">
                    <label for="kelompok" class="col-form-label">Kelompok:</label>
                </div>
                <div class="col-auto">
                    <select name="kelompok" id="kelompok" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                        <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                    </select>
                </div>

                {{-- Filter Tahun Pendaftaran --}}
                <div class="col-auto">
                    <select name="tahun" id="tahun" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Tahun Angkatan --</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Pencarian --}}
                <div class="col-auto">
                    <input type="text" name="search" class="form-control shadow-sm" placeholder="Cari nama siswa..."
                        value="{{ request('search') }}">
                </div>

                {{-- Urutan Nama --}}
                <div class="col-auto">
                    <select name="sort" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>

                {{-- Tombol Reset --}}
                @if (request()->hasAny(['kelompok', 'search', 'sort']))
                    <div class="col-auto">
                        <a href="{{ route('data-siswa.index') }}" class="btn btn-outline-secondary shadow-sm px-3"
                            style="height: 38px; display: flex; align-items: center;">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                    </div>
                @endif
            </div>
        </form>

        {{-- Tabel Data --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Tempat & Tanggal Lahir</th>
                        <th>Kelompok</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $siswa)
                        <tr>
                            <td class="text-center">
                                {{ $siswa->pendaftaran->id_pendaftaran ?? '-' }}
                            </td>
                            <td>{{ $siswa->nik }}</td>
                            <td>{{ $siswa->nama_lengkap }}</td>
                            <td>
                                {{ $siswa->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d M Y') }}
                            </td>
                            <td class="text-center">{{ $siswa->kelompok }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('data-siswa.show', $siswa->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('data-siswa.edit', $siswa->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('data-siswa.destroy', $siswa->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event, this)" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-icon rounded shadow-sm" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted fst-italic py-4">
                                Tidak ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>

        <div class="text-center text-muted mt-2 mb-4">
            Menampilkan {{ $data->firstItem() ?? 0 }} sampai {{ $data->lastItem() ?? 0 }} dari total {{ $data->total() }}
            data
        </div>

        {{-- Custom Pagination Style --}}
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(event, form) {
            event.preventDefault(); // cegah form langsung submit

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit form jika dikonfirmasi
                }
            });

            return false; // tetap false untuk cegah submit default
        }
    </script>
@endsection
