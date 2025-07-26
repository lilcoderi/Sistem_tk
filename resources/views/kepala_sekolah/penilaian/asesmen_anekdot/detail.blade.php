@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Asesmen Anekdot
@endsection

@section('content')
    <div class="container my-5">
        {{-- Header --}}
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">
                <i class="bi bi-journal-text me-2"></i> Detail Asesmen Anekdot
            </h2>
            <p class="text-muted">Dokumentasi dan catatan pengamatan perilaku siswa</p>
        </div>

        {{-- Card Detail --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Nama Siswa:</strong> {{ $item->siswa->nama_lengkap ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Subtema:</strong> {{ $item->subtema->sub_tema ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Tema:</strong> {{ $item->subtema->tematk->tema ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Lingkup Perkembangan:</strong> {{ $item->lingkup->nama_lingkup ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Kelas:</strong> {{ $item->subtema->tematk->kelas ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Tanggal Pelaksanaan:</strong>
                        {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Keterangan:</strong> {{ $item->keterangan ?? '-' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Dokumentasi Foto:</strong><br>
                        @if ($item->dokumentasi_foto)
                            <img src="{{ $item->dokumentasi_foto }}" alt="Foto"
     class="img-fluid rounded shadow mt-2"
     style="max-height: 400px; object-fit: contain;">

                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        {{-- Tombol kembali --}}
        <div class="text-end">
            <a href="{{ route('asesmen.anekdot.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
