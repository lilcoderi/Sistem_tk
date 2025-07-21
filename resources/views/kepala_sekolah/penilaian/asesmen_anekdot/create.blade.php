@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Asesmen Anekdot
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Penilaian Asesmen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('asesmen.anekdot.index') }}">Asesmen Anekdot</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h1 class="mb-4">Tambah Asesmen Anekdot</h1>

        <form action="{{ route('asesmen.anekdot.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Pilih Siswa --}}
            <div class="mb-3">
                <label for="siswa_id" class="form-label">Siswa</label>
                <select name="siswa_id" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Subtema --}}
            <div class="mb-3">
                <label for="subtema_id" class="form-label">Subtema</label>
                <select name="subtema_id" id="subtemaSelect" class="form-select" required>
                    <option value="">-- Pilih Subtema --</option>
                    @foreach ($subtema as $st)
                        <option value="{{ $st->id }}" data-tema="{{ $st->tematk->tema ?? 'Tidak Diketahui' }}">
                            {{ $st->sub_tema }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tampilkan Tema Otomatis --}}
            <div class="mb-3">
                <label class="form-label">Tema</label>
                <input type="text" id="temaDisplay" class="form-control" readonly>
            </div>

            {{-- Pilih Lingkup Perkembangan --}}
            <div class="mb-3">
                <label for="lingkup_id" class="form-label">Lingkup Perkembangan</label>
                <select name="lingkup_id" class="form-select" required>
                    <option value="">-- Pilih Lingkup --</option>
                    @forelse ($lingkup as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lingkup }}</option>
                    @empty
                        <option value="">Tidak ada data lingkup perkembangan</option>
                    @endforelse
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
            </div>

            {{-- Upload Foto --}}
            <div class="mb-3">
                <label for="dokumentasi_foto" class="form-label">Dokumentasi Foto</label>
                <input type="file" name="dokumentasi_foto" class="form-control" accept="image/*">
            </div>

            {{-- Keterangan --}}
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4" placeholder="Catatan atau observasi anekdot..."></textarea>
            </div>

            {{-- Tombol --}}
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('asesmen.anekdot.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        // Auto-set tema dari subtema
        document.getElementById('subtemaSelect').addEventListener('change', function () {
            const tema = this.options[this.selectedIndex].getAttribute('data-tema');
            document.getElementById('temaDisplay').value = tema;
        });
    </script>
@endsection
