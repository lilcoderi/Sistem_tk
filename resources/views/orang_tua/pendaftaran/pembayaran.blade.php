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

        .logo-img {
            height: 60px;
            width: auto;
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
                <div class="step active"></div>
            </div>

            <div class="text-center">
                <h4 class="fw-bold mb-4">Pembayaran Pendaftaran</h4>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <p>Silakan melakukan pembayaran sebesar <strong>Rp150.000</strong> sebagai biaya pendaftaran pada:</p>

                <img src="{{ asset('images/bca.png') }}" alt="BCA" class="logo-img mx-auto d-block my-3">
                <h4>1342546395</h4>
                <p>A. N. HARTONO</p>
            </div>

            <form action="{{ route('pembayaran.store', $id_pendaftaran) }}" method="POST" enctype="multipart/form-data"
                class="mt-4">
                @csrf

                <label class="form-label preview-label">Upload bukti pembayaran</label>
                <div class="upload-card text-center" onclick="document.getElementById('bukti_pembayaran').click()">
                    Klik di sini untuk upload bukti pembayaran
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*"
                        onchange="previewImage(this, 'preview-bukti')" {{ isset($pembayaran) ? '' : 'required' }}>
                    <div id="preview-bukti">
                        @if (isset($pembayaran) && $pembayaran->bukti_pembayaran)
                            <img src="{{ $pembayaran->bukti_pembayaran }}"
                                alt="Bukti Pembayaran Sebelumnya" class="img-fluid mt-2" />
                        @endif
                    </div>
                </div>


                @error('bukti_pembayaran')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dokumen.create', $id_pendaftaran) }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan & Selesai</button>
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
