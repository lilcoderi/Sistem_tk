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
            <h4 class="fw-bold mb-4">Keadaan Anak dalam Keluarga (3/4)</h4>

            <!-- Multi-step Indicator -->
            <div class="step-wizard">
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step active"></div>
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

            <form method="POST" action="{{ route('keadaan_anak.store', $id_pendaftaran) }}">
                @csrf

                <h5 class="fw-bold mb-3">Keadaan pada waktu masuk TK</h5>

                <div class="mb-3">
                    <label for="rumah_waktu_masuk_tk" class="form-label me-3 mb-0" style="min-width: 250px;">Keadaan
                        saat di rumah:</label>
                    <select class="form-select" name="rumah_waktu_masuk_tk" id="rumah_waktu_masuk_tk" required>
                        <option value="" disabled
                            {{ old('rumah_waktu_masuk_tk', $kondisiAnak->rumah_waktu_masuk_tk ?? '') == '' ? 'selected' : '' }}>
                            Pilih keadaan rumah</option>
                        <option value="Rumah keluarga sendiri"
                            {{ old('rumah_waktu_masuk_tk', $kondisiAnak->rumah_waktu_masuk_tk ?? '') == 'Rumah keluarga sendiri' ? 'selected' : '' }}>
                            Rumah keluarga sendiri</option>
                        <option value="Dengan keluarga lain"
                            {{ old('rumah_waktu_masuk_tk', $kondisiAnak->rumah_waktu_masuk_tk ?? '') == 'Dengan keluarga lain' ? 'selected' : '' }}>
                            Dengan keluarga lain</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah_penguni_rumah" class="form-label">Jumlah penghuni rumah:</label>
                    <input type="number" class="form-control @error('jumlah_penguni_rumah') is-invalid @enderror"
                        id="jumlah_penguni_rumah" name="jumlah_penguni_rumah"
                        value="{{ old('jumlah_penguni_rumah', $kondisiAnak->jumlah_penguni_rumah ?? '') }}" required>
                    @error('jumlah_penguni_rumah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="pergaulan_dengan_teman" class="form-label me-3 mb-0" style="min-width: 250px;">Pergaulan
                        dengan teman sebaya:</label>
                    <select class="form-select" name="pergaulan_dengan_teman" id="pergaulan_dengan_teman" required
                        style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('pergaulan_dengan_teman', $kondisiAnak->pergaulan_dengan_teman ?? '') == '' ? 'selected' : '' }}>
                            Pilih pergaulan</option>
                        <option value="Banyak"
                            {{ old('pergaulan_dengan_teman', $kondisiAnak->pergaulan_dengan_teman ?? '') == 'Banyak' ? 'selected' : '' }}>
                            Banyak</option>
                        <option value="Cukup"
                            {{ old('pergaulan_dengan_teman', $kondisiAnak->pergaulan_dengan_teman ?? '') == 'Cukup' ? 'selected' : '' }}>
                            Cukup</option>
                        <option value="Kurang"
                            {{ old('pergaulan_dengan_teman', $kondisiAnak->pergaulan_dengan_teman ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="nafszu_makan" class="form-label me-3 mb-0" style="min-width: 250px;">Nafsu makan
                        Umum:</label>
                    <select class="form-select" name="nafszu_makan" id="nafszu_makan" required
                        style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('nafszu_makan', $kondisiAnak->nafszu_makan ?? '') == '' ? 'selected' : '' }}>Pilih
                            nafsu makan</option>
                        <option value="Banyak"
                            {{ old('nafszu_makan', $kondisiAnak->nafszu_makan ?? '') == 'Banyak' ? 'selected' : '' }}>
                            Banyak</option>
                        <option value="Cukup"
                            {{ old('nafszu_makan', $kondisiAnak->nafszu_makan ?? '') == 'Cukup' ? 'selected' : '' }}>
                            Cukup</option>
                        <option value="Kurang"
                            {{ old('nafszu_makan', $kondisiAnak->nafszu_makan ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="pagi_hari" class="form-label me-3 mb-0" style="min-width: 250px;">Nafsu makan
                        pagi:</label>
                    <select class="form-select" name="pagi_hari" id="pagi_hari" required style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('pagi_hari', $kondisiAnak->pagi_hari ?? '') == '' ? 'selected' : '' }}>Pilih nafsu
                            makan</option>
                        <option value="Banyak"
                            {{ old('pagi_hari', $kondisiAnak->pagi_hari ?? '') == 'Banyak' ? 'selected' : '' }}>
                            Banyak</option>
                        <option value="Cukup"
                            {{ old('pagi_hari', $kondisiAnak->pagi_hari ?? '') == 'Cukup' ? 'selected' : '' }}>Cukup
                        </option>
                        <option value="Kurang"
                            {{ old('pagi_hari', $kondisiAnak->pagi_hari ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="siang_hari" class="form-label me-3 mb-0" style="min-width: 250px;">Nafsu makan
                        siang:</label>
                    <select class="form-select" name="siang_hari" id="siang_hari" required style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('siang_hari', $kondisiAnak->siang_hari ?? '') == '' ? 'selected' : '' }}>Pilih
                            nafsu makan</option>
                        <option value="Banyak"
                            {{ old('siang_hari', $kondisiAnak->siang_hari ?? '') == 'Banyak' ? 'selected' : '' }}>
                            Banyak</option>
                        <option value="Cukup"
                            {{ old('siang_hari', $kondisiAnak->siang_hari ?? '') == 'Cukup' ? 'selected' : '' }}>
                            Cukup</option>
                        <option value="Kurang"
                            {{ old('siang_hari', $kondisiAnak->siang_hari ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="malam_hari" class="form-label me-3 mb-0" style="min-width: 250px;">Nafsu makan
                        malam:</label>
                    <select class="form-select" name="malam_hari" id="malam_hari" required style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('malam_hari', $kondisiAnak->malam_hari ?? '') == '' ? 'selected' : '' }}>Pilih
                            nafsu makan</option>
                        <option value="Banyak"
                            {{ old('malam_hari', $kondisiAnak->malam_hari ?? '') == 'Banyak' ? 'selected' : '' }}>
                            Banyak</option>
                        <option value="Cukup"
                            {{ old('malam_hari', $kondisiAnak->malam_hari ?? '') == 'Cukup' ? 'selected' : '' }}>
                            Cukup</option>
                        <option value="Kurang"
                            {{ old('malam_hari', $kondisiAnak->malam_hari ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>
                <div class="mb-3 d-flex align-items-center">
                    <label for="hubungan_dengan_ayah" class="form-label me-3 mb-0" style="min-width: 250px;">Hubungan
                        dengan ayah:</label>
                    <select class="form-select" name="hubungan_dengan_ayah" id="hubungan_dengan_ayah" required
                        style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('hubungan_dengan_ayah', $kondisiAnak->hubungan_dengan_ayah ?? '') == '' ? 'selected' : '' }}>
                            Pilih hubungan ayah</option>
                        <option value="Baik sekali"
                            {{ old('hubungan_dengan_ayah', $kondisiAnak->hubungan_dengan_ayah ?? '') == 'Baik sekali' ? 'selected' : '' }}>
                            Baik sekali</option>
                        <option value="Cukup"
                            {{ old('hubungan_dengan_ayah', $kondisiAnak->hubungan_dengan_ayah ?? '') == 'Cukup' ? 'selected' : '' }}>
                            Cukup</option>
                        <option value="Kurang"
                            {{ old('hubungan_dengan_ayah', $kondisiAnak->hubungan_dengan_ayah ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="hubungan_dengan_ibu" class="form-label me-3 mb-0" style="min-width: 250px;">Hubungan
                        dengan ibu:</label>
                    <select class="form-select" name="hubungan_dengan_ibu" id="hubungan_dengan_ibu" required
                        style="max-width: 200px;">
                        <option value="" disabled
                            {{ old('hubungan_dengan_ibu', $kondisiAnak->hubungan_dengan_ibu ?? '') == '' ? 'selected' : '' }}>
                            Pilih hubungan ibu</option>
                        <option value="Baik sekali"
                            {{ old('hubungan_dengan_ibu', $kondisiAnak->hubungan_dengan_ibu ?? '') == 'Baik sekali' ? 'selected' : '' }}>
                            Baik sekali</option>
                        <option value="Cukup"
                            {{ old('hubungan_dengan_ibu', $kondisiAnak->hubungan_dengan_ibu ?? '') == 'Cukup' ? 'selected' : '' }}>
                            Cukup</option>
                        <option value="Kurang"
                            {{ old('hubungan_dengan_ibu', $kondisiAnak->hubungan_dengan_ibu ?? '') == 'Kurang' ? 'selected' : '' }}>
                            Kurang</option>
                    </select>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="kebersihan_buang_air" class="form-label me-3 mb-0"
                        style="min-width: 250px;">Kebersihan waktu buang air:</label>
                    <select class="form-select" name="kebersihan_buang_air" id="kebersihan_buang_air" required
                        style="max-width: 250px;">
                        <option value="" disabled
                            {{ old('kebersihan_buang_air', $kondisiAnak->kebersihan_buang_air ?? '') == '' ? 'selected' : '' }}>
                            Pilih kebersihan</option>
                        <option value="Dibantu"
                            {{ old('kebersihan_buang_air', $kondisiAnak->kebersihan_buang_air ?? '') == 'Dibantu' ? 'selected' : '' }}>
                            Dibantu</option>
                        <option value="Tidak harus dibantu"
                            {{ old('kebersihan_buang_air', $kondisiAnak->kebersihan_buang_air ?? '') == 'Tidak harus dibantu' ? 'selected' : '' }}>
                            Tidak harus dibantu</option>
                    </select>
                </div>
                @php
                    use Carbon\Carbon;
                @endphp

                <div class="mb-3">
                    <label class="form-label">Tidur Siang:</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="time" class="form-control @error('tidur_siang_mulai') is-invalid @enderror"
                            id="tidur_siang_mulai" name="tidur_siang_mulai"
                            value="{{ old('tidur_siang_mulai') ?? (optional($kondisiAnak)->tidur_siang_mulai ? Carbon::parse(optional($kondisiAnak)->tidur_siang_mulai)->format('H:i') : '') }}">
                        <span class="mx-2">s/d</span>
                        <input type="time" class="form-control @error('tidur_siang_selesai') is-invalid @enderror"
                            id="tidur_siang_selesai" name="tidur_siang_selesai"
                            value="{{ old('tidur_siang_selesai') ?? (optional($kondisiAnak)->tidur_siang_selesai ? Carbon::parse(optional($kondisiAnak)->tidur_siang_selesai)->format('H:i') : '') }}">
                    </div>
                    @error('tidur_siang_mulai')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('tidur_siang_selesai')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tidur Malam:</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="time" class="form-control @error('tidur_malam_mulai') is-invalid @enderror"
                            id="tidur_malam_mulai" name="tidur_malam_mulai"
                            value="{{ old('tidur_malam_mulai') ?? (optional($kondisiAnak)->tidur_malam_mulai ? Carbon::parse(optional($kondisiAnak)->tidur_malam_mulai)->format('H:i') : '') }}">
                        <span class="mx-2">s/d</span>
                        <input type="time" class="form-control @error('tidur_malam_selesai') is-invalid @enderror"
                            id="tidur_malam_selesai" name="tidur_malam_selesai"
                            value="{{ old('tidur_malam_selesai') ?? (optional($kondisiAnak)->tidur_malam_selesai ? Carbon::parse(optional($kondisiAnak)->tidur_malam_selesai)->format('H:i') : '') }}">
                    </div>
                    @error('tidur_malam_mulai')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('tidur_malam_selesai')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="hal_lain_waktu_tidur" class="form-label">Hal lain waktu tidur:</label>
                    <textarea class="form-control @error('hal_lain_waktu_tidur') is-invalid @enderror" id="hal_lain_waktu_tidur"
                        name="hal_lain_waktu_tidur" rows="2">{{ old('hal_lain_waktu_tidur', $kondisiAnak->hal_lain_waktu_tidur ?? '') }}</textarea>
                    @error('hal_lain_waktu_tidur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <label for="sikap_anak_dirumah" class="form-label mb-0 me-3" style="min-width: 250px;">Sikap anak
                        di rumah:</label>
                    <select class="form-select @error('sikap_anak_dirumah') is-invalid @enderror"
                        name="sikap_anak_dirumah" id="sikap_anak_dirumah" required style="max-width: 250px;">
                        <option value="" disabled
                            {{ old('sikap_anak_dirumah', $kondisiAnak->sikap_anak_dirumah ?? '') == '' ? 'selected' : '' }}>
                            Pilih sikap anak di rumah</option>
                        <option value="Mudah diatur"
                            {{ old('sikap_anak_dirumah', $kondisiAnak->sikap_anak_dirumah ?? '') == 'Mudah diatur' ? 'selected' : '' }}>
                            Mudah diatur</option>
                        <option value="Susah diatur"
                            {{ old('sikap_anak_dirumah', $kondisiAnak->sikap_anak_dirumah ?? '') == 'Susah diatur' ? 'selected' : '' }}>
                            Susah diatur</option>
                    </select>
                    @error('sikap_anak_dirumah')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="penyakit_pernah_diderita" class="form-label">Penyakit pernah
                        diderita:</label>
                    <textarea class="form-control @error('penyakit_pernah_diderita') is-invalid @enderror" id="penyakit_pernah_diderita"
                        name="penyakit_pernah_diderita" rows="2"> {{ old('penyakit_pernah_diderita', $kondisiAnak->penyakit_pernah_diderita ?? '') }}
                    </textarea>
                    @error('penyakit_pernah_diderita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="imunisasi_pernah_diterima" class="form-label">Imunisasi pernah
                        diterima:</label>
                    <textarea class="form-control @error('imunisasi_pernah_diterima') is-invalid @enderror" id="imunisasi_pernah_diterima"
                        name="imunisasi_pernah_diterima" rows="2"> {{ old('imunisasi_pernah_diterima', $kondisiAnak->imunisasi_pernah_diterima ?? '') }}
                    </textarea>
                    @error('imunisasi_pernah_diterima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Simpan & Lanjutkan</button>
                </div> --}}

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('orangtua.create', $id_pendaftaran) }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        Lanjutkan
                    </button>
                </div>
            </form>
        </div>
</body>

</html>
