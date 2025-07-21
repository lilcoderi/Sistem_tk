<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Anak</title>

    {{-- Favicon & Fonts --}}
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .progress-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .step {
            flex: 1;
            height: 6px;
            margin: 0 4px;
            background-color: #e0e0e0;
            border-radius: 3px;
        }

        .step.active {
            background-color: #28a745;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="card shadow p-4 col-md-8 mx-auto">
            <h4 class="fw-bold mb-4">Identitas Anak (1/6)</h4>

            <!-- Multi-Step Progress Bar -->
            <div class="progress-container mb-3">
                <div class="step active"></div>
                <div class="step"></div>
                <div class="step"></div>
                <div class="step"></div>
                <div class="step"></div>
                <div class="step"></div>
            </div>

            <!-- Tampilkan daftar error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tampilkan No. Pendaftaran -->
            <div class="mb-3">
                <label class="form-label fw-semibold">No. Pendaftaran:</label>
                <div class="border rounded px-3 py-2 bg-light">
                    {{ $id_pendaftaran }}
                </div>
            </div>

            <form method="POST" action="{{ route('simpan.identitas_anak', $id_pendaftaran) }}">
                @csrf

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" maxlength="255"
                        value="{{ old('nama_lengkap', $identitasAnak->nama_lengkap ?? '') }}" required>
                    @error('nama_lengkap')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                    <input type="text" class="form-control" name="nama_panggilan" maxlength="255"
                        value="{{ old('nama_panggilan', $identitasAnak->nama_panggilan ?? '') }}" required>
                    @error('nama_panggilan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" maxlength="16"
                        value="{{ old('nik', $identitasAnak->nik ?? '') }}" required>
                    @error('nik')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" maxlength="255"
                        value="{{ old('tempat_lahir', $identitasAnak->tempat_lahir ?? '') }}" required>
                    @error('tempat_lahir')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $identitasAnak->tanggal_lahir ?? '') }}" required>
                    @error('tanggal_lahir')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat_rumah" class="form-label">Alamat Tempat Tinggal</label>
                    <textarea class="form-control" name="alamat_rumah" rows="2" required>{{ old('alamat_rumah', $identitasAnak->alamat_rumah ?? '') }}</textarea>
                    @error('alamat_rumah')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="agama" class="form-label">Agama</label>
                    <input type="text" class="form-control" name="agama" maxlength="10"
                        value="{{ old('agama', $identitasAnak->agama ?? '') }}" required>
                    @error('agama')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kelompok" class="form-label">Pemilihan Kelas</label>
                    <select class="form-select" name="kelompok" required>
                        <option value="A"
                            {{ old('kelompok', $identitasAnak->kelompok ?? '') == 'A' ? 'selected' : '' }}>Kelas A (4-5
                            Tahun)</option>
                        <option value="B"
                            {{ old('kelompok', $identitasAnak->kelompok ?? '') == 'B' ? 'selected' : '' }}>Kelas B (5-6
                            Tahun)</option>
                    </select>
                    @error('kelompok')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Anak Ke</label>
                    <input type="number" class="form-control" name="anak_ke" min="1"
                        value="{{ old('anak_ke', $identitasAnak->anak_ke ?? '') }}" required>
                    @error('anak_ke')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Saudara</label>
                    <input type="number" class="form-control" name="jumlah_saudara" min="0"
                        value="{{ old('jumlah_saudara', $identitasAnak->jumlah_saudara ?? '') }}" required>
                    @error('jumlah_saudara')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Bahasa Sehari-hari</label>
                    <input type="text" class="form-control" name="bahasa_sehari_hari" maxlength="100"
                        value="{{ old('bahasa_sehari_hari', $identitasAnak->bahasa_sehari_hari ?? '') }}" required>
                    @error('bahasa_sehari_hari')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <select class="form-select" name="golongan_darah" required>
                        <option value="O"
                            {{ old('golongan_darah', $identitasAnak->golongan_darah ?? '') == 'O' ? 'selected' : '' }}>
                            O</option>
                        <option value="A"
                            {{ old('golongan_darah', $identitasAnak->golongan_darah ?? '') == 'A' ? 'selected' : '' }}>
                            A</option>
                        <option value="AB"
                            {{ old('golongan_darah', $identitasAnak->golongan_darah ?? '') == 'AB' ? 'selected' : '' }}>
                            AB</option>
                        <option value="B"
                            {{ old('golongan_darah', $identitasAnak->golongan_darah ?? '') == 'B' ? 'selected' : '' }}>
                            B</option>
                    </select>
                    @error('golongan_darah')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ciri-ciri Khusus</label>
                    <textarea class="form-control" name="ciri_khusus" rows="3">{{ old('ciri_khusus', $identitasAnak->ciri_khusus ?? '') }}</textarea>
                    @error('ciri_khusus')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Simpan & Lanjutkan</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
