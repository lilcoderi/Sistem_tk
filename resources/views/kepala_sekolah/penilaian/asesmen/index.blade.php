@extends('kepala_sekolah.layouts.app')

@section('title')
    Asesmen Pembelajaran
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
                            <a href="{{ route('asesmen.index') }}">Asesmen Pembelajaran</a>
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
                <i class="bi bi-list-check me-2"></i> Daftar Asesmen
            </h2>
            <p class="text-muted">Data asesmen siswa berdasarkan subtema dan guru pengampu</p>
        </div>

        {{-- Tombol Tambah --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('asesmen.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-patch-plus"></i> Tambah Asesmen
            </a>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Form Pencarian --}}
        <form action="{{ route('asesmen.index') }}" method="GET" class="mb-3 d-flex flex-wrap gap-2 align-items-center">

            {{-- Input Pencarian dengan tombol silang --}}
            <div class="position-relative">
                <input type="text" name="search" id="searchInput" class="form-control shadow-sm pe-5"
                    placeholder="Cari nama siswa..." value="{{ request('search') }}" oninput="this.form.submit()">

                @if (request('search'))
                    <a href="{{ route('asesmen.index', array_merge(request()->except('search'), ['search' => null])) }}"
                        class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                        style="text-decoration: none;">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                @endif
            </div>

            {{-- Dropdown Subtema --}}
            <select name="subtema_id" class="form-select shadow-sm w-auto" onchange="this.form.submit()">
                <option value="">Semua Subtema</option>
                @foreach ($subtemaOptions as $subtema)
                    <option value="{{ $subtema->id }}" {{ $selectedSubtema == $subtema->id ? 'selected' : '' }}>
                        {{ $subtema->sub_tema }} - ({{ $subtema->tematk->kelas ?? '-' }})
                    </option>
                @endforeach
            </select>


            <select name="kelas" class="form-select shadow-sm w-auto" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                <option value="A" {{ request('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
            </select>

            {{-- Dropdown Sort --}}
            <select name="sort" class="form-select shadow-sm w-auto" onchange="this.form.submit()">
                <option value="">Urutkan</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A-Z</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z-A</option>
            </select>

            {{-- Dropdown Tahun Ajar --}}
            <select name="tahun_ajar" class="form-select shadow-sm w-auto" onchange="this.form.submit()">
                <option value="">Semua Tahun Ajar</option>
                @foreach ($tahunAjarOptions as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun_ajar') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>

        </form>



        {{-- Tabel Asesmen --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Siswa</th>
                        <th>Subtema</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Semester</th>
                        <th>Tahun Ajar</th>
                        <th>Tipe Penilaian</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asesmen as $index => $item)
                        <tr>
                            <td class="text-center">
                                {{ ($asesmen->currentPage() - 1) * $asesmen->perPage() + $index + 1 }}
                            </td>
                            <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                            <td>{{ $item->subtema->sub_tema ?? '-' }}</td>
                            <td class="text-center">{{ $item->subtema->tematk->kelas ?? '-' }}</td>
                            <td>{{ $item->guru->nama ?? '-' }}</td>
                            <td class="text-center">{{ $item->semester ?? '-' }}</td>
                            <td class="text-center">{{ $item->tahun_ajar ?? '-' }}</td>
                            <td class="text-center">{{ ucfirst($item->tipe_penilaian ?? '-') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('detail-asesmen.show', $item->id_asesmen) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('asesmen.edit', $item->id_asesmen) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('asesmen.destroy', $item->id_asesmen) }}" method="POST"
                                        onsubmit="return confirmHapusAsesmen(event, this)" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon rounded shadow-sm"
                                            title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('detail-asesmen.index', ['id_siswa' => $item->siswa->id]) }}"
                                        class="btn btn-outline-success btn-icon rounded shadow-sm" title="Penilaian">
                                        <i class="bi bi-journal-text"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted fst-italic py-4">
                                Belum ada data asesmen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $asesmen->withQueryString()->links('pagination::bootstrap-4') }}
        </div>

        <div class="text-center text-muted mt-2 mb-4">
            Menampilkan {{ $asesmen->firstItem() ?? 0 }} sampai {{ $asesmen->lastItem() ?? 0 }} dari
            {{ $asesmen->total() }} entri
        </div>

        {{-- Styling --}}
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
        function confirmHapusAsesmen(event, form) {
            event.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data asesmen akan dihapus secara permanen.",
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
