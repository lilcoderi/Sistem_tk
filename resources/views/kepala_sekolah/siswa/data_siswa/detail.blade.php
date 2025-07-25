@extends('kepala_sekolah.layouts.app')

@section('title')
    Detail Data Siswa
@endsection

<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@section('content')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Siswa/Siswi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('data-siswa.index') }}">Data Siswa TK</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detail Siswa
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <div class="container">
        <h3>Detail Siswa</h3>

        <!-- Tombol -->

        <!-- FLASH MESSAGE -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <!-- Tombol Jalankan Sistem Pakar -->
        <a href="{{ route('prediksi.awal.jalankan', $siswa->id) }}" class="btn btn-success btn-sm mb-3">
            Jalankan Sistem Pakar
        </a>

        <div class="d-flex gap-2 flex-wrap mb-4">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalOrangTua">Detail Orang
                Tua</button>
            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalKondisiAnak">Detail Keadaan
                Anak</button>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalJasmani">Detail Keadaan
                Jasmani</button>
            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalDokumen">Detail
                Dokumen</button>
            <!-- Tombol Detail Prediksi -->
            @if ($siswa->hasil_prediksi_awal)
                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalPrediksi">
                    Detail Prediksi
                </button>
            @endif
        </div>

        <!-- Modal Detail Prediksi -->
        @if ($siswa->hasil_prediksi_awal)
            <div class="modal fade" id="modalPrediksi" tabindex="-1" aria-labelledby="modalPrediksiLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="modalPrediksiLabel">Detail Prediksi Awal -
                                {{ $siswa->nama_lengkap }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong>Prediksi Awal:</strong>
                                <div class="alert alert-info mt-2">
                                    {{ $siswa->hasil_prediksi_awal->prediksi_awal }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Rekomendasi Awal:</strong>
                                <div class="alert alert-success mt-2">
                                    {{ $siswa->hasil_prediksi_awal->rekomendasi_awal }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Catatan Sistem Pakar:</strong>
                                <ul class="list-group mt-2">
                                    @foreach (explode("\n- ", $siswa->hasil_prediksi_awal->catatan_sistem_pakar) as $catatan)
                                        @if (!empty(trim($catatan)))
                                            <li class="list-group-item">{{ $catatan }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <small class="text-muted">Terakhir diperbarui:
                                {{ $siswa->hasil_prediksi_awal->updated_at->format('d M Y, H:i') }}</small>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <!-- Modal Orang Tua -->
        <div class="modal fade" id="modalOrangTua" tabindex="-1" aria-labelledby="modalOrangTuaLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Orang Tua</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th colspan="2">Ayah</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>Nama Ayah</th>
                                <td>{{ $siswa->orangtua->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>NIK Ayah</th>
                                <td>{{ $siswa->orangtua->nik_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir Ayah</th>
                                <td>{{ $siswa->orangtua->tempat_lahir_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir Ayah</th>
                                <td>{{ $siswa->orangtua->tanggal_lahir_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Agama Ayah</th>
                                <td>{{ $siswa->orangtua->agama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kewarganegaraan Ayah</th>
                                <td>{{ $siswa->orangtua->kewarganegaraan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan Ayah</th>
                                <td>{{ $siswa->orangtua->pendidikan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Ayah</th>
                                <td>{{ $siswa->orangtua->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Rumah Ayah</th>
                                <td>{{ $siswa->orangtua->alamat_rumah_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No Telepon Ayah</th>
                                <td>{{ $siswa->orangtua->no_telepon_ayah ?? '-' }}</td>
                            </tr>

                            <thead>
                                <tr class="table-info">
                                    <th colspan="2">Ibu</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>Nama Ibu</th>
                                <td>{{ $siswa->orangtua->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>NIK Ibu</th>
                                <td>{{ $siswa->orangtua->nik_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir Ibu</th>
                                <td>{{ $siswa->orangtua->tempat_lahir_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir Ibu</th>
                                <td>{{ $siswa->orangtua->tanggal_lahir_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Agama Ibu</th>
                                <td>{{ $siswa->orangtua->agama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kewarganegaraan Ibu</th>
                                <td>{{ $siswa->orangtua->kewarganegaraan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan Ibu</th>
                                <td>{{ $siswa->orangtua->pendidikan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan Ibu</th>
                                <td>{{ $siswa->orangtua->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Rumah Ibu</th>
                                <td>{{ $siswa->orangtua->alamat_rumah_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No Telepon Ibu</th>
                                <td>{{ $siswa->orangtua->no_telepon_ibu ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Kondisi Anak -->
        <div class="modal fade" id="modalKondisiAnak" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Kondisi Anak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Rumah Waktu Masuk TK</th>
                                <td>{{ $siswa->kondisiAnak->rumah_waktu_masuk_tk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Penghuni Rumah</th>
                                <td>{{ $siswa->kondisiAnak->jumlah_penguni_rumah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pergaulan dengan Teman</th>
                                <td>{{ $siswa->kondisiAnak->pergaulan_dengan_teman ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nafsu Makan</th>
                                <td>{{ $siswa->kondisiAnak->nafszu_makan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pagi Hari</th>
                                <td>{{ $siswa->kondisiAnak->pagi_hari ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Siang Hari</th>
                                <td>{{ $siswa->kondisiAnak->siang_hari ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Malam Hari</th>
                                <td>{{ $siswa->kondisiAnak->malam_hari ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hubungan dengan Ayah</th>
                                <td>{{ $siswa->kondisiAnak->hubungan_dengan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hubungan dengan Ibu</th>
                                <td>{{ $siswa->kondisiAnak->hubungan_dengan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kebersihan Buang Air</th>
                                <td>{{ $siswa->kondisiAnak->kebersihan_buang_air ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tidur Siang Mulai</th>
                                <td>{{ $siswa->kondisiAnak->tidur_siang_mulai ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tidur Siang Selesai</th>
                                <td>{{ $siswa->kondisiAnak->tidur_siang_selesai ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tidur Malam Mulai</th>
                                <td>{{ $siswa->kondisiAnak->tidur_malam_mulai ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tidur Malam Selesai</th>
                                <td>{{ $siswa->kondisiAnak->tidur_malam_selesai ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hal Lain Saat Tidur</th>
                                <td>{{ $siswa->kondisiAnak->hal_lain_waktu_tidur ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Sikap Anak di Rumah</th>
                                <td>{{ $siswa->kondisiAnak->sikap_anak_dirumah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Penyakit Pernah Diderita</th>
                                <td>{{ $siswa->kondisiAnak->penyakit_pernah_diderita ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Imunisasi Pernah Diterima</th>
                                <td>{{ $siswa->kondisiAnak->imunisasi_pernah_diterima ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Keadaan Jasmani -->
        <div class="modal fade" id="modalJasmani" tabindex="-1" aria-labelledby="modalJasmaniLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Keadaan Jasmani</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Keadaan Waktu Kandungan</th>
                                <td>{{ $siswa->keadaanJasmani->keadaan_waktu_kandungan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Keadaan Waktu Dilahirkan</th>
                                <td>{{ $siswa->keadaanJasmani->keadaan_waktu_dilahirkan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Anak Disusui ASI</th>
                                <td>{{ $siswa->keadaanJasmani->anak_disusui_asi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Makanan Tambahan</th>
                                <td>{{ $siswa->keadaanJasmani->makanan_tambahan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Kelainan / Cacat yang Diderita</th>
                                <td>{{ $siswa->keadaanJasmani->kelainan_cacat_yang_diderita ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Cara Anak Minum Susu</th>
                                <td>{{ $siswa->keadaanJasmani->cara_anak_minum_susu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Apakah Masih Pakai Diaper</th>
                                <td>{{ $siswa->keadaanJasmani->apakah_masih_pakai_diaper ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal Dokumen -->
        <div class="modal fade" id="modalDokumen" tabindex="-1" aria-labelledby="modalDokumenLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Dokumen Persyaratan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Akta Kelahiran -->
                            <div class="col-md-4 mb-4">
                                <h6>Akta Kelahiran</h6>
                                @if (!empty($siswa->dokumenPersyaratan->akta_kelahiran))
                                    <img src="{{ asset('storage/' . $siswa->dokumenPersyaratan->akta_kelahiran) }}"
                                        alt="Akta Kelahiran" class="img-fluid rounded border">
                                @else
                                    <p class="text-muted">Tidak ada dokumen.</p>
                                @endif
                            </div>


                            <!-- Kartu Keluarga -->
                            <div class="col-md-4 mb-4">
                                <h6>Kartu Keluarga</h6>
                                @if (!empty($siswa->dokumenPersyaratan->kartu_keluarga))
                                    <img src="{{ asset('storage/' . $siswa->dokumenPersyaratan->kartu_keluarga) }}"
                                        alt="Kartu Keluarga" class="img-fluid rounded border">
                                @else
                                    <p class="text-muted">Tidak ada dokumen.</p>
                                @endif
                            </div>

                            <!-- KTP Orang Tua -->
                            <div class="col-md-4 mb-4">
                                <h6>KTP Orang Tua</h6>
                                @if (!empty($siswa->dokumenPersyaratan->ktp_orang_tua))
                                    <img src="{{ asset('storage/' . $siswa->dokumenPersyaratan->ktp_orang_tua) }}"
                                        alt="KTP Orang Tua" class="img-fluid rounded border">
                                @else
                                    <p class="text-muted">Tidak ada dokumen.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <table class="table table-bordered">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $siswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Nama Panggilan</th>
                <td>{{ $siswa->nama_panggilan }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $siswa->nik }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{ $siswa->tempat_lahir }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $siswa->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Alamat Rumah</th>
                <td>{{ $siswa->alamat_rumah }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>{{ $siswa->agama }}</td>
            </tr>
            <tr>
                <th>Kelompok</th>
                <td>{{ $siswa->kelompok }}</td>
            </tr>
            <tr>
                <th>Jumlah Saudara</th>
                <td>{{ $siswa->jumlah_saudara }}</td>
            </tr>
            <tr>
                <th>Anak Ke</th>
                <td>{{ $siswa->anak_ke }}</td>
            </tr>
            <tr>
                <th>Bahasa Sehari-hari</th>
                <td>{{ $siswa->bahasa_sehari_hari }}</td>
            </tr>
            <tr>
                <th>Golongan Darah</th>
                <td>{{ $siswa->golongan_darah }}</td>
            </tr>
            <tr>
                <th>Ciri Khusus</th>
                <td>{{ $siswa->ciri_khusus }}</td>
            </tr>
        </table>

        <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    {{-- <script>
        function jalankanSistemPakar(id, nama) {
            Swal.fire({
                title: 'Yakin?',
                text: `Ingin menjalankan sistem pakar untuk ${nama}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Jalankan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('http://13.239.122.173:5000/prediksi', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id_siswa: id
                            })
                        })
                        .then(async (response) => {
                            if (!response.ok) {
                                const text = await response.text();
                                throw new Error(`Gagal dengan status ${response.status}: ${text}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                Swal.fire('Gagal', data.error, 'error');
                            } else {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    html: `
                                <b>${data.nama_siswa}</b><br><br>
                                Prediksi: <b>${data.prediksi_awal}</b><br>
                                Rekomendasi: ${data.rekomendasi_awal}<br><br>
                                Catatan:<br>
                                <ul>${data.catatan_sistem_pakar.map(item => `<li>${item}</li>`).join('')}</ul>
                            `,
                                    icon: 'success'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'Gagal menghubungi sistem pakar.', 'error');
                            console.error('Error sistem pakar:', error);
                        });
                }
            });
        }
    </script> --}}



@endsection
