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
                            <a href="{{ route('lingkup.index') }}">Lingkup Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('lingkup.create') }}">Tambah Lingkup Pembelajaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success">
                        <i class="bi bi-list-check me-2"></i> Detail Lingkup Perkembangan
                    </h2>
                    <p class="text-muted">Informasi lengkap mengenai lingkup perkembangan yang dipilih</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <span>Informasi Lingkup Perkembangan</span>
                    </div>

                    <div class="card-body">
                        <dl class="row mb-4">
                            <dt class="col-sm-4 fw-semibold">Nama Lingkup</dt>
                            <dd class="col-sm-8">{{ $lingkup->nama_lingkup }}</dd>

                            <dt class="col-sm-4 fw-semibold">Tujuan Pembelajaran</dt>
                            <dd class="col-sm-8" style="white-space: pre-line;">
                                {{ $lingkup->tujuan_pembelajaran ?? '-' }}
                            </dd>

                            <dt class="col-sm-4 fw-semibold">Deskripsi</dt>
                            <dd class="col-sm-8" style="white-space: pre-line;">
                                {{ $lingkup->deskripsi }}
                            </dd>
                        </dl>


                    </div>

                </div>
                <div class="text-end">
                    <a href="{{ route('lingkup.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('lingkup.edit', $lingkup->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
