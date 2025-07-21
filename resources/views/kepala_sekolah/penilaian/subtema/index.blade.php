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
                            <a href="javascript:void(0)">Penilaian Asesmen</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('subtema.index') }}">Sub Tema Pembelajaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <div class="container my-5">

        {{-- Judul Halaman --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-list-task me-2"></i> Daftar Subtema
            </h2>
            <p class="text-muted">Kelola subtema pembelajaran berdasarkan tema utama dan tanggal mulai</p>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Filter + Tambah Tombol dalam Satu Baris --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
            {{-- Form Filter Tema & Sort --}}
            <form method="GET" action="{{ route('subtema.index') }}" class="d-flex align-items-center gap-3 flex-wrap">

                {{-- Filter Kelas --}}
                <div class="d-flex align-items-center gap-2">
                    <label for="kelas" class="form-label mb-0 fw-semibold">Kelas:</label>
                    <select name="kelas" id="kelas" class="form-select" style="min-width: 120px;"
                        onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        <option value="A" {{ request('kelas') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>B</option>
                    </select>
                </div>


                {{-- Filter Tema --}}
                <div class="d-flex align-items-center gap-2">
                    <label for="tema_id" class="form-label mb-0 fw-semibold">Tema:</label>
                    <select name="tema_id" id="tema_id" class="form-select" style="min-width: 200px;"
                        onchange="this.form.submit()">
                        <option value="">-- Semua Tema --</option>
                        @foreach ($temats as $tema)
                            <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>
                                {{ $tema->tema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort Tanggal --}}
                <div class="d-flex align-items-center gap-2">
                    <label for="sort" class="form-label mb-0 fw-semibold">Urutkan:</label>
                    <select name="sort" id="sort" class="form-select" style="min-width: 200px;"
                        onchange="this.form.submit()">
                        <option value="">-- Tanggal Mulai --</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Mulai Terlama
                        </option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Mulai Terbaru
                        </option>
                    </select>
                </div>
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('subtema.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-patch-plus"></i> Tambah Subtema
            </a>
        </div>

        {{-- Tabel Subtema --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Sub Tema</th>
                        <th>Kelas</th>
                        <th style="width: 140px;">Tanggal Mulai</th>
                        <th style="width: 100px;">Waktu</th>
                        <th>Tema</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subtemas as $subtema)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $subtema->sub_tema }}</td>
                            <td class="text-center">{{ $subtema->tematk->kelas ?? '-' }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($subtema->tanggal_mulai)->format('d-m-Y') }}
                            </td>
                            <td class="text-center">{{ $subtema->waktu }}</td>
                            <td>{{ $subtema->tematk->tema ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('subtema.show', $subtema->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('subtema.edit', $subtema->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('subtema.destroy', $subtema->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Subtema ini akan dihapus secara permanen.')"
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
                            <td colspan="6" class="text-center text-muted fst-italic py-4">Tidak ada data subtema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $subtemas->links('pagination::bootstrap-4') }}
        </div>

        {{-- Info Pagination --}}
        <div class="text-center text-muted mt-2 mb-4">
            Menampilkan {{ $subtemas->firstItem() ?? 0 }} sampai {{ $subtemas->lastItem() ?? 0 }} dari
            {{ $subtemas->total() }} entri
        </div>

        {{-- Styling Custom Pagination --}}
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
