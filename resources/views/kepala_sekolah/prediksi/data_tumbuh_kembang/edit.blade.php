@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Data Tumbuh Kembang
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Monitoring</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tumbuh_kembang.index') }}">Tumbuh Kembang</a></li>
                        <li class="breadcrumb-item active">Edit Data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-header bg-gradient-primary text-white text-center rounded-top-3">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit Data Tumbuh Kembang
                        </h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('tumbuh_kembang.update', $data->id) }}" method="POST" novalidate>
                            @csrf
                            @method('POST')

                            <div class="mb-4">
                                <label for="id_siswa" class="form-label fw-semibold text-success">
                                    <i class="bi bi-person-fill me-1"></i> Nama Siswa
                                </label>
                                <select name="id_siswa" id="id_siswa"
                                    class="form-select form-select-lg border-3 shadow-sm @error('id_siswa') is-invalid @enderror"
                                    required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $item)
                                        <option value="{{ $item->id }}" {{ old('id_siswa', $data->id_siswa) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_siswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tinggi_badan" class="form-label fw-semibold text-success">
                                    <i class="bi bi-rulers me-1"></i> Tinggi Badan (cm)
                                </label>
                                <input type="number" step="0.1" min="0" id="tinggi_badan" name="tinggi_badan"
                                    class="form-control form-control-lg border-3 shadow-sm @error('tinggi_badan') is-invalid @enderror"
                                    value="{{ old('tinggi_badan', $data->tinggi_badan) }}" required>
                                @error('tinggi_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="berat_badan" class="form-label fw-semibold text-success">
                                    <i class="bi bi-battery-half me-1"></i> Berat Badan (kg)
                                </label>
                                <input type="number" step="0.1" min="0" id="berat_badan" name="berat_badan"
                                    class="form-control form-control-lg border-3 shadow-sm @error('berat_badan') is-invalid @enderror"
                                    value="{{ old('berat_badan', $data->berat_badan) }}" required>
                                @error('berat_badan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="lingkar_kepala" class="form-label fw-semibold text-success">
                                    <i class="bi bi-record-circle me-1"></i> Lingkar Kepala (cm)
                                </label>
                                <input type="number" step="0.1" min="0" id="lingkar_kepala" name="lingkar_kepala"
                                    class="form-control form-control-lg border-3 shadow-sm @error('lingkar_kepala') is-invalid @enderror"
                                    value="{{ old('lingkar_kepala', $data->lingkar_kepala) }}" required>
                                @error('lingkar_kepala')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="umur" class="form-label fw-semibold text-success">
                                    <i class="bi bi-hourglass-split me-1"></i> Umur (bulan)
                                </label>
                                <input type="number" min="0" id="umur" name="umur"
                                    class="form-control form-control-lg border-3 shadow-sm @error('umur') is-invalid @enderror"
                                    value="{{ old('umur', $data->umur) }}" required>
                                @error('umur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('tumbuh_kembang.index') }}"
                                    class="btn btn-outline-danger fw-semibold shadow-sm px-4">
                                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success fw-semibold shadow-sm px-5">
                                    <i class="bi bi-check2-circle me-2"></i> Perbarui
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(90deg, #198754 0%, #20c997 100%);
        }
    </style>
@endsection
