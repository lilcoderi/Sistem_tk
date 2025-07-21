@extends('orang_tua.layouts.app')

@section('title')
    Dashboard Orang Tua
@endsection

@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('orang_tua.dashboard') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    {{-- Konten tambahan lainnya bisa ditaruh di sini --}}
    <!-- Selamat Datang -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                Selamat datang, {{ auth()->user()->name }}! Ini adalah dashboard Anda sebagai orang tua.
            </div>
        </div>
    </div>
@endsection
