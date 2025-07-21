<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Orang Tua</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .step-wizard {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .step {
            flex-grow: 1;
            height: 8px;
            background-color: #dee2e6;
            margin: 0 4px;
            border-radius: 5px;
        }

        .step.active {
            background-color: #28a745;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow p-4 col-md-10 mx-auto">
            <h4 class="fw-bold mb-4">Identitas Orang Tua (2/6)</h4>

            <div class="step-wizard">
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step"></div>
                <div class="step"></div>
                <div class="step"></div>
                <div class="step"></div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">No. Pendaftaran:</label>
                <div class="border rounded px-3 py-2 bg-light">
                    {{ $id_pendaftaran }}
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('orangtua.store', $id_pendaftaran) }}">
                @csrf

                <!-- Ayah -->
                <h5 class="fw-bold mb-3">Data Ayah</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah"
                            class="form-control @error('nama_ayah') is-invalid @enderror"
                            value="{{ old('nama_ayah', $orangtua->nama_ayah ?? '') }}">
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik_ayah" class="form-label">NIK Ayah</label>
                        <input type="text" name="nik_ayah"
                            class="form-control @error('nik_ayah') is-invalid @enderror"
                            value="{{ old('nik_ayah', $orangtua->nik_ayah ?? '') }}">
                        @error('nik_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_ayah"
                            class="form-control @error('tempat_lahir_ayah') is-invalid @enderror"
                            value="{{ old('tempat_lahir_ayah', $orangtua->tempat_lahir_ayah ?? '') }}">
                        @error('tempat_lahir_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_ayah"
                            class="form-control @error('tanggal_lahir_ayah') is-invalid @enderror"
                            value="{{ old('tanggal_lahir_ayah', $orangtua->tanggal_lahir_ayah ?? '') }}">
                        @error('tanggal_lahir_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="agama_ayah" class="form-label">Agama</label>
                        <input type="text" name="agama_ayah"
                            class="form-control @error('agama_ayah') is-invalid @enderror"
                            value="{{ old('agama_ayah', $orangtua->agama_ayah ?? '') }}">
                        @error('agama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kewarganegaraan_ayah" class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan_ayah"
                            class="form-control @error('kewarganegaraan_ayah') is-invalid @enderror"
                            value="{{ old('kewarganegaraan_ayah', $orangtua->kewarganegaraan_ayah ?? '') }}">
                        @error('kewarganegaraan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pendidikan_ayah" class="form-label">Pendidikan</label>
                        <input type="text" name="pendidikan_ayah"
                            class="form-control @error('pendidikan_ayah') is-invalid @enderror"
                            value="{{ old('pendidikan_ayah', $orangtua->pendidikan_ayah ?? '') }}">
                        @error('pendidikan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan_ayah"
                            class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                            value="{{ old('pekerjaan_ayah', $orangtua->pekerjaan_ayah ?? '') }}">
                        @error('pekerjaan_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat_rumah_ayah" class="form-label">Alamat Rumah</label>
                    <textarea name="alamat_rumah_ayah" class="form-control @error('alamat_rumah_ayah') is-invalid @enderror"
                        rows="2">{{ old('alamat_rumah_ayah', $orangtua->alamat_rumah_ayah ?? '') }}</textarea>
                    @error('alamat_rumah_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telepon_ayah" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon_ayah"
                        class="form-control @error('no_telepon_ayah') is-invalid @enderror"
                        value="{{ old('no_telepon_ayah', $orangtua->no_telepon_ayah ?? '') }}">
                    @error('no_telepon_ayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ibu -->
                <h5 class="fw-bold mb-3">Data Ibu</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu"
                            class="form-control @error('nama_ibu') is-invalid @enderror"
                            value="{{ old('nama_ibu', $orangtua->nama_ibu ?? '') }}">
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik_ibu" class="form-label">NIK Ibu</label>
                        <input type="text" name="nik_ibu"
                            class="form-control @error('nik_ibu') is-invalid @enderror"
                            value="{{ old('nik_ibu', $orangtua->nik_ibu ?? '') }}">
                        @error('nik_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_ibu"
                            class="form-control @error('tempat_lahir_ibu') is-invalid @enderror"
                            value="{{ old('tempat_lahir_ibu', $orangtua->tempat_lahir_ibu ?? '') }}">
                        @error('tempat_lahir_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_ibu"
                            class="form-control @error('tanggal_lahir_ibu') is-invalid @enderror"
                            value="{{ old('tanggal_lahir_ibu', $orangtua->tanggal_lahir_ibu ?? '') }}">
                        @error('tanggal_lahir_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="agama_ibu" class="form-label">Agama</label>
                        <input type="text" name="agama_ibu"
                            class="form-control @error('agama_ibu') is-invalid @enderror"
                            value="{{ old('agama_ibu', $orangtua->agama_ibu ?? '') }}">
                        @error('agama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kewarganegaraan_ibu" class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan_ibu"
                            class="form-control @error('kewarganegaraan_ibu') is-invalid @enderror"
                            value="{{ old('kewarganegaraan_ibu', $orangtua->kewarganegaraan_ibu ?? '') }}">
                        @error('kewarganegaraan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pendidikan_ibu" class="form-label">Pendidikan</label>
                        <input type="text" name="pendidikan_ibu"
                            class="form-control @error('pendidikan_ibu') is-invalid @enderror"
                            value="{{ old('pendidikan_ibu', $orangtua->pendidikan_ibu ?? '') }}">
                        @error('pendidikan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan_ibu"
                            class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                            value="{{ old('pekerjaan_ibu', $orangtua->pekerjaan_ibu ?? '') }}">
                        @error('pekerjaan_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat_rumah_ibu" class="form-label">Alamat Rumah</label>
                    <textarea name="alamat_rumah_ibu" class="form-control @error('alamat_rumah_ibu') is-invalid @enderror"
                        rows="2">{{ old('alamat_rumah_ibu', $orangtua->alamat_rumah_ibu ?? '') }}</textarea>
                    @error('alamat_rumah_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telepon_ibu" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon_ibu"
                        class="form-control @error('no_telepon_ibu') is-invalid @enderror"
                        value="{{ old('no_telepon_ibu', $orangtua->no_telepon_ibu ?? '') }}">
                    @error('no_telepon_ibu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('form.identitas_anak', $id_pendaftaran) }}"
                        class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
