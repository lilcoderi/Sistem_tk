@extends('kepala_sekolah.layouts.app')

@section('title')
    Asesmen Pembelajaran
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

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
                            <a href="{{ route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa]) }}">Asesmen
                                Pembelajaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h4>Input Penilaian - {{ $asesmen->siswa->nama }}</h4>

        {{-- Form Filter Lingkup --}}
        <form method="GET" action="{{ route('detail-asesmen.create', ['id_siswa' => $asesmen->id_siswa]) }}" class="mb-4">
            <div class="form-group">
                <label for="lingkup_id">Filter Lingkup Perkembangan</label>
                <select name="lingkup_id" id="lingkup_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Semua Lingkup --</option>
                    @foreach ($lingkupOptions as $lingkup)
                        <option value="{{ $lingkup->id }}" {{ $selectedLingkup == $lingkup->id ? 'selected' : '' }}>
                            {{ $lingkup->nama_lingkup }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Tabel Penilaian --}}
        @if ($filteredModuls->isNotEmpty())
            <form method="POST" action="{{ route('detail-asesmen.store') }}">
                @csrf
                <input type="hidden" name="id_asesmen" value="{{ $asesmen->id_asesmen }}">

                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th>Rencana Pembelajaran</th>
                            <th style="width: 300px;">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filteredModuls as $index => $modul)
                            @php
                                $nilaiTersimpan = $nilaiLama[$modul->id]->skala_nilai ?? null;
                                $nilaiMap = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
                                $nilaiAngka = $nilaiMap[$nilaiTersimpan] ?? 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{!! nl2br(e($modul->rencana_pembelajaran)) !!}</td>
                                <td>
                                    <div class="star-rating" data-index="{{ $index }}">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <i class="bi bi-star-fill star-icon {{ $i <= $nilaiAngka ? 'text-warning' : 'text-secondary' }}" 
                                                data-value="{{ $i }}"></i>
                                        @endfor
                                    </div>

                                    {{-- Hidden input to store selected value --}}
                                    <input type="hidden" name="penilaian[{{ $index }}][skala_nilai]" id="nilai_{{ $index }}" 
                                        value="{{ $nilaiTersimpan }}">
                                    <input type="hidden" name="penilaian[{{ $index }}][modulajar_id]" value="{{ $modul->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa]) }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
            </form>
        @else
            <div class="alert alert-warning mt-3">
                Tidak ada data modul ajar untuk lingkup ini.
            </div>
        @endif
    </div>

    <style>
        .star-icon {
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s;
            margin-right: 4px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nilaiMap = {
                1: 'BB',
                2: 'MB',
                3: 'BSH',
                4: 'BSB'
            };

            document.querySelectorAll('.star-rating').forEach(function (container) {
                const index = container.getAttribute('data-index');
                const stars = container.querySelectorAll('.star-icon');

                stars.forEach(function (star, i) {
                    star.addEventListener('click', function () {
                        const rating = i + 1;

                        // Update star color
                        stars.forEach((s, j) => {
                            if (j < rating) {
                                s.classList.add('text-warning');
                                s.classList.remove('text-secondary');
                            } else {
                                s.classList.remove('text-warning');
                                s.classList.add('text-secondary');
                            }
                        });

                        // Set nilai ke hidden input
                        document.getElementById('nilai_' + index).value = nilaiMap[rating];
                    });
                });
            });
        });
    </script>
@endsection
