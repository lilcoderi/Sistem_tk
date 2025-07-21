<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan Anak</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            padding: 25px;
            background-image: url("{{ public_path('icons/background.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #f0fdf4;
        }

        .kop-surat img {
            width: 100%;
            max-height: 140px;
            margin-bottom: 10px;
        }

        .kop-border {
            border-bottom: 3px solid #000;
            margin-bottom: 20px;
        }

        h4 {
            text-align: center;
            color: #1b5e20;
            font-weight: bold;
            margin-bottom: 12px;
        }

        h4 img {
            vertical-align: middle;
            margin-right: 6px;
            width: 30px; /* ✅ Ukuran ikon diperbesar */
            height: 30px;    /* ✅ Jaga rasio tinggi agar sejajar */
        }


        .section {
            border: 1px solid #66bb6a;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 35px;
            background-color: #ffffff;
        }

        .footer-ttd {
            text-align: center;
            margin-top: 60px;
        }

        .footer-ttd .label {
            font-weight: bold;
            margin-bottom: 60px;
        }

        .footer-ttd .line {
            display: block;
            width: 60%;
            margin: 0 auto;
            border-top: 1px dotted #444;
        }

        .komentar-ortu p {
            text-align: justify;
            margin-bottom: 5px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
        }

        p,
        ul {
            text-align: justify;
        }

        ul {
            padding-left: 20px;
            margin-bottom: 10px;
        }

        .identitas p {
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ public_path('images/KopSurat.png') }}" alt="Kop Surat">
    </div>
    <div class="kop-border"></div>

    <!-- Identitas -->
    <div class="identitas">
        <p><strong>Nama Anak Didik:</strong> {{ $siswa->nama_lengkap }}</p>
        <p><strong>Usia:</strong> {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} Tahun</p>
        <p><strong>Semester:</strong> 1 (Satu)</p>
    </div>

    <!-- Pertumbuhan -->
    <div class="section">
        <h4>
            <img src="{{ public_path('icons/pertumbuhan.png') }}" alt="Pertumbuhan">
            Pertumbuhan
        </h4>
        <ul>
            <li><strong>Berat Badan:</strong> {{ $tumbuh->berat_badan }} kg</li>
            <li><strong>Tinggi Badan:</strong> {{ $tumbuh->tinggi_badan }} cm</li>
            <li><strong>Lingkar Kepala:</strong> {{ $tumbuh->lingkar_kepala }} cm</li>
        </ul>
        <p>{{ $rapor->pertumbuhan }}</p>
    </div>

    <div class="section">
        <h4>
            <img src="{{ public_path('icons/agama.png') }}" alt="Agama">
            Nilai Agama dan Budi Pekerti
        </h4>
        <p>{{ $rapor->nilai_agama }}</p>
    </div>

    <div class="section">
        <h4>
            <img src="{{ public_path('icons/jati_diri.png') }}" alt="Jati Diri">
            Jati Diri
        </h4>
        <p>{{ $rapor->jati_diri }}</p>
    </div>

    <div class="section">
        <h4>
            <img src="{{ public_path('icons/literasi.png') }}" alt="Literasi">
            Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni
        </h4>
        <p>{{ $rapor->literasi }}</p>
    </div>

    <div class="section">
        <h4>
            <img src="{{ public_path('icons/profil.png') }}" alt="Profil">
            Proyek Penguatan Profil Pelajar Pancasila
        </h4>
        <p>{{ $rapor->profil_pancasila }}</p>
    </div>

    <div class="section">
        <h4>
            <img src="{{ public_path('icons/saran.png') }}" alt="Saran">
            Saran, Rekomendasi, dan Harapan
        </h4>
        <p>{{ $rapor->saran }}</p>
    </div>

    <div class="section komentar-ortu">
        <h4>
            <img src="{{ public_path('icons/komentar.png') }}" alt="Komentar">
            Komentar Orang Tua
        </h4>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="footer-ttd">
        <div class="label">Orang Tua/Wali</div>
        <span class="line"></span>
    </div>

    <p style="margin-top: 30px; font-style: italic;">Dokumen ini dicetak otomatis oleh sistem.</p>
</body>

</html>
