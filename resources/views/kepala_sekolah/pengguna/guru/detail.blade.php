@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Data Guru
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
                            <a href="javascript:void(0)">Manajemen Pengguna</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('guru.index') }}">Manajemen Data Guru</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detail Data Guru
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container mt-4">
        <div class="card shadow rounded">
            <div class="card-header bg-success">
                <h4 class="mb-0 text-center" style="color: white;">Detail Guru</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Foto Guru --}}
                    <div class="col-md-4 text-center">
                        @if ($guru->photo)
                            <img src="{{ asset('storage/' . $guru->photo) }}" alt="Foto Guru" class="img-fluid rounded mb-3"
                                style="max-height: 300px;">
                        @else
                            <img src="https://via.placeholder.com/300x300?text=No+Photo" class="img-fluid rounded mb-3"
                                alt="No Photo">
                        @endif
                    </div>

                    {{-- Informasi Guru --}}
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $guru->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $guru->email }}</td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td>{{ $guru->nip ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kontak</th>
                                <td>{{ $guru->kontak ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $guru->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ $guru->user->getRoleNames()->implode(', ') }}</td>
                            </tr>
                        </table>

                        <a href="{{ route('guru.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
