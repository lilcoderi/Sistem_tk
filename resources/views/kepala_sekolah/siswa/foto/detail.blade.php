@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Data Siswa
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
                        <li class="breadcrumb-item active" aria-current="page">
                            Detail Foto
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
            <i class="bi bi-image-alt me-2"></i> Detail Foto Kegiatan
        </h2>
        <p class="text-muted">Lihat dokumentasi lengkap kegiatan yang telah dilaksanakan</p>
    </div>

    <div class="container my-4">

        {{-- Informasi Kegiatan --}}
        <div class="card mb-4 shadow-sm border-success">
            <div class="card-body">
                <h5 class="fw-bold text-success mb-2">
                    <i class="bi bi-bookmark-fill me-1"></i> {{ $kegiatan->judul }}
                </h5>
                <p class="mb-1"><strong><i class="bi bi-calendar-event me-1"></i> Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d-m-Y') }}</p>
                <p class="mb-0"><strong><i class="bi bi-card-text me-1"></i> Deskripsi:</strong>
                    {{ $kegiatan->deskripsi ?? '-' }}</p>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mb-4 text-end">
            <a href="{{ route('fotokegiatan.index') }}" class="btn btn-outline-success rounded shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Daftar
            </a>
        </div>

        {{-- Foto Kegiatan --}}
        @if ($kegiatan->fotoKegiatan->isEmpty())
            <div class="alert alert-warning">
                Belum ada foto untuk kegiatan ini.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($kegiatan->fotoKegiatan as $foto)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/' . $foto->foto) }}" class="card-img-top" alt="Foto kegiatan"
                                style="object-fit: cover; height: 200px;">
                            <div class="card-body">
                                <p class="card-text text-muted">{{ $foto->keterangan ?? 'Tidak ada keterangan.' }}</p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('fotokegiatan.edit', $foto->id) }}"
                                    class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('fotokegiatan.destroy', $foto->id) }}" method="POST"
                                    onsubmit="return confirmHapusUmum(event, this, 'Foto ini akan dihapus secara permanen.')"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon rounded shadow-sm" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
