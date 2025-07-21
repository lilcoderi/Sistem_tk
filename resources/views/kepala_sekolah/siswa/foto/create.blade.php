@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Data Siswa
@endsection

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
                            <a href="{{ route('fotokegiatan.index') }}">Kegiatan TK</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('fotokegiatan.create') }}">Tambah Kegiatan Siswa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-4">
        <h3 class="mb-4 text-success fw-bold">
            <i class="bi bi-cloud-upload me-2"></i> Upload Foto Kegiatan
        </h3>

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Oops!</strong> Ada kesalahan saat mengupload:<br><br>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('fotokegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Pilih Kegiatan --}}
                    <div class="mb-3">
                        <label for="kegiatan_tk_id" class="form-label fw-semibold">Pilih Kegiatan</label>
                        <select name="kegiatan_tk_id" id="kegiatan_tk_id" class="form-select" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            @foreach ($kegiatan as $item)
                                <option value="{{ $item->id }}">{{ $item->judul }}
                                    ({{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Upload Foto (multiple) --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">Upload Foto <small class="text-muted">(bisa
                                pilih lebih dari 1)</small></label>
                        <input type="file" name="foto[]" id="foto" class="form-control" multiple required
                            accept="image/*">
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan (opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                            placeholder="Misal: Kegiatan lomba hari guru..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('fotokegiatan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Upload Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
