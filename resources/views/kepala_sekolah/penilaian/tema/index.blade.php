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
                            <a href="{{ route('guru.index') }}">Tema Pembelajaran</a>
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
                <i class="bi bi-list-task me-2"></i> Daftar Tema TK
            </h2>
            <p class="text-muted">Kelola tema pembelajaran berdasarkan kelas, usia, waktu, dan guru pengampu</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <form action="{{ route('tematk.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <label for="sort" class="form-label mb-0">Urutkan:</label>
                <select name="sort" id="sort" class="form-select w-auto shadow-sm" onchange="this.form.submit()">
                    <option value="">-- Tanggal Mulai --</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tanggal Mulai Terlama</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Tanggal Mulai Terbaru</option>
                </select>
            </form>

            <a href="{{ route('tematk.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-patch-plus"></i> Tambah Tema
            </a>
        </div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>#</th>
                        <th>Tema</th>
                        <th>Kelas</th>
                        <th>Usia</th>
                        <th>Waktu</th>
                        <th>Tanggal Mulai</th>
                        <th>Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tematk as $index => $item)
                        <tr>
                            <td class="text-center">{{ ($tematk->currentPage() - 1) * $tematk->perPage() + $index + 1 }}
                            </td>
                            <td>{{ $item->tema }}</td>
                            <td class="text-center">{{ $item->kelas }}</td>
                            <td class="text-center">{{ $item->usia }} th</td>
                            <td class="text-center">{{ $item->waktu }} minggu</td>
                            <td class="text-center">
                                {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') : '-' }}
                            </td>
                            <td>{{ $item->guru->nama ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('tematk.show', $item->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('tematk.edit', $item->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('tematk.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Data tematik akan dihapus secara permanen.')"
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
                            <td colspan="8" class="text-center text-muted">Belum ada data tema pembelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $tematk->links('pagination::bootstrap-4') }}
        </div>

        {{-- Teks info pagination --}}
        <div class="text-center text-muted mt-2 mb-4">
            Showing {{ $tematk->firstItem() ?? 0 }} to {{ $tematk->lastItem() ?? 0 }} of {{ $tematk->total() }} results
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
