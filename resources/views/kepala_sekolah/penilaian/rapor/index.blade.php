@extends('kepala_sekolah.layouts.app')

@section('title')
    Rapor Siswa
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Rapor</a></li>
                        <li class="breadcrumb-item active">Data DDTK Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-person-check-fill me-2"></i> Rapor Siswa
            </h2>
            <p class="text-muted">Pantau dan proses Data DDTK berdasarkan identitas siswa</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif


        <div class="table-responsive shadow-sm">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>#</th>
                        <th>Absen Siswa</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Status Asesmen</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $index => $item)
                        @php
                            $asesmen = \App\Models\HasilAsesmenCeklis::where('id_siswa', $item->id)
                                ->latest('tanggal_proses')
                                ->first();
                            $tumbuh = \App\Models\TumbuhKembang::where('id_siswa', $item->id)
                                ->latest('tanggal_input')
                                ->first();
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $item->pendaftaran ? \Illuminate\Support\Str::after($item->pendaftaran->id_pendaftaran, 'PDK') : '-' }}
                            </td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td class="text-center">{{ $item->kelompok }}</td>
                            {{-- Kolom Status Asesmen --}}
                            <td class="text-center">
                                @if ($asesmen)
                                    <span class="text-success">✅ Hasil Asesmen</span><br>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($asesmen->tanggal_proses)->translatedFormat('d M Y') }}</small>
                                @else
                                    <span class="text-danger">❌ Belum Ada</span><br>
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            {{-- Kolom Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    {{-- Tombol Jalankan OpenAI --}}
                                    <a href="#" class="btn btn-outline-warning btn-icon rounded shadow-sm"
                                        onclick="return konfirmasiGenerateRapor('{{ route('rapor.generate', $item->id) }}', '{{ $item->nama_lengkap }}')"
                                        title="Jalankan OpenAI">
                                        <i class="bi bi-lightning"></i>
                                    </a>

                                    {{-- Tombol Preview Rapor --}}
                                    <a href="{{ route('rapor.show', $item->id) }}"
                                        class="btn btn-outline-primary btn-icon rounded shadow-sm" title="Lihat Rapor">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Tombol Unduh PDF --}}
                                    <a href="{{ route('rapor.cetak', $item->id) }}"
                                        class="btn btn-outline-danger btn-icon rounded shadow-sm" title="Unduh PDF">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted fst-italic py-4">Data siswa belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $siswa->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function konfirmasiGenerateRapor(url, nama) {
            Swal.fire({
                title: 'Jalankan OpenAI?',
                text: `OpenAI akan membuat deskripsi rapor untuk ${nama}.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, jalankan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });

            return false; // cegah link langsung dijalankan
        }
    </script>
@endsection
