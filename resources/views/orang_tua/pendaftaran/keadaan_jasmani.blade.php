{{-- resources/views/orang_tua/pendaftaran/keadaan_jasmani.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Orang Tua</title>

    {{-- Favicon & Fonts --}}
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
            position: relative;
        }

        .step.active {
            background-color: #28a745;
        }

        .step:first-child {
            margin-left: 0;
        }

        .step:last-child {
            margin-right: 0;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow p-4 col-md-10 mx-auto">
            <h4 class="fw-bold mb-4">Keadaan Jasmani dan Kesehatan Anak (4/4)</h4>

            <!-- Multi-step Indicator -->
            <div class="step-wizard">
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step active"></div>
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

            <form method="POST" action="{{ route('keadaan_jasmani.store', $id_pendaftaran) }}">
                @csrf

                @php
                    function selected($value, $compare)
                    {
                        return $value == $compare ? 'selected' : '';
                    }

                    function inputValue($field, $keadaan)
                    {
                        return old($field) ?? ($keadaan->$field ?? '');
                    }
                @endphp

                <div class="mb-3">
                    <label for="keadaan_waktu_kandungan" class="form-label">Keadaan anak pada waktu dalam
                        kandungan</label>
                    <select class="form-select @error('keadaan_waktu_kandungan') is-invalid @enderror"
                        name="keadaan_waktu_kandungan" id="keadaan_waktu_kandungan" required>
                        <option value="" disabled
                            {{ inputValue('keadaan_waktu_kandungan', $keadaan) ? '' : 'selected' }}>Pilih keadaan
                        </option>
                        <option value="Normal"
                            {{ selected(inputValue('keadaan_waktu_kandungan', $keadaan), 'Normal') }}>Normal</option>
                        <option value="Tidak" {{ selected(inputValue('keadaan_waktu_kandungan', $keadaan), 'Tidak') }}>
                            Tidak</option>
                    </select>
                    @error('keadaan_waktu_kandungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keadaan_waktu_dilahirkan" class="form-label">Keadaan anak dalam 12 bulan pertama</label>
                    <select class="form-select @error('keadaan_waktu_dilahirkan') is-invalid @enderror"
                        name="keadaan_waktu_dilahirkan" id="keadaan_waktu_dilahirkan" required>
                        <option value="" disabled
                            {{ inputValue('keadaan_waktu_dilahirkan', $keadaan) ? '' : 'selected' }}>Pilih keadaan
                        </option>
                        <option value="Normal"
                            {{ selected(inputValue('keadaan_waktu_dilahirkan', $keadaan), 'Normal') }}>Normal</option>
                        <option value="Tidak"
                            {{ selected(inputValue('keadaan_waktu_dilahirkan', $keadaan), 'Tidak') }}>Tidak</option>
                    </select>
                    @error('keadaan_waktu_dilahirkan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="anak_disusui_asi" class="form-label">Anak disusui ASI (selama 6 bulan)</label>
                    <select class="form-select @error('anak_disusui_asi') is-invalid @enderror" name="anak_disusui_asi"
                        id="anak_disusui_asi" required>
                        <option value="" disabled
                            {{ inputValue('anak_disusui_asi', $keadaan) ? '' : 'selected' }}>Pilih keadaan</option>
                        <option value="Normal" {{ selected(inputValue('anak_disusui_asi', $keadaan), 'Normal') }}>
                            Normal</option>
                        <option value="Tidak" {{ selected(inputValue('anak_disusui_asi', $keadaan), 'Tidak') }}>Tidak
                        </option>
                    </select>
                    @error('anak_disusui_asi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="makanan_tambahan" class="form-label">Makanan tambahan yang diberikan selama 6
                        bulan</label>
                    <input type="text" class="form-control @error('makanan_tambahan') is-invalid @enderror"
                        name="makanan_tambahan" id="makanan_tambahan"
                        value="{{ inputValue('makanan_tambahan', $keadaan) }}" required>
                    @error('makanan_tambahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kelainan_cacat_yang_diderita" class="form-label">Kelainan/cacat yang diderita</label>
                    <textarea class="form-control @error('kelainan_cacat_yang_diderita') is-invalid @enderror"
                        name="kelainan_cacat_yang_diderita" id="kelainan_cacat_yang_diderita" rows="2">{{ inputValue('kelainan_cacat_yang_diderita', $keadaan) }}</textarea>
                    @error('kelainan_cacat_yang_diderita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cara_anak_minum_susu" class="form-label">Cara anak minum susu</label>
                    <select class="form-select @error('cara_anak_minum_susu') is-invalid @enderror"
                        name="cara_anak_minum_susu" id="cara_anak_minum_susu" required>
                        <option value="" disabled
                            {{ inputValue('cara_anak_minum_susu', $keadaan) ? '' : 'selected' }}>Pilih cara minum
                        </option>
                        <option value="Gelas" {{ selected(inputValue('cara_anak_minum_susu', $keadaan), 'Gelas') }}>
                            Gelas</option>
                        <option value="Masih pakai botol"
                            {{ selected(inputValue('cara_anak_minum_susu', $keadaan), 'Masih pakai botol') }}>Masih
                            pakai botol</option>
                    </select>
                    @error('cara_anak_minum_susu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="apakah_masih_pakai_diaper" class="form-label">Apakah anak masih menggunakan
                        diaper</label>
                    <select class="form-select @error('apakah_masih_pakai_diaper') is-invalid @enderror"
                        name="apakah_masih_pakai_diaper" id="apakah_masih_pakai_diaper" required>
                        <option value="" disabled
                            {{ inputValue('apakah_masih_pakai_diaper', $keadaan) ? '' : 'selected' }}>Pilih jawaban
                        </option>
                        <option value="Ya" {{ selected(inputValue('apakah_masih_pakai_diaper', $keadaan), 'Ya') }}>
                            Ya</option>
                        <option value="Tidak"
                            {{ selected(inputValue('apakah_masih_pakai_diaper', $keadaan), 'Tidak') }}>Tidak</option>
                    </select>
                    @error('apakah_masih_pakai_diaper')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('keadaan_anak.create', $id_pendaftaran) }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Lanjutkan</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>
