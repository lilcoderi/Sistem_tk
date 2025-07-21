@extends('kepala_sekolah.layouts.app')

@section('title')
    Edit Asesmen
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('asesmen.create') }}">Edit Asesmen Pembelajaran</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <div class="container">
        <h1 class="mb-4">Edit Asesmen</h1>

        <form action="{{ route('asesmen.update', $asesmen->id_asesmen) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_siswa" class="form-label">Siswa</label>
                <select name="id_siswa" class="form-select" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}" {{ $asesmen->id_siswa == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_guru" class="form-label">Guru</label>
                <select name="id_guru" class="form-select" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ $asesmen->id_guru == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_subtema" class="form-label">Subtema</label>
                <select name="id_subtema" id="subtemaSelect" class="form-select" required>
                    <option value="">-- Pilih Subtema --</option>
                    @foreach ($subtemas as $subtema)
                        <option value="{{ $subtema->id }}"
                            data-tema="{{ $subtema->tematk->tema ?? 'Tidak Diketahui' }}"
                            {{ $asesmen->id_subtema == $subtema->id ? 'selected' : '' }}>
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
                <input type="text" name="semester" class="form-control" value="{{ $asesmen->semester }}" required>
            </div>

            <div class="mb-3">
                <label for="tahun_ajar" class="form-label">Tahun Ajar</label>
                <input type="text" name="tahun_ajar" class="form-control" value="{{ $asesmen->tahun_ajar }}" required>
            </div>

            <div class="mb-3">
                <label for="tipe_penilaian" class="form-label">Tipe Penilaian</label>
                <select name="tipe_penilaian" class="form-select" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="anekdot" {{ $asesmen->tipe_penilaian == 'anekdot' ? 'selected' : '' }}>Anekdot</option>
                    <option value="ceklis" {{ $asesmen->tipe_penilaian == 'ceklis' ? 'selected' : '' }}>Ceklis</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('asesmen.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        function updateTemaDisplay() {
            const select = document.getElementById('subtemaSelect');
            const selectedOption = select.options[select.selectedIndex];
            const tema = selectedOption.getAttribute('data-tema');
            document.getElementById('temaDisplay').value = tema;
        }

        document.getElementById('subtemaSelect').addEventListener('change', updateTemaDisplay);

        // Jalankan saat pertama kali halaman dimuat
        window.addEventListener('load', updateTemaDisplay);
    </script>
@endsection
