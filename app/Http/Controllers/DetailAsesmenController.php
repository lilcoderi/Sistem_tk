<?php

namespace App\Http\Controllers;

use App\Models\DetailAsesmen;
use App\Models\Asesmen;
use App\Models\ModulAjar;
use Illuminate\Http\Request;

class DetailAsesmenController extends Controller
{
public function index(Request $request, $id_siswa)
{
    $asesmen = Asesmen::with('siswa')
        ->where('id_siswa', $id_siswa)
        ->orderByDesc('created_at')
        ->firstOrFail();

    $modulsBySubtema = ModulAjar::with('lingkup')
        ->where('subtema_id', $asesmen->id_subtema)
        ->get();

    $lingkupOptions = $modulsBySubtema->pluck('lingkup')->filter()->unique('id')->values();

    $selectedLingkup = $request->get('lingkup_id');

    $filteredModuls = $selectedLingkup
        ? $modulsBySubtema->where('lingkup_id', $selectedLingkup)
        : $modulsBySubtema;

    $data = DetailAsesmen::with(['asesmen', 'modulAjar.lingkup'])
        ->where('id_asesmen', $asesmen->id_asesmen)
        ->whereIn('modulajar_id', $filteredModuls->pluck('id'))
        ->get();

    return view('kepala_sekolah.penilaian.asesmen.penilaianindex', compact(
        'data',
        'asesmen',
        'lingkupOptions',
        'selectedLingkup',
    ));
}


 
public function create(Request $request, $id_siswa)
{
    $asesmen = Asesmen::where('id_siswa', $id_siswa)
        ->orderByDesc('created_at')
        ->firstOrFail();

    $modulsBySubtema = ModulAjar::with('lingkup')
        ->where('subtema_id', $asesmen->id_subtema)
        ->get();

    $lingkupOptions = $modulsBySubtema->pluck('lingkup')->filter()->unique('id')->values();

    $selectedLingkup = $request->get('lingkup_id');

    $filteredModuls = $selectedLingkup
        ? $modulsBySubtema->filter(fn($item) => $item->lingkup_id == $selectedLingkup)
        : $modulsBySubtema;

    $nilaiLama = DetailAsesmen::where('id_asesmen', $asesmen->id_asesmen)
        ->get()
        ->keyBy('modulajar_id');

    return view('kepala_sekolah.penilaian.asesmen.penilaiancreate', compact(
        'asesmen',
        'filteredModuls',
        'lingkupOptions',
        'selectedLingkup',
        'nilaiLama'
    ));
}


    public function store(Request $request)
    {
        $request->validate([
            'id_asesmen' => 'required|exists:asesmen,id_asesmen',
            'penilaian' => 'nullable|array',
            'penilaian.*.modulajar_id' => 'nullable|exists:modul_ajar,id',
            'penilaian.*.skala_nilai' => 'nullable|in:BB,MB,BSH,BSB',
        ]);

        foreach ($request->penilaian as $nilai) {
    if (isset($nilai['skala_nilai']) && !empty($nilai['skala_nilai'])) {
        DetailAsesmen::updateOrCreate(
            [
                'id_asesmen' => $request->id_asesmen,
                'modulajar_id' => $nilai['modulajar_id'],
            ],
            [
                'skala_nilai' => $nilai['skala_nilai'],
            ]
        );
    }
}

        $asesmen = Asesmen::findOrFail($request->id_asesmen);

        return redirect()->route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa])
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function edit($id_detail)
{
    $detail = DetailAsesmen::with(['asesmen.siswa', 'modulAjar'])->findOrFail($id_detail);
    $modul = ModulAjar::all(); // Atau bisa difilter jika perlu

    return view('kepala_sekolah.penilaian.asesmen.penilaianedit', compact('detail', 'modul'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'id_asesmen' => 'required|exists:asesmen,id_asesmen',
            'modulajar_id' => 'required|exists:modul_ajar,id',
            'skala_nilai' => 'required|in:BB,MB,BSH,BSB',
        ]);

        $detail = DetailAsesmen::findOrFail($id);
        $detail->update($request->only('id_asesmen', 'modulajar_id', 'skala_nilai'));

        $asesmen = Asesmen::findOrFail($detail->id_asesmen);

        return redirect()->route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $detail = DetailAsesmen::findOrFail($id);
        $id_asesmen = $detail->id_asesmen;
        $detail->delete();

        $asesmen = Asesmen::findOrFail($id_asesmen);

        return redirect()->route('detail-asesmen.index', ['id_siswa' => $asesmen->id_siswa])
            ->with('success', 'Data berhasil dihapus.');
    }

public function show($id_asesmen)
{
    $asesmen = Asesmen::with(['siswa', 'subtema.tematk'])->findOrFail($id_asesmen);

    $detailAsesmen = DetailAsesmen::with('modulAjar.lingkup')
        ->where('id_asesmen', $id_asesmen)
        ->get();

    return view('kepala_sekolah.penilaian.asesmen.detail', compact('asesmen', 'detailAsesmen'));
}



}
