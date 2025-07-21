@extends('kepala_sekolah.layouts.app')

@section('title')
    Manajemen Data Guru
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
                            <a href="javascript:void(0)">Manajemen Pengguna</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('guru.index') }}">Manajemen Data Guru</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="container my-5">

        {{-- Header Halaman --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-person-badge-fill me-2"></i> Manajemen Data Guru
            </h2>
            <p class="text-muted">Kelola informasi guru dan data kepegawaiannya</p>
        </div>

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="mb-3 text-end">
            <a href="{{ route('guru.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Guru
            </a>
        </div>

        {{-- Tabel Data Guru --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIP</th>
                        <th>Kontak</th>
                        <th>Foto</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gurus as $guru)
                        <tr>
                            <td>{{ $guru->nama }}</td>
                            <td>{{ $guru->email }}</td>
                            <td class="text-center">{{ $guru->nip }}</td>
                            <td class="text-center">{{ $guru->kontak }}</td>
                            <td class="text-center">
                                @if ($guru->photo)
                                    <img src="{{ asset('storage/' . $guru->photo) }}" alt="Foto Guru"
                                        class="img-thumbnail rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted fst-italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('guru.detail', $guru->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <a href="{{ route('guru.edit', $guru->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST"
                                        onsubmit="return confirmHapusGuru(event, this)" class="d-inline">
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
                            <td colspan="6" class="text-center text-muted fst-italic py-4">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmHapusGuru(event, form) {
            event.preventDefault(); // Cegah form langsung submit

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data guru akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika dikonfirmasi
                }
            });

            return false;
        }
    </script>
@endsection
