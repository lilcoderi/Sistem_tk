@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Tingkat Pencapaian
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
                            <a href="{{ route('modulAjar.index') }}">Modul Ajar</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Modul Pembelajaran ke 1
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-gradient-success text-white text-center rounded-top-3">
                        <h3 class="mb-0 fw-bold">
                            <i class="bi bi-journal-text me-2"></i> Pilih Jumlah Modul Ajar
                        </h3>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form method="POST" action="{{ route('modulAjar.createStep2') }}" novalidate>
                            @csrf

                            <!-- Dropdown Tema -->
                            <div class="mb-4">
                                <label for="tema_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-book me-1"></i> Tema
                                </label>
                                <select name="tema_id" id="tema_id" class="form-select form-select-lg border-3 shadow-sm">
                                    <option value="">-- Pilih Tema --</option>
                                    @foreach ($temas as $tema)
                                        <option value="{{ $tema->id }}">{{ $tema->tema }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Subtema -->
                            <div class="mb-4">
                                <label for="subtema_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-bookmark me-1"></i> Subtema (Opsional)
                                </label>
                                <select name="subtema_id" id="subtema_id"
                                    class="form-select form-select-lg border-3 shadow-sm">
                                    <option value="">-- Pilih Subtema --</option>
                                    {{-- Nanti diisi via JavaScript --}}
                                </select>
                            </div>


                            <div class="mb-4">
                                <label for="lingkup_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-diagram-3 me-1"></i> Lingkup Perkembangan
                                </label>
                                <select name="lingkup_id" id="lingkup_id"
                                    class="form-select form-select-lg border-3 shadow-sm" required>
                                    <option value="">-- Pilih Lingkup --</option>
                                    @foreach ($lingkups as $lingkup)
                                        <option value="{{ $lingkup->id }}">{{ $lingkup->nama_lingkup }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <fieldset class="mb-4">
                                <legend class="col-form-label fw-semibold text-success mb-2">
                                    <i class="bi bi-card-checklist me-1"></i> Pilih Jenis Format Penilaian
                                </legend>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ceklis_anekdot" id="ceklis"
                                        value="Ceklis" required>
                                    <label class="form-check-label fw-semibold" for="ceklis">Ceklis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ceklis_anekdot" id="anekdot"
                                        value="Anekdot" required>
                                    <label class="form-check-label fw-semibold" for="anekdot">Anekdot</label>
                                </div>
                            </fieldset>

                            <div class="mb-5">
                                <label for="jumlah" class="form-label fw-semibold text-success">
                                    <i class="bi bi-list-ol me-1"></i> Jumlah Modul Ajar
                                </label>
                                <input type="number" name="jumlah" id="jumlah"
                                    class="form-control form-control-lg border-3 shadow-sm" required min="1"
                                    placeholder="Masukkan jumlah modul">
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-danger fw-semibold shadow-sm px-4">
                                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success fw-semibold shadow-sm px-5">
                                    <i class="bi bi-arrow-right-circle me-2"></i> Lanjutkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-success {
            background: linear-gradient(90deg, #198754 0%, #3cd070 100%);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const temaSelect = document.getElementById('tema_id');
            const subtemaSelect = document.getElementById('subtema_id');

            temaSelect.addEventListener('change', function() {
                const temaId = this.value;
                subtemaSelect.innerHTML = '<option value="">Memuat...</option>';

                fetch(`/get-subtema/${temaId}`)
                    .then(res => res.json())
                    .then(data => {
                        subtemaSelect.innerHTML = '<option value="">-- Pilih Subtema --</option>';
                        data.forEach(subtema => {
                            const option = document.createElement('option');
                            option.value = subtema.id;
                            option.textContent = subtema.sub_tema;
                            subtemaSelect.appendChild(option);
                        });
                    })
                    .catch(() => {
                        subtemaSelect.innerHTML = '<option value="">Gagal memuat</option>';
                    });
            });
        });
    </script>
@endsection
