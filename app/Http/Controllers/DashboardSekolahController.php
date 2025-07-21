<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailAsesmen;
use App\Models\IdentitasAnak;
use App\Models\Tematk;
use App\Models\Subtema;
use App\Models\HasilAsesmenCeklis;
use Illuminate\Support\Facades\DB;
use App\Models\HasilPrediksiAwal; 
use App\Models\Ddtk;
use App\Models\LingkupPerkembangan;
use Carbon\Carbon;

class DashboardSekolahController extends Controller
{
    public function dashboard(Request $request)
{
    $semuaSiswa = IdentitasAnak::all();
    $id_siswa = $request->get('id_siswa', $semuaSiswa->first()?->id ?? 1);
    $semuaTema = Tematk::all();

    $ddtkList = Ddtk::with('siswa')
        ->where('id_siswa', $id_siswa)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('kepala_sekolah.dashboard', compact('semuaSiswa', 'id_siswa', 'semuaTema', 'ddtkList'));
}


    public function getAsesmenChartData($id_siswa)
{
    $skalaList = ['BB', 'MB', 'BSH', 'BSB'];

    $data = DetailAsesmen::with('asesmen')
        ->whereHas('asesmen', function ($query) use ($id_siswa) {
            $query->where('id_siswa', $id_siswa);
        })
        ->get();

    $result = array_fill_keys($skalaList, 0);

    foreach ($data as $item) {
        if (in_array($item->skala_nilai, $skalaList)) {
            $result[$item->skala_nilai]++;
        }
    }

    return response()->json($result);
}

public function angkatanDistribusi()
{
    $data = \App\Models\IdentitasAnak::select('id_pendaftaran')
        ->get()
        ->groupBy(function ($item) {
            // Ambil 4 digit tahun dari id_pendaftaran, misal: PDK2025-001 → 2025
            return substr($item->id_pendaftaran, 3, 4);
        })
        ->map(function ($group) {
            return count($group);
        });

    return response()->json($data);
}
public function chartPerkembangan($id)
{
    $skalaMap = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];

    $data = \App\Models\DetailAsesmen::with('asesmen')
        ->whereHas('asesmen', function ($query) use ($id) {
            $query->where('id_siswa', $id);
        })
        ->orderBy('id_detail') // atau urut berdasarkan asesmen.tanggal jika ada
        ->get()
        ->map(function ($item) use ($skalaMap) {
            return [
                'indikator' => $item->skala_nilai,
                'angka' => $skalaMap[$item->skala_nilai] ?? 0
            ];
        });

    $response = [
        'labels' => [],
        'data' => []
    ];

    foreach ($data as $i => $row) {
        $response['labels'][] = "Data ke-" . ($i + 1);
        $response['data'][] = $row['angka'];
    }

    return response()->json($response);
}


public function getHasilPrediksiAwal($id_siswa)
{
    $data = HasilPrediksiAwal::where('id_siswa', $id_siswa)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($data);
}



public function chartPolinomial($id_siswa)
{
    $data = \App\Models\HasilAsesmenCeklis::where('id_siswa', $id_siswa)
        ->orderBy('tanggal_proses')
        ->get();

    $labels = [];
    $BB = [];
    $MB = [];
    $BSH = [];
    $BSB = [];
    $details = [];

    foreach ($data as $item) {
        $labels[] = $item->tanggal_proses;

        $hasil = is_array($item->hasil) ? $item->hasil : json_decode($item->hasil, true);

        // Hitung jumlah kategori
        $jumlah = ['BB' => 0, 'MB' => 0, 'BSH' => 0, 'BSB' => 0];
        foreach ($hasil as $aspek => $nilai) {
            if (isset($jumlah[$nilai])) {
                $jumlah[$nilai]++;
            }
        }

        $BB[] = $jumlah['BB'];
        $MB[] = $jumlah['MB'];
        $BSH[] = $jumlah['BSH'];
        $BSB[] = $jumlah['BSB'];

        $details[] = [
            'tanggal' => $item->tanggal_proses,
            'rekomendasi' => $item->rekomendasi,
            'catatan' => $item->catatan,
        ];
    }

    return response()->json([
        'labels' => $labels,
        'datasets' => [
            'BB' => $BB,
            'MB' => $MB,
            'BSH' => $BSH,
            'BSB' => $BSB,
        ],
        'details' => $details,
    ]);
}




public function tampilanddtk(Request $request)
{
    $semuaSiswa = IdentitasAnak::all();
    $id_siswa = $request->get('id_siswa', IdentitasAnak::first()?->id);

    $ddtkList = Ddtk::with('siswa')
        ->where('id_siswa', $id_siswa)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('kepala_sekolah.dashboard', compact('semuaSiswa', 'id_siswa', 'ddtkList'));
}


public function dataStatistikSekolah()
{
    // Ambil semua subtema dengan relasi tema
    $subtemas = \App\Models\Subtema::with('tematk')->get();

    // Kelompokkan berdasarkan nama tema (jika tidak ada relasi, fallback ke 'Tanpa Tema')
    $grouped = $subtemas->groupBy(function ($item) {
        return optional($item->tematk)->tema ?? 'Tanpa Tema';
    });

    // Format untuk frontend
    $temas = [];
    foreach ($grouped as $tema => $subtemaList) {
        $temas[] = [
            'tema' => $tema,
            'subtemas' => $subtemaList->pluck('sub_tema')->toArray()
        ];
    }

    // Ambil nama lingkup perkembangan
    $lingkupPerkembangan = LingkupPerkembangan::pluck('nama_lingkup')->toArray();

    return response()->json([
        'temas' => $temas,
        'lingkup_perkembangan' => $lingkupPerkembangan
    ]);
}


}



