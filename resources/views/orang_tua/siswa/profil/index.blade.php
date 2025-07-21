@extends('orang_tua.layouts.app')

@section('title')
    Profil Siswa dan Orang Tua
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Profil Siswa dan Orang Tua
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container py-5">
        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Profil Anak -->
        <div class="mb-5">
            <h3 class="fw-bold text-success mb-4">
                <i class="bi bi-person-badge-fill me-2"></i> Profil Anak
            </h3>

            @forelse ($anak as $siswa)
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="text-primary fw-bold mb-4">
                            <i class="bi bi-person-circle me-2"></i> {{ $siswa->nama_lengkap }}
                        </h4>

                        <div class="row g-3 fs-6">
                            <div class="col-md-6">
                                <strong>Panggilan:</strong> {{ $siswa->nama_panggilan ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Lahir:</strong>
                                {{ $siswa->tempat_lahir ?? '-' }},
                                {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Alamat:</strong> {{ $siswa->alamat_rumah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Agama:</strong> {{ $siswa->agama ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Kelompok:</strong> {{ $siswa->kelompok ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Anak ke:</strong>
                                {{ $siswa->anak_ke ?? '-' }} dari {{ $siswa->jumlah_saudara ?? '-' }} saudara
                            </div>
                            <div class="col-md-6">
                                <strong>Bahasa:</strong> {{ $siswa->bahasa_sehari_hari ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Gol. Darah:</strong> {{ $siswa->golongan_darah ?? '-' }}
                            </div>
                            <div class="col-12">
                                <strong>Ciri Khusus:</strong> {{ $siswa->ciri_khusus ?? '-' }}
                            </div>
                        </div>

                        <!-- Hasil Prediksi Awal -->
                        @if ($siswa->hasil_prediksi_awal)
                            <div class="bg-light p-4 mt-4 rounded border-start border-3 border-success">
                                <h5 class="text-success fw-bold mb-3">
                                    <i class="bi bi-robot me-2"></i> Hasil Prediksi Awal
                                </h5>
                                <div class="fs-6">
                                    <p><strong>Prediksi:</strong> {{ $siswa->hasil_prediksi_awal->prediksi_awal ?? '-' }}
                                    </p>
                                    <p><strong>Rekomendasi:</strong> {!! nl2br(e($siswa->hasil_prediksi_awal->rekomendasi_awal ?? '-')) !!}</p>
                                    <p><strong>Catatan:</strong> {!! nl2br(e($siswa->hasil_prediksi_awal->catatan_sistem_pakar ?? '-')) !!}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Tombol Aksi -->
                        <div class="text-end mt-4">
                            <a href="{{ route('profil-anak.edit', $siswa->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle me-2"></i> Belum ada data siswa yang terkait dengan akun Anda.
                </div>
            @endforelse
        </div>

        <!-- Profil Orang Tua -->
        <div class="mb-5">
            <h3 class="fw-bold text-success mb-4">
                <i class="bi bi-people-fill me-2"></i> Profil Orang Tua
            </h3>

            @if ($orangtua)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Data Ayah -->
                        <h5 class="text-primary fw-bold mb-3">Data Ayah</h5>
                        <div class="row g-3 fs-6">
                            <div class="col-md-6">
                                <strong>Nama:</strong> {{ $orangtua->nama_ayah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>NIK:</strong> {{ $orangtua->nik_ayah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Lahir:</strong>
                                {{ $orangtua->tempat_lahir_ayah ?? '-' }},
                                {{ $orangtua->tanggal_lahir_ayah ? \Carbon\Carbon::parse($orangtua->tanggal_lahir_ayah)->translatedFormat('d F Y') : '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Agama:</strong> {{ $orangtua->agama_ayah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Kewarganegaraan:</strong> {{ $orangtua->kewarganegaraan_ayah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Pendidikan:</strong> {{ $orangtua->pendidikan_ayah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Pekerjaan:</strong> {{ $orangtua->pekerjaan_ayah ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>No. Telp:</strong> {{ $orangtua->no_telepon_ayah ?? '-' }}
                            </div>
                            <div class="col-12">
                                <strong>Alamat:</strong> {{ $orangtua->alamat_rumah_ayah ?? '-' }}
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <h5 class="text-primary fw-bold mt-4 mb-3">Data Ibu</h5>
                        <div class="row g-3 fs-6">
                            <div class="col-md-6">
                                <strong>Nama:</strong> {{ $orangtua->nama_ibu ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>NIK:</strong> {{ $orangtua->nik_ibu ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Lahir:</strong>
                                {{ $orangtua->tempat_lahir_ibu ?? '-' }},
                                {{ $orangtua->tanggal_lahir_ibu ? \Carbon\Carbon::parse($orangtua->tanggal_lahir_ibu)->translatedFormat('d F Y') : '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Agama:</strong> {{ $orangtua->agama_ibu ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Kewarganegaraan:</strong> {{ $orangtua->kewarganegaraan_ibu ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Pendidikan:</strong> {{ $orangtua->pendidikan_ibu ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Pekerjaan:</strong> {{ $orangtua->pekerjaan_ibu ?? '-' }}
                            </div>
                            <div class="col-md-6">
                                <strong>No. Telp:</strong> {{ $orangtua->no_telepon_ibu ?? '-' }}
                            </div>
                            <div class="col-12">
                                <strong>Alamat:</strong> {{ $orangtua->alamat_rumah_ibu ?? '-' }}
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        @if ($orangtua && $orangtua->id_orangtua)
                            <div class="text-end mt-4">
                                <a href="{{ route('profil-orangtua.edit', $orangtua->id_orangtua) }}"
                                    class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Profil
                                </a>
                            </div>
                        @else
                            <div class="alert alert-warning text-center mt-4">
                                <i class="bi bi-exclamation-triangle me-2"></i> ID orang tua tidak ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle me-2"></i> Belum ada data orang tua yang terkait dengan akun Anda.
                </div>
            @endif
        </div>
    </div>
@endsection
