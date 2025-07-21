@extends('kepala_sekolah.layouts.app')

@section('title')
    Data DDTK Siswa
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Monitoring</a></li>
                        <li class="breadcrumb-item active">Data DDTK Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-person-check-fill me-2"></i> Monitoring DDTK Siswa
            </h2>
            <p class="text-muted">Pantau dan proses Data DDTK berdasarkan identitas siswa</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('prediksi'))
            <div class="alert alert-success mt-3">
                <strong>Prediksi Berhasil!</strong><br>
                Nama: {{ session('prediksi.nama') }}<br>
                Hasil Asli: {{ session('prediksi.hasil_asli') }}<br>
                Hasil Prediksi: {{ session('prediksi.hasil_prediksi') }}
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
                        <th>Kelompok</th>
                        <th>Umur</th>
                        <th>Status Asesmen</th>
                        <th>Status Tumbuh Kembang</th>
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
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age * 12 }} bln
                            </td>
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
                            {{-- Kolom Status Tumbuh Kembang --}}
                            <td class="text-center">
                                @if ($tumbuh)
                                    <span class="text-success">✅ Tumbuh Kembang</span><br>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($tumbuh->tanggal_input)->translatedFormat('d M Y') }}</small>
                                @else
                                    <span class="text-danger">❌ Belum Ada</span><br>
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            {{-- Kolom Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    @if ($item->ddtk && $item->ddtk->id)
                                        <a href="{{ route('ddtk.show', $item->ddtk->id) }}"
                                            class="btn btn-outline-info btn-icon rounded shadow-sm" title="Detail DDTK">
                                            <i class="bi bi-clipboard-data"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('ddtk.jalankan', $item->id) }}" method="GET"
                                        onsubmit="return konfirmasiProsesDDTK(event, this, '{{ $item->nama_lengkap }}')">
                                        <button type="submit" class="btn btn-outline-success btn-icon rounded shadow-sm"
                                            title="Jalankan DDTK">
                                            <i class="bi bi-cpu"></i>
                                        </button>
                                    </form>
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
        function konfirmasiProsesDDTK(event, form, nama) {
            event.preventDefault();

            Swal.fire({
                title: 'Jalankan Proses DDTK?',
                text: `Proses DDTK akan dijalankan untuk ${nama}.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, jalankan!',
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
