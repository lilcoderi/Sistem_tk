@extends('kepala_sekolah.layouts.app')

@section('title')
    Manajemen Data Guru
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
                            <a href="{{ route('user.index') }}">Manajemen Role</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h3>Tambah User Baru</h3>

        <form method="POST" action="{{ route('user.store') }}">
            @csrf

            <div class="form-group mt-2">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Pilih Role</label>
                <select name="role" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>
@endsection
