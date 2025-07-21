<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IdentitasAnak;
use App\Models\HasilAsesmenCeklis;
use App\Models\TumbuhKembang;
use App\Models\Rapor;
use App\Models\ModulAjar;
use App\Models\NotifikasiOrangTua;
use App\Services\OpenAIService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class RaporController extends Controller
{
    public function index()
    {
        $siswa = IdentitasAnak::with('pendaftaran')->latest()->paginate(10);
        return view('kepala_sekolah.penilaian.rapor.index', compact('siswa'));
    }

    public function generateOpenAI($id_siswa, OpenAIService $openai)
    {
        $siswa = IdentitasAnak::findOrFail($id_siswa);
        $asesmen = HasilAsesmenCeklis::where('id_siswa', $id_siswa)->latest()->first();
        $tumbuh = TumbuhKembang::where('id_siswa', $id_siswa)->latest('tanggal_input')->first();

        if (!$asesmen || !$tumbuh) {
            return back()->with('error', 'Data asesmen atau tumbuh kembang belum lengkap.');
        }

        $hasil = is_string($asesmen->hasil) ? json_decode($asesmen->hasil, true) : (is_array($asesmen->hasil) ? $asesmen->hasil : []);

        $modul = ModulAjar::with('subtema.tematk')->latest()->first();
        $subtema = $modul?->subtema;
        $tema = $subtema?->tematk;

        $namaSiswa = $siswa->nama_lengkap;
        $temaText = $tema?->tema ?? '-';
        $subtemaText = $subtema?->sub_tema ?? '-';
        $modulText = $modul?->rencana_pembelajaran ?? '-';

        $prompt = "Nama anak: {$namaSiswa}\n"
            . "Tema pembelajaran: {$temaText}\n"
            . "Subtema: {$subtemaText}\n"
            . "Modul Ajar / Rencana Pembelajaran: {$modulText}\n\n"
            . "Data Fisik Anak:\n"
            . "- Berat Badan: {$tumbuh->berat_badan} kg\n"
            . "- Tinggi Badan: {$tumbuh->tinggi_badan} cm\n"
            . "- Lingkar Kepala: {$tumbuh->lingkar_kepala} cm\n"
            . "- Hasil Asesmen: " . json_encode($hasil, JSON_UNESCAPED_UNICODE) . "\n\n"
            . "Buatlah laporan naratif rapor perkembangan anak TK seperti yang ditulis oleh guru TK yang penuh perhatian tanpa menggunakan kata saya dan buatkan lebih panjang serta jika terdapat kekurangan, berikan penjelasan kekurangannya dengan sopan.\n"
            . "Tulis dalam gaya bahasa hangat dan positif, gunakan format berikut:\n\n"
            . "PERTUMBUHAN:\n"
            . "Deskripsikan dan Jelaskan perkembangan berat badan, tinggi badan, dan lingkar kepala anak secara positif. Sertakan apresiasi yang telah dicapai untuk perkembangan selanjutnya.\n\n"
            . "NILAI AGAMA:\n"
            . "Jelaskan partisipasi anak dalam kegiatan ibadah (seperti doa dan praktik sholat), sikap terhadap sesama, serta kepedulian terhadap makhluk hidup (seperti binatang dan tumbuhan).\n\n"
            . "JATI DIRI:\n"
            . "Ceritakan perkembangan kemandirian, emosi, tanggung jawab, dan hubungan sosial anak.Tambahkan saran kegiatan di rumah untuk melatih pengendalian emosi, kemandirian, emosi, tanggung jawab, dan hubungan sosial\n\n"
            . "LITERASI:\n"
            . "Jabarkan kemampuan anak dalam mendengar, berbicara, mengenal huruf dan angka, berpikir logis, hingga kemampuan bercerita. Sertakan saran kegiatan di rumah seperti eksperimen sederhana.\n\n"
            . "PROFIL PANCASILA:\n"
            . "Ceritakan kegiatan projek (tema: {$temaText}), partisipasi anak, dan pengalaman belajar.Tambahkan kesan anak terhadap kegiatan ini.\n\n"
            . "SARAN, REKOMENDASI, DAN HARAPAN:\n"
            . "Berikan saran yang membangun untuk orang tua dan anak dalam mendukung tumbuh kembangnya serta berikan harapan dan rekomendasi untuk orang tua dan anak kedepannya.\n\n"
            . "Gunakan kata-kata positif, menghargai potensi anak, dan buat narasi yang membangun rasa percaya diri anak.";

        $deskripsi = $openai->generateDeskripsi($prompt);
        Log::info('RESPON GPT:', ['text' => $deskripsi]);

        if (!$deskripsi) {
            return back()->with('error', 'Gagal mengambil deskripsi dari OpenAI. Silakan coba lagi.');
        }

        $parsed = $this->parseDeskripsi($deskripsi);

        $pertumbuhan       = $parsed['PERTUMBUHAN'] ?? '';
        $nilai_agama       = $parsed['NILAI AGAMA'] ?? '';
        $jati_diri         = $parsed['JATI DIRI'] ?? '';
        $literasi          = $parsed['LITERASI'] ?? '';
        $profil_pancasila  = $parsed['PROFIL PANCASILA'] ?? '';
        $saran             = $parsed['SARAN, REKOMENDASI, DAN HARAPAN'] ?? '';


        Log::info('HASIL PARSING:', [
            'pertumbuhan' => $pertumbuhan,
            'nilai_agama' => $nilai_agama,
            'jati_diri' => $jati_diri,
            'literasi' => $literasi,
            'profil_pancasila' => $profil_pancasila,
            'saran' => $saran,
        ]);

        if (!$pertumbuhan || !$nilai_agama || !$jati_diri || !$literasi || !$profil_pancasila || !$saran) {
            Log::warning('Deskripsi OpenAI tidak lengkap:', [
                'full' => $deskripsi,
                'parsed' => compact('pertumbuhan', 'nilai_agama', 'jati_diri', 'literasi', 'profil_pancasila', 'saran'),
            ]);
            return back()->with('error', 'Format deskripsi tidak lengkap. Periksa respons OpenAI.');
        }

        Rapor::updateOrCreate(
            ['id_siswa' => $id_siswa],
            [
                'pertumbuhan' => $pertumbuhan,
                'nilai_agama' => $nilai_agama,
                'jati_diri' => $jati_diri,
                'literasi' => $literasi,
                'profil_pancasila' => $profil_pancasila,
                'saran' => $saran,
            ]
        );

        // Cek apakah siswa memiliki pendaftaran yang terkait dengan user orang tua
        $pendaftaran = $siswa->pendaftaran()->whereNotNull('user_id')->first();

        if ($pendaftaran) {
            NotifikasiOrangTua::create([
            'user_id' => $pendaftaran->user_id, // user_id orang tua
            'tipe' => 'rapor',
            'referensi_id' => $siswa->id,
            'pesan' => 'Rapor baru telah diterbitkan untuk anak Anda: ' . $siswa->nama_lengkap,
        ]);
        }


        return back()->with('success', 'Rapor berhasil dihasilkan dan disimpan.');
    }

    public function show($id_siswa)
    {
        $siswa = IdentitasAnak::findOrFail($id_siswa);
        $rapor = Rapor::where('id_siswa', $id_siswa)->firstOrFail();
        $tumbuh = TumbuhKembang::where('id_siswa', $id_siswa)->latest('tanggal_input')->first();

        return view('kepala_sekolah.penilaian.rapor.detail', compact('siswa', 'rapor', 'tumbuh'));
    }

    public function generateRapor($id_siswa)
{
    $siswa = IdentitasAnak::findOrFail($id_siswa);
    $rapor = Rapor::where('id_siswa', $id_siswa)->firstOrFail();
    $tumbuh = TumbuhKembang::where('id_siswa', $id_siswa)->latest('tanggal_input')->first();

    $pdf = Pdf::loadView('kepala_sekolah.penilaian.rapor.pdf', compact('siswa', 'rapor', 'tumbuh'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('Rapor_' . $siswa->nama_lengkap . '.pdf');
}
    /**
     * Parse seluruh isi deskripsi menjadi array berdasarkan label
     */

private function parseDeskripsi($text)
{
    // Label-label yang akan dipisahkan
    $labels = [
        'PERTUMBUHAN',
        'NILAI AGAMA',
        'JATI DIRI',
        'LITERASI',
        'PROFIL PANCASILA',
        'SARAN, REKOMENDASI, DAN HARAPAN'
    ];

    // Inisialisasi hasil parsing kosong
    $result = array_fill_keys($labels, '');

    // Normalisasi teks
    $normalizedText = str_replace(["\r\n", "\r"], "\n", $text);

    // Buat regex pattern dari label-label (biar fleksibel)
    $pattern = '/^(?:\*\*)?(' . implode('|', array_map('preg_quote', $labels)) . ')(?::|\-\-)?(?:\*\*)?\s*$/mi';

    // Cari posisi label di dalam teks
    preg_match_all($pattern, $normalizedText, $matches, PREG_OFFSET_CAPTURE);

    // Kalau tidak ditemukan label sama sekali
    if (empty($matches[1])) {
        return $result;
    }

    // Tambahkan posisi akhir teks sebagai penutup
    $matches[1][] = ['END', strlen($normalizedText)];

    // Loop antar pasangan label untuk ambil konten antar label
    for ($i = 0; $i < count($matches[1]) - 1; $i++) {
        $label = strtoupper(trim($matches[1][$i][0]));
        $start = $matches[0][$i][1] + strlen($matches[0][$i][0]);
        $end = $matches[1][$i + 1][1];

        $content = trim(substr($normalizedText, $start, $end - $start));
        // Hilangkan tanda markdown sisa seperti "**" di akhir atau awal
        $content = trim($content, "* \t\n\r\0\x0B");


        if (array_key_exists($label, $result)) {
            $result[$label] = $content;
        }
    }

    return $result;
}

// Tambahkan method baru di RaporController
public function raporOrangTua()
{
    $user = Auth::user();

    // Ambil semua siswa yang terkait dengan pendaftaran user ini
    $siswaList = IdentitasAnak::whereHas('pendaftaran', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->with(['rapor', 'tumbuh' => function($q) {
        $q->latest('tanggal_input')->limit(1);
    }])->get();

    return view('orang_tua.siswa.rapor.index', compact('siswaList'));
}



}
