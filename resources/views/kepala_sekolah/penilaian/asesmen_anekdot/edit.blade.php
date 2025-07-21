@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Asesmen Anekdot
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
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h1 class="mb-4">Edit Asesmen Anekdot</h1>

        <form action="{{ route('asesmen.anekdot.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Pilih Siswa --}}
            <div class="mb-3">
                <label for="siswa_id" class="form-label">Siswa</label>
                <select name="siswa_id" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswa as $s)
                        <option value="{{ $s->id }}" {{ $item->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Subtema --}}
            <div class="mb-3">
                <label for="subtema_id" class="form-label">Subtema</label>
                <select name="subtema_id" class="form-select" required>
                    <option value="">-- Pilih Subtema --</option>
                    @foreach ($subtema as $st)
                        <option value="{{ $st->id }}" {{ $item->subtema_id == $st->id ? 'selected' : '' }}>
                            {{ $st->sub_tema }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Lingkup Perkembangan --}}
            <div class="mb-3">
                <label for="lingkup_id" class="form-label">Lingkup Perkembangan</label>
                <select name="lingkup_id" class="form-select" required>
                    <option value="">-- Pilih Lingkup --</option>
                    @foreach ($lingkup as $l)
                        <option value="{{ $l->id }}" {{ $item->lingkup_id == $l->id ? 'selected' : '' }}>{{ $l->nama_lingkup }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div class="mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal_pelaksanaan" class="form-control" value="{{ $item->tanggal_pelaksanaan }}" required>
            </div>

            {{-- Upload Foto --}}
            <div class="mb-3">
                <label for="dokumentasi_foto" class="form-label">Dokumentasi Foto</label>
                @if ($item->dokumentasi_foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $item->dokumentasi_foto) }}" alt="Foto Sebelumnya" class="img-thumbnail" style="max-width: 120px;">
                    </div>
                @endif
                <input type="file" name="dokumentasi_foto" class="form-control" accept="image/*">
            </div>

            {{-- Keterangan --}}
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4">{{ $item->keterangan }}</textarea>
            </div>

            {{-- Tombol --}}
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('asesmen.anekdot.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
