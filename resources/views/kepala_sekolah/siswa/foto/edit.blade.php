@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Kegiatan TK
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Siswa/Siswi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('fotokegiatan.index') }}">Foto Kegiatan TK</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('fotokegiatan.create') }}">Edit Foto Kegiatan TK</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
 
    <div class="container my-4">
        <h3 class="mb-4 text-success fw-bold">
            <i class="bi bi-pencil-square me-2"></i> Edit Keterangan & Foto
        </h3>

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Foto Lama --}}
                <div class="mb-3 text-center">
                    <img src="{{ $foto->foto }}" alt="Foto Kegiatan" class="img-thumbnail"  style="max-height: 300px;">

                    <p class="text-muted mt-2 mb-0"><small>Foto saat ini</small></p>
                </div>

                {{-- Form --}}
                <form action="{{ route('fotokegiatan.update', $foto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Upload Foto Baru (Optional) --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label">Ganti Foto (opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengganti foto.</div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan Foto</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $foto->keterangan) }}</textarea>
                    </div>

                    {{-- Tombol --}}
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>

                    <a href="{{ route('fotokegiatan.show', $foto->kegiatan_tk_id) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
