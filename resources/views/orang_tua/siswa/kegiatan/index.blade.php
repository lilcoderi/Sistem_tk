@extends('orang_tua.layouts.app')

@section('title')
    Asesmen Anekdot
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header mb-4">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="#"><i class="bi bi-clipboard-data me-1"></i> Asesmen</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="{{ route('profil-anak.anekdot.orangtua') }}">Anekdot</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container py-3">
        <h3 class="fw-bold text-success mb-4"><i class="bi bi-journal-medical me-2"></i>Riwayat Asesmen Anekdot Anak</h3>

        @forelse ($data as $item)
            <div class="bg-white p-4 rounded shadow-sm mb-4 border-start border-4 border-success">
                <h5 class="fw-bold text-primary mb-3">
                    <i class="bi bi-person-circle me-2"></i>{{ $item->siswa->nama_lengkap ?? '-' }}
                </h5>

                <div class="row fs-6">
                    <div class="col-md-6 mb-2">
                        <i class="bi bi-calendar-event me-2 text-success"></i><strong>Tanggal:</strong>
                        {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <i class="bi bi-bullseye me-2 text-success"></i><strong>Lingkup Perkembangan:</strong>
                        {{ $item->lingkup->nama_lingkup ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <i class="bi bi-tags-fill me-2 text-success"></i><strong>Subtema:</strong>
                        {{ $item->subtema->sub_tema ?? '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <i class="bi bi-file-earmark-text-fill me-2 text-success"></i><strong>Keterangan:</strong><br>
                    <p class="ms-4 mb-2">{{ $item->keterangan ?? '-' }}</p>
                </div>

                @if ($item->dokumentasi_foto)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $item->dokumentasi_foto) }}" alt="Dokumentasi"
                            class="img-fluid rounded shadow-sm border" style="max-height: 250px;">
                    </div>
                @endif
            </div>
        @empty
            <div class="alert alert-info text-center py-4">
                <i class="bi bi-info-circle me-2"></i>Belum ada data asesmen anekdot untuk anak Anda.
            </div>
        @endforelse
    </div>
@endsection
