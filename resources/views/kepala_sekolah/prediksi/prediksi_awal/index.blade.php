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
                            <a href="{{ route('asesmen.index') }}">Asesmen Pembelajaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container mt-5">
        <h3 class="mb-4">🧠 Hasil Prediksi Sistem Pakar</h3>

        <div class="card border-warning shadow">
            <div class="card-body">
                <h5 class="card-title text-warning">Prediksi Awal</h5>
                <p class="fs-5">{{ $data['prediksi_awal'] }}</p>

                <h5 class="card-title text-success">Rekomendasi</h5>
                <p>{{ $data['rekomendasi_awal'] }}</p>

                <h5 class="card-title text-primary">Catatan Sistem Pakar:</h5>
                <ul class="mb-0">
                    @foreach ($data['catatan_sistem_pakar'] as $catatan)
                        <li>{{ $catatan }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
