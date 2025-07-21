<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Asesmen;
use Illuminate\Http\Request;
use App\Models\Subtema;
use App\Models\Guru;
use App\Models\IdentitasAnak;

class AsesmenController extends Controller
{
public function index(Request $request)
{
    $query = Asesmen::query()->with(['subtema.tematk', 'guru', 'siswa']);

    // Pencarian nama siswa
    if ($request->filled('search')) {
        $query->whereHas('siswa', function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
        });
    }

    // Filter Tahun Ajar
    if ($request->filled('tahun_ajar')) {
        $query->where('tahun_ajar', $request->tahun_ajar);
    }

    // === Subtema terbaru otomatis ===
    $selectedSubtema = $request->get('subtema_id');

    if (!$selectedSubtema) {
        // Ambil subtema_id dari asesmen terbaru
        $latestSubtemaId = Asesmen::orderByDesc('created_at')->value('id_subtema');
        $selectedSubtema = $latestSubtemaId;
        $request->merge(['subtema_id' => $selectedSubtema]);
    }

    if ($selectedSubtema) {
        $query->where('id_subtema', $selectedSubtema);
    }

    // Filter kelas
    $kelas = $request->get('kelas', 'A');
    $request->merge(['kelas' => $kelas]);
    if ($kelas) {
        $query->whereHas('subtema.tematk', function ($q) use ($kelas) {
            $q->where('kelas', $kelas);
        });
    }

    // Urutkan nama siswa
    if ($request->sort === 'asc' || $request->sort === 'desc') {
        $query->join('identitas_anak', 'identitas_anak.id', '=', 'asesmen.id_siswa')
            ->orderBy('identitas_anak.nama_lengkap', $request->sort)
            ->select('asesmen.*');
    }

    // Ambil semua tahun ajar unik
    $tahunAjarOptions = Asesmen::select('tahun_ajar')->distinct()->pluck('tahun_ajar')->sort();

    // Ambil semua subtema unik yang pernah digunakan
    $subtemaOptions = Subtema::whereIn('id', Asesmen::select('id_subtema'))->with('tematk')->get();

    // Ambil hasil akhir paginated
    $asesmen = $query->paginate(10)->withQueryString();

    return view('kepala_sekolah.penilaian.asesmen.index', compact(
        'asesmen',
        'tahunAjarOptions',
        'subtemaOptions',
        'selectedSubtema'
    ));
}





    public function create()
    {
        $subtemas = Subtema::with('tematk')->get();
        $gurus = Guru::all();
        $siswas = IdentitasAnak::all();

        return view('kepala_sekolah.penilaian.asesmen.create', compact('subtemas', 'gurus', 'siswas')); 
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'id_subtema' => 'required',
            'id_guru' => 'required',
            'semester' => 'required|string',
            'tahun_ajar' => 'required|string',
            'tipe_penilaian' => 'required|in:anekdot,ceklis',
        ]);

        Asesmen::create($request->all());
        return redirect()->route('asesmen.index')->with('success', 'Data asesmen berhasil ditambahkan.');
    }

    public function show($id)
    {
        $asesmen = Asesmen::with(['siswa', 'subtema', 'guru'])->findOrFail($id);
        return view('kepala_sekolah.penilaian.asesmen.detail', compact('asesmen'));
    }

    public function edit($id)
    {
        $asesmen = Asesmen::findOrFail($id);
        $subtemas = Subtema::with('tematk')->get();
        $gurus = Guru::all();
        $siswas = IdentitasAnak::all();

        return view('kepala_sekolah.penilaian.asesmen.edit', compact('asesmen', 'subtemas', 'gurus', 'siswas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required',
            'id_subtema' => 'required',
            'id_guru' => 'required',
            'semester' => 'required|string',
            'tahun_ajar' => 'required|string',
            'tipe_penilaian' => 'required|in:anekdot,ceklis',
        ]);

        $asesmen = Asesmen::findOrFail($id);
        $asesmen->update($request->all());
        return redirect()->route('asesmen.index')->with('success', 'Data asesmen berhasil diupdate.');
    }

    public function destroy($id)
    {
        $asesmen = Asesmen::findOrFail($id);
        $asesmen->delete();
        return redirect()->route('asesmen.index')->with('success', 'Data asesmen berhasil dihapus.');
    }
}
