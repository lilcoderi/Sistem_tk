@extends('kepala_sekolah.layouts.app')

@section('title')
    Tambah Asesmen Pembelajaran
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
                            <a href="{{ route('asesmen.index') }}">Asesmen Pembelajaran</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('asesmen.create') }}">Tambah Asesmen Pembelajaran</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <div class="container">
        <h1 class="mb-4">Tambah Asesmen</h1>

        <form action="{{ route('asesmen.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="id_siswa" class="form-label">Siswa</label>
                <select name="id_siswa" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_guru" class="form-label">Guru</label>
                <select name="id_guru" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_subtema" class="form-label">Subtema</label>
                <select name="id_subtema" id="subtemaSelect" class="form-select" required>
                    <option value="">-- Pilih Subtema --</option>
                    @foreach ($subtemas as $subtema)
                        <option value="{{ $subtema->id }}"
                            data-tema="{{ $subtema->tematk->tema ?? 'Tidak Diketahui' }}">
                            {{ $subtema->sub_tema }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tema</label>
                <input type="text" id="temaDisplay" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="text" name="semester" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="tahun_ajar" class="form-label">Tahun Ajar</label>
                <input type="text" name="tahun_ajar" class="form-control" placeholder="contoh: 2024/2025" required>
            </div>

            <div class="mb-3">
                <label for="tipe_penilaian" class="form-label">Tipe Penilaian</label>
                <select name="tipe_penilaian" class="form-select" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="anekdot">Anekdot</option>
                    <option value="ceklis">Ceklis</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('asesmen.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        document.getElementById('subtemaSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const tema = selectedOption.getAttribute('data-tema');
            document.getElementById('temaDisplay').value = tema;
        });
    </script>
@endsection
