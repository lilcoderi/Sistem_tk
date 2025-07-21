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
        }

        .step.active {
            background-color: #28a745;
        }

        .upload-card {
            border: 2px dashed #6c757d;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #f8f9fa;
            transition: border-color 0.3s ease;
        }

        .upload-card:hover {
            border-color: #28a745;
        }

        .upload-card img {
            max-width: 100%;
            margin-top: 15px;
            border-radius: 5px;
        }

        input[type="file"] {
            display: none;
        }

        .preview-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow p-4 col-md-10 mx-auto">

            <!-- Multi-step Indicator -->
            <div class="step-wizard">
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step"></div>
            </div>

            <h4 class="fw-bold mb-4">Dokumen Persyaratan Pendaftaran</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('dokumen.store', $id_pendaftaran) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Akta Kelahiran -->
                <div class="mb-4">
                    <label class="preview-label">Akta Kelahiran (JPG/PNG):</label>
                    <div class="upload-card" onclick="document.getElementById('akta_kelahiran').click()">
                        Klik di sini untuk upload file
                        <input type="file" name="akta_kelahiran" id="akta_kelahiran" accept="image/*"
                            onchange="previewImage(this, 'preview-akta')">
                        <div id="preview-akta">
                            @if (isset($dokumen->akta_kelahiran))
                                <img src="{{ asset('storage/' . $dokumen->akta_kelahiran) }}" class="img-fluid mt-2"
                                    alt="Akta Kelahiran">
                            @endif
                        </div>
                    </div>
                    @error('akta_kelahiran')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kartu Keluarga -->
                <div class="mb-4">
                    <label class="preview-label">Kartu Keluarga (JPG/PNG):</label>
                    <div class="upload-card" onclick="document.getElementById('kartu_keluarga').click()">
                        Klik di sini untuk upload file
                        <input type="file" name="kartu_keluarga" id="kartu_keluarga" accept="image/*"
                            onchange="previewImage(this, 'preview-kk')">
                        <div id="preview-kk">
                            @if (isset($dokumen->kartu_keluarga))
                                <img src="{{ asset('storage/' . $dokumen->kartu_keluarga) }}" class="img-fluid mt-2"
                                    alt="Kartu Keluarga">
                            @endif
                        </div>
                    </div>
                    @error('kartu_keluarga')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- KTP Orang Tua -->
                <div class="mb-4">
                    <label class="preview-label">KTP Orang Tua (JPG/PNG):</label>
                    <div class="upload-card" onclick="document.getElementById('ktp_orang_tua').click()">
                        Klik di sini untuk upload file
                        <input type="file" name="ktp_orang_tua" id="ktp_orang_tua" accept="image/*"
                            onchange="previewImage(this, 'preview-ktp')">
                        <div id="preview-ktp">
                            @if (isset($dokumen->ktp_orang_tua))
                                <img src="{{ asset('storage/' . $dokumen->ktp_orang_tua) }}" class="img-fluid mt-2"
                                    alt="KTP Orang Tua">
                            @endif
                        </div>
                    </div>
                    @error('ktp_orang_tua')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('keadaan_jasmani.create', $id_pendaftaran) }}"
                        class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            const file = input.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'mt-2');
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>
