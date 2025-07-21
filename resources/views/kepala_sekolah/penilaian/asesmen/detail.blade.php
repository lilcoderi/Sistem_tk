@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Lingkup Pembelajaran
@endsection

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
                            <a href="{{ route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa]) }}">Daftar
                                Penilaian</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Detail Penilaian
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- Judul Halaman --}}
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">
                        <i class="bi bi-journal-text me-2"></i> Detail Penilaian Siswa
                    </h2>
                    <p class="text-muted">Informasi lengkap mengenai hasil asesmen siswa</p>
                </div>

                {{-- Card Informasi Asesmen --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-person-vcard-fill me-2"></i> Informasi Asesmen</span>
                    </div>

                    <div class="card-body">
                        {{-- Nama Siswa tampil besar dan di tengah --}}
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-success">
                                <i class="bi bi-person-fill me-2"></i> {{ $asesmen->siswa->nama_lengkap ?? '-' }}
                            </h4>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="bi bi-bookmark-fill text-secondary me-2"></i>
                                <strong>Tema:</strong> {{ $asesmen->subtema->tematk->tema ?? '-' }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-book-half text-secondary me-2"></i>
                                <strong>Subtema:</strong> {{ $asesmen->subtema->sub_tema ?? '-' }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-building-fill text-secondary me-2"></i>
                                <strong>Semester:</strong> {{ $asesmen->semester }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-calendar-range text-secondary me-2"></i>
                                <strong>Tahun Ajar:</strong> {{ $asesmen->tahun_ajar }}
                            </li>
                            <li class="list-group-item">
                                <i class="bi bi-ui-checks text-secondary me-2"></i>
                                <strong>Tipe Penilaian:</strong> {{ ucfirst($asesmen->tipe_penilaian) }}
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Penilaian per Lingkup --}}
                @php
                    $grouped = $detailAsesmen->groupBy(function ($item) {
                        return $item->modulAjar->lingkup->nama_lingkup ?? 'Tanpa Lingkup';
                    });
                @endphp

                @foreach ($grouped as $lingkupNama => $items)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light fw-bold">
                            <i class="bi bi-diagram-3-fill me-2 text-success"></i>Lingkup: {{ $lingkupNama }}
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0">
                                <thead class="table-success text-center">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Rencana Pembelajaran</th>
                                        <th style="width: 150px;">Skala Nilai</th>
                                    </tr>
                                </thead>
                               <tbody>
    @foreach ($items as $i => $item)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{!! nl2br(e($item->modulAjar->rencana_pembelajaran)) !!}</td>
            <td class="text-center" style="white-space: nowrap;">
                @php
                    $skalaMap = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
                    $bintang = $skalaMap[$item->skala_nilai] ?? 0;
                @endphp
                <div class="d-flex justify-content-center gap-1">
                    @for ($j = 1; $j <= 4; $j++)
                        <i class="bi bi-star-fill {{ $j <= $bintang ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                </div>
            </td>
        </tr>
    @endforeach
</tbody>

                            </table>
                        </div>
                    </div>
                @endforeach

                {{-- Tombol Aksi --}}
                <div class="text-end mt-4">
                    <a href="{{ route('asesmen.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
