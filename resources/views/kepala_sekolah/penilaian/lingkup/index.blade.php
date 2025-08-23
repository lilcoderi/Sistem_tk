@extends('kepala_sekolah.layouts.app')

@section('title')
    Lingkup Pembelajaran
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
                            <a href="{{ route('lingkup.index') }}">Lingkup Perkembangan Pembelajaran</a>
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
                <i class="bi bi-list-task me-2"></i> Data Lingkup Perkembangan
            </h2>
            <p class="text-muted">Kelola informasi tentang lingkup perkembangan, tujuan pembelajaran, dan deskripsinya</p>
        </div>

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Filter & Tombol Tambah --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
            {{-- Form Filter Sort dan Kurikulum --}}
            <form method="GET" action="{{ route('lingkup.index') }}" class="d-flex align-items-center gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <label for="sort" class="form-label mb-0 fw-semibold">Urutkan:</label>
                    <select name="sort" id="sort" class="form-select" style="min-width: 150px;"
                        onchange="this.form.submit()">
                        <option value="">-- Nama Lingkup --</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </div>

                {{-- Filter Kurikulum --}}
                <div class="d-flex align-items-center gap-2">
                    <label for="filter_kurikulum" class="form-label mb-0 fw-semibold">Kurikulum:</label>
                    <select name="filter_kurikulum" id="filter_kurikulum" class="form-select" style="min-width: 180px;"
                        onchange="this.form.submit()">
                        <option value="">-- Semua Kurikulum --</option>
                        @foreach ($kurikulums as $kurikulum)
                            <option value="{{ $kurikulum->id }}"
                                {{ request('filter_kurikulum') == $kurikulum->id ? 'selected' : '' }}>
                                {{ $kurikulum->nama }} ({{ $kurikulum->tahun }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            {{-- Tombol Tambah --}}
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#tambahKurikulumModal">
                    <i class="bi bi-journal-plus"></i> Tambah Kurikulum
                </button>
                <a href="{{ route('lingkup.create') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-patch-plus"></i> Tambah Lingkup
                </a>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Kurikulum</th> {{-- Kolom Kurikulum baru --}}
                        <th>Nama Lingkup</th>
                        <th>Tujuan Pembelajaran</th>
                        <th>Deskripsi</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $data->firstItem() + $index }}</td>
                            <td>{{ $item->kurikulum->nama ?? '-' }} ({{ $item->kurikulum->tahun ?? '-' }})</td> {{-- Menampilkan nama dan tahun kurikulum --}}
                            <td>{{ $item->nama_lingkup }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->tujuan_pembelajaran ?? '-', 50, '...') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50, '...') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('lingkup.show', $item->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('lingkup.edit', $item->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('lingkup.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Data lingkup akan dihapus secara permanen.')"
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

        {{-- Tombol Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>

        {{-- Info Pagination --}}
        <div class="text-center text-muted mt-2 mb-4">
            Menampilkan {{ $data->firstItem() ?? 0 }} sampai {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} entri
        </div>

        {{-- Custom Styling Pagination --}}
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

    {{-- Modal Tambah Kurikulum --}}
    <div class="modal fade" id="tambahKurikulumModal" tabindex="-1" aria-labelledby="tambahKurikulumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahKurikulumModalLabel"><i class="bi bi-journal-plus me-2"></i>Tambah Kurikulum Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('kurikulum.store') }}" method="POST"> {{-- Sesuaikan route ini --}}
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kurikulumNama" class="form-label">Nama Kurikulum</label>
                            <input type="text" class="form-control" id="kurikulumNama" name="nama"
                                placeholder="Contoh: Kurikulum Merdeka" required>
                        </div>
                        <div class="mb-3">
                            <label for="kurikulumTahun" class="form-label">Tahun Kurikulum</label>
                            <input type="number" class="form-control" id="kurikulumTahun" name="tahun"
                                placeholder="Contoh: 2024" min="1900" max="2100" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kurikulum</button>
                    </div>
                </form>
            </div>
        </div>
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