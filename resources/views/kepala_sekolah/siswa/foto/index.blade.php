@stack('scripts')

@extends('kepala_sekolah.layouts.app')

@section('title')
    Kegiatan Siswa
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
                            <a href="javascript:void(0)">Siswa/Siswi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('fotokegiatan.index') }}">Foto Kegiatan TK</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    {{-- Header --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">
            <i class="bi bi-images me-2"></i> Daftar Kegiatan & Foto
        </h2>
        <p class="text-muted">Informasi dokumentasi kegiatan siswa berdasarkan tanggal dan deskripsi</p>
    </div>

    <div class="container my-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('fotokegiatan.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Upload Foto Kegiatan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-success">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Judul Kegiatan</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse ($data as $kegiatan)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $kegiatan->judul }}</td>
                            <td>{{ $kegiatan->deskripsi }}</td>
                            <td class="text-center">{{ $kegiatan->fotoKegiatan->count() }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('fotokegiatan.show', $kegiatan->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Lihat Foto">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <form action="{{ route('fotokegiatan.deleteGroup', $kegiatan->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Semua foto kegiatan ini akan dihapus secara permanen.')"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-icon rounded shadow-sm"
                                            title="Hapus Semua">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
