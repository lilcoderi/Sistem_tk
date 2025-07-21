@extends('kepala_sekolah.layouts.app')

@section('title')
    Asesmen Anekdot
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="container my-5">

        {{-- Header --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-card-text me-2"></i> Daftar Asesmen Anekdot
            </h2>
            <p class="text-muted">Dokumentasi dan pengamatan perilaku siswa dalam kegiatan belajar</p>
        </div>

        {{-- Filter dan Tombol Tambah dalam satu baris --}}
        <form method="GET" class="mb-4">
            <div class="row align-items-end g-2">

                {{-- Filter Subtema --}}
                <div class="col-md-3">
                    <label for="subtema" class="form-label">Filter Subtema</label>
                    <select name="subtema_id" id="subtema" class="form-select form-select-sm"
                        onchange="this.form.submit()">
                        <option value="">Semua Subtema</option>
                        @foreach ($subtemaList as $subtema)
                            <option value="{{ $subtema->id }}"
                                {{ request('subtema_id') == $subtema->id ? 'selected' : '' }}>
                                {{ $subtema->sub_tema }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Kelas --}}
                <div class="col-md-3">
                    <label for="kelas" class="form-label">Filter Kelas</label>
                    <select name="kelas" id="kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="A" {{ request('kelas', 'A') == 'A' ? 'selected' : '' }}>Kelas A</option>
                        <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                    </select>
                </div>

                {{-- Kosongkan tengah --}}
                <div class="col-md-3"></div>

                {{-- Tombol Tambah --}}
                <div class="col-md-3 text-end">
                    <label class="form-label d-block invisible">Tombol</label>
                    <a href="{{ route('asesmen.anekdot.create') }}" class="btn btn-success shadow-sm w-100">
                        <i class="bi bi-plus-circle"></i> Tambah Anekdot
                    </a>
                </div>
            </div>
        </form>



        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="table-responsive shadow-sm">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Siswa</th>
                        <th>Subtema</th>
                        <th>Lingkup Perkembangan</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Foto</th>
                        <th>Keterangan</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->siswa->nama_lengkap ?? '-' }}</td>
                            <td>{{ $item->subtema->sub_tema ?? '-' }}</td>
                            <td>{{ $item->lingkup->nama_lingkup ?? '-' }}</td>
                            <td class="text-center">{{ $item->subtema->tematk->kelas ?? '-' }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') }}
                            </td>
                            <td class="text-center">
                                @if ($item->dokumentasi_foto)
                                    <img src="{{ asset('storage/' . $item->dokumentasi_foto) }}" alt="Foto"
                                        class="img-thumbnail" style="max-width: 80px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->keterangan }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('asesmen.anekdot.show', $item->id) }}"
                                        class="btn btn-outline-info btn-icon rounded shadow-sm" title="Lihat">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('asesmen.anekdot.edit', $item->id) }}"
                                        class="btn btn-outline-warning btn-icon rounded shadow-sm" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('asesmen.anekdot.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirmHapusUmum(event, this, 'Data anekdot asesmen akan dihapus secara permanen.')"
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
                            <td colspan="9" class="text-center text-muted fst-italic py-4">
                                Belum ada data asesmen anekdot.
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
