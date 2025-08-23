@extends('kepala_sekolah.layouts.app')

@section('title')
    Tumbuh Kembang
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Monitoring</a></li>
                        <li class="breadcrumb-item active">Data Tumbuh Kembang </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">

        {{-- Judul Halaman --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-activity me-2"></i> Data Tumbuh Kembang Siswa
            </h2>
            <p class="text-muted">Pantau dan kelola pertumbuhan fisik siswa secara berkala</p>
        </div>

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-4 d-flex justify-content-end">
            <a href="{{ route('tumbuh_kembang.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Tambah Data
            </a>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Siswa</th>
                        <th>Tinggi Badan (cm)</th>
                        <th>Berat Badan (kg)</th>
                        <th>Lingkar Kepala (cm)</th>
                        <th>Umur (bln)</th>
                        <th>Tanggal Input</th>
                        <th style="width: 230px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                            <td class="text-center">{{ $item->tinggi_badan }}</td>
                            <td class="text-center">{{ $item->berat_badan }}</td>
                            <td class="text-center">{{ $item->lingkar_kepala }}</td>
                            <td class="text-center">{{ $item->umur }}</td>
                            <td class="text-center">{{ $item->tanggal_input ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('tumbuh_kembang.edit', $item->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('tumbuh_kembang.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Data tumbuh kembang akan dihapus secara permanen.')">
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
                            <td colspan="8" class="text-center text-muted fst-italic py-4">Belum ada data tumbuh kembang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination jika ada --}}
        {{-- <div class="d-flex justify-content-center mt-3">
            {{ $data->links('pagination::bootstrap-4') }}
        </div> --}}
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
