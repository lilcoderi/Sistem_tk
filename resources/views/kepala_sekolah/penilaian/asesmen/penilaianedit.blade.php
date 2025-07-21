@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Penilaian
@endsection

{{-- Bootstrap Icons --}}
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
                            <a href="{{ route('detail-asesmen.index', ['id_siswa' => $detail->asesmen->id_siswa]) }}">
                                Asesmen Pembelajaran
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Edit Penilaian
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h4>Edit Penilaian - {{ $detail->asesmen->siswa->nama_lengkap ?? '-' }}</h4>

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('detail-asesmen.update', $detail->id_detail) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_asesmen" value="{{ $detail->id_asesmen }}">
            <input type="hidden" name="modulajar_id" value="{{ $detail->modulajar_id }}">

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th>Rencana Pembelajaran</th>
                        <th style="width: 300px;">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{!! nl2br(e($detail->modulAjar->rencana_pembelajaran)) !!}</td>
                        <td>
                            <div class="star-rating" data-index="1">
                                @php
                                    $skalaMapping = ['BB', 'MB', 'BSH', 'BSB'];
                                    $nilai = array_search($detail->skala_nilai, $skalaMapping) + 1;
                                @endphp

                                @for ($i = 1; $i <= 4; $i++)
                                    <i class="bi bi-star-fill star-icon {{ $i <= $nilai ? 'text-warning' : 'text-secondary' }}"
                                       data-value="{{ $i }}"></i>
                                @endfor
                                <input type="hidden" name="skala_nilai" id="skala_nilai" value="{{ $detail->skala_nilai }}">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <a href="{{ route('detail-asesmen.index', ['id_siswa' => $detail->asesmen->id_siswa]) }}"
                    class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
            </div>
        </form>
    </div>

    <style>
        .star-icon {
            font-size: 24px;
            cursor: pointer;
            margin-right: 4px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star-rating .star-icon');
            const input = document.getElementById('skala_nilai');
            const skalaMap = {
                1: 'BB',
                2: 'MB',
                3: 'BSH',
                4: 'BSB'
            };

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const val = parseInt(this.getAttribute('data-value'));

                    // Update hidden input
                    input.value = skalaMap[val];

                    // Update star colors
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-value')) <= val) {
                            s.classList.remove('text-secondary');
                            s.classList.add('text-warning');
                        } else {
                            s.classList.remove('text-warning');
                            s.classList.add('text-secondary');
                        }
                    });
                });
            });
        });
    </script>
@endsection
