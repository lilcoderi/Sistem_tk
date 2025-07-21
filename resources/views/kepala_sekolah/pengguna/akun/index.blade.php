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
                            <a href="{{ route('user.index') }}">Manajemen Role</a>
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
                <i class="bi bi-people-fill me-2"></i> Manajemen Akun Pengguna
            </h2>
            <p class="text-muted">Kelola akun, peran, dan akses pengguna sistem</p>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif


        {{-- Filter Role & Tombol Tambah User --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

            {{-- Filter Role --}}
            <form action="{{ route('user.index') }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap mb-0">
                <select name="role" class="form-select shadow-sm w-auto" onchange="this.form.submit()">
                    <option value="">-- Semua Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>

                @if (request('role'))
                    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary shadow-sm">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                @endif
            </form>

            {{-- Tombol Tambah User --}}
            <a href="{{ route('user.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User
            </a>
        </div>


        {{-- Tabel Pengguna --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 25%;">Nama</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 25%;">Role</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->join(', ') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit Role">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirmHapusAkun(event, this)" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-icon rounded shadow-sm"
                                            title="Hapus Akun">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted fst-italic py-4">
                                Belum ada pengguna yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmHapusAkun(event, form) {
            event.preventDefault(); // Cegah submit langsung

            Swal.fire({
                title: 'Hapus Akun?',
                text: "Akun ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form secara manual
                }
            });

            return false;
        }
    </script>
@endsection
