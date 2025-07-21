<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Asesmen;
use Illuminate\Http\Request;
use App\Models\Subtema;
use App\Models\Guru;
use App\Models\HasilAsesmenCeklis;
use App\Models\IdentitasAnak;
use App\Models\DetailAsesmen;

class HasilAsesmenController extends Controller
{
    
public function index(Request $request)
{
    $query = Asesmen::query()
        ->with(['subtema', 'guru', 'siswa']);

    // Ambil tanggal_proses terbaru untuk masing-masing asesmen
    $tanggalProsesMap = HasilAsesmenCeklis::select('id_asesmen', DB::raw('MAX(tanggal_proses) as tanggal_proses'))
        ->groupBy('id_asesmen')
        ->pluck('tanggal_proses', 'id_asesmen');


    // Ambil daftar subtema untuk dropdown
    $subtemaOptions = \App\Models\Subtema::select('id', 'sub_tema')->orderBy('sub_tema')->get();

    // ✅ Ambil subtema_id terbaru jika belum dipilih
    $defaultSubtemaId = null;
    if (!$request->filled('subtema_id')) {
        $defaultSubtemaId = Asesmen::latest('updated_at')->first()?->subtema?->id;
        if ($defaultSubtemaId) {
            $request->merge(['subtema_id' => $defaultSubtemaId]); // isi otomatis ke request
        }
    }

    // Filter: Pencarian nama siswa
    if ($request->filled('search')) {
        $query->whereHas('siswa', function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
        });
    }
 
    // Filter: Tahun Ajar
    if ($request->filled('tahun_ajar')) {
        $query->where('tahun_ajar', $request->tahun_ajar);
    }

    // ✅ Filter: Subtema (baik dari input manual atau otomatis)
    if ($request->filled('subtema_id')) {
        $query->whereHas('subtema', function ($q) use ($request) {
            $q->where('id', $request->subtema_id);
        });
    }

    // Sorting nama siswa
    if ($request->sort === 'asc' || $request->sort === 'desc') {
        $query->orderByRaw('(SELECT nama_lengkap FROM identitas_anak WHERE identitas_anak.id = asesmen.id_siswa) ' . $request->sort);
    }

    // Data filter lainnya
    $tahunAjarOptions = Asesmen::select('tahun_ajar')->distinct()->pluck('tahun_ajar')->sort();

    // Ambil hasil akhir dengan paginasi
    $asesmen = $query->paginate(10)->withQueryString();

    return view('kepala_sekolah.penilaian.hasil_asesmen.index', compact(
        'asesmen', 'tahunAjarOptions', 'subtemaOptions', 'tanggalProsesMap'
    ));
}



public function show($id_asesmen)
{
    // Ambil data asesmen dan relasi siswa
    $asesmen = Asesmen::with(['siswa', 'subtema'])->findOrFail($id_asesmen);

    // Ambil data hasil asesmen berdasarkan ID asesmen
    $hasil = \DB::table('hasil_asesmen_ceklis')
        ->where('id_asesmen', $id_asesmen)
        ->orderByDesc('tanggal_proses')
        ->first();

    // Jika tidak ada hasilnya
    if (!$hasil) {
        return back()->with('error', 'Hasil sistem pakar belum tersedia untuk asesmen ini.');
    }

    // Format agar sesuai seperti struktur dari Flask
    $formatted = [
        'id_siswa' => $hasil->id_siswa,
        'nama_siswa' => $asesmen->siswa->nama_lengkap ?? '-',
        'tanggal_proses' => $hasil->tanggal_proses,
        'hasil_per_lingkup' => json_decode($hasil->hasil, true),
        'rekomendasi' => explode("\n", $hasil->rekomendasi),
        'catatan' => explode("\n", $hasil->catatan),
        'subtema_terbaru' => $asesmen->subtema->sub_tema ?? '-',
    ];

    return view('kepala_sekolah.penilaian.hasil_asesmen.detail', [
        'hasil' => $formatted
    ]);
}



}
 