@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Modul Ajar
@endsection

@push('styles')
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
@endpush

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
                            <a href="{{ route('modulAjar.index') }}">Modul Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Modul Pembelajaran
                        </li>
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
                            <i class="bi bi-journal-bookmark-fill me-2"></i> Edit Modul Ajar
                        </h4>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form method="POST" action="{{ route('modulAjar.update', $modul->id) }}" novalidate>
                            @csrf
                            @method('PUT')

                            {{-- Dropdown Tema --}}
                            <div class="mb-4">
                                <label for="tema_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-book me-1"></i> Tema
                                </label>
                                <select id="tema_id" class="form-select form-select-lg border-3 shadow-sm">
                                    <option value="">-- Pilih Tema --</option>
                                    @foreach ($temas as $tema)
                                        <option value="{{ $tema->id }}"
                                            {{ optional($modul->subtema)->tema_id == $tema->id ? 'selected' : '' }}>
                                            {{ $tema->tema }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dropdown Subtema --}}
                            <div class="mb-4">
                                <label for="subtema_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-bookmark me-1"></i> Subtema (Opsional)
                                </label>
                                <select name="subtema_id" id="subtema_id"
                                    class="form-select form-select-lg border-3 shadow-sm">
                                    <option value="">-- Pilih Subtema --</option>
                                    @foreach ($subtemas as $subtema)
                                        @if (optional($subtema->tematk)->id == optional($modul->subtema)->tema_id)
                                            <option value="{{ $subtema->id }}"
                                                {{ $modul->subtema_id == $subtema->id ? 'selected' : '' }}>
                                                {{ $subtema->sub_tema }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>



                            <div class="mb-4">
                                <label for="lingkup_id" class="form-label fw-semibold text-success">
                                    <i class="bi bi-grid-3x3-gap me-1"></i> Lingkup
                                </label>
                                <select name="lingkup_id" id="lingkup_id"
                                    class="form-select form-select-lg border-3 shadow-sm" required>
                                    @foreach ($lingkups as $lingkup)
                                        <option value="{{ $lingkup->id }}"
                                            {{ $modul->lingkup_id == $lingkup->id ? 'selected' : '' }}>
                                            {{ $lingkup->nama_lingkup }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="rencana_pembelajaran" class="form-label fw-semibold text-success">
                                    <i class="bi bi-journal-text me-1"></i> Rencana Pembelajaran
                                </label>
                                <textarea name="rencana_pembelajaran" id="rencana_pembelajaran" class="form-control form-control-lg border-3 shadow-sm"
                                    rows="5" required>{{ $modul->rencana_pembelajaran }}</textarea>
                            </div>

                            <div class="mb-5">
                                <label for="ceklis_anekdot" class="form-label fw-semibold text-success">
                                    <i class="bi bi-check2-square me-1"></i> Ceklis / Anekdot
                                </label>
                                <select name="ceklis_anekdot" id="ceklis_anekdot"
                                    class="form-select form-select-lg border-3 shadow-sm" required>
                                    <option value="Ceklis" {{ $modul->ceklis_anekdot == 'Ceklis' ? 'selected' : '' }}>
                                        Ceklis</option>
                                    <option value="Anekdot" {{ $modul->ceklis_anekdot == 'Anekdot' ? 'selected' : '' }}>
                                        Anekdot</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('modulAjar.index') }}"
                                    class="btn btn-outline-danger fw-semibold shadow-sm px-4">
                                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success fw-semibold shadow-sm px-5">
                                    <i class="bi bi-check2-circle me-2"></i> Update
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
