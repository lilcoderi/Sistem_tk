@extends('kepala_sekolah.layouts.app')

@section('title')
    Tingkat Pencapaian Pembelajaran
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
                            <a href="{{ route('guru.index') }}">Modul Pembelajaran</a>
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
                <i class="bi bi-journal-bookmark-fill me-2"></i> Modul Pembelajaran
            </h2>
            <p class="text-muted">Kelola daftar rencana pembelajaran berdasarkan lingkup dan subtema</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Filter dengan icon di kiri --}}
            <form method="GET" action="{{ route('modulAjar.index') }}" class="d-flex align-items-center gap-2">

                {{-- Dropdown Subtema --}}
                <select name="subtema_id" onchange="this.form.submit()" class="form-select shadow-sm">
                    <option value="">-- Semua Subtema --</option>
                    @foreach ($allSubtemas as $subtema)
                        <option value="{{ $subtema->id }}" {{ $filterSubtema == $subtema->id ? 'selected' : '' }}>
                            {{ $subtema->sub_tema }}
                        </option>
                    @endforeach
                </select>


                <select name="lingkup_id" onchange="this.form.submit()" class="form-select shadow-sm">
                    <option value="">-- Semua Lingkup --</option>
                    @foreach ($lingkups as $lingkup)
                        <option value="{{ $lingkup->id }}" {{ $filterLingkup == $lingkup->id ? 'selected' : '' }}>
                            {{ $lingkup->nama_lingkup }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Kelas --}}
                <select name="kelas" onchange="this.form.submit()" class="form-select shadow-sm"
                    style="min-width: 160px;">
                    <option value="A" {{ request('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                    <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                </select>
            </form>

            <a href="{{ route('modulAjar.createStep1') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-patch-plus"></i> Tambah Modul Ajar
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($selectedTema)
            <div class="mt-2">
                <h3 class="fw-bold text-success">
                    <i class="bi bi-book me-2"></i> Tema: {{ $selectedTema }}
                </h3>
            </div>
        @endif


        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Kelas</th>
                        <th>Subtema</th>
                        <th>Lingkup</th>
                        <th>Rencana</th>
                        <th>Ceklis/Anekdot</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($moduls as $modul)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $modul->subtema->tematk->kelas ?? '-' }}</td>
                            <td>{{ $modul->subtema->sub_tema ?? '-' }}</td>
                            <td>{{ $modul->lingkup->nama_lingkup ?? '-' }}</td>
                            <td>{{ $modul->rencana_pembelajaran }}</td>
                            <td>{{ $modul->ceklis_anekdot }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('modulAjar.edit', $modul->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('modulAjar.delete', $modul->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Modul ajar akan dihapus secara permanen.')"
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
                            <td colspan="6" class="text-center text-muted fst-italic py-4">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $moduls->links('pagination::bootstrap-4') }}
        </div>

        {{-- Teks info pagination --}}
        <div class="text-center text-muted mt-2 mb-4">
            Showing {{ $moduls->firstItem() ?? 0 }} to {{ $moduls->lastItem() ?? 0 }} of {{ $moduls->total() }} results
        </div>

        {{-- Styling custom --}}
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
