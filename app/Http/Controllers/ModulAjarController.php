<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModulAjar;
use App\Models\LingkupPerkembangan;
use App\Models\Subtema;
use App\Models\Tematk;

class ModulAjarController extends Controller
{
    public function index(Request $request)
{
    $lingkups = LingkupPerkembangan::all();
    $filterLingkup = $request->get('lingkup_id');
    
    // Ambil filter kelas, default ke 'A'
    $filterKelas = $request->get('kelas', 'A');

    // Ambil filter subtema, jika tidak ada, ambil subtema_id terbaru dari modul ajar
    $filterSubtema = $request->get('subtema_id');
    if (!$filterSubtema) {
        $latestSubtema = ModulAjar::latest()->first()?->subtema_id;
        $filterSubtema = $latestSubtema;
        $request->merge(['subtema_id' => $filterSubtema]); // agar tetap tampil di dropdown
    }

    // Query modul ajar
    $moduls = ModulAjar::with(['lingkup', 'subtema.tematk'])
        ->when($filterLingkup, fn($q) => $q->where('lingkup_id', $filterLingkup))
        ->whereHas('subtema.tematk', fn($q) => $q->where('kelas', $filterKelas))
        ->when($filterSubtema, fn($q) => $q->where('subtema_id', $filterSubtema))
        ->paginate(10)
        ->appends($request->all());

    // Ambil semua subtema untuk dropdown filter (jika mau ditampilkan nanti)
    $allSubtemas = Subtema::with('tematk')->get();

    $selectedTema = null;

    if ($filterSubtema) {
        $selectedSubtema = Subtema::with('tematk')->find($filterSubtema);
        $selectedTema = $selectedSubtema?->tematk?->tema;

    }

    return view('kepala_sekolah.penilaian.modul.index', compact(
        'moduls', 'lingkups', 'filterLingkup', 'filterKelas', 'filterSubtema', 'allSubtemas', 'selectedTema'
    ));
}

 

    public function createStep1()
    {
        $lingkups = LingkupPerkembangan::all();
        $temas = Tematk::all();
        $subtemas = Subtema::all();
        return view('kepala_sekolah.penilaian.modul.create_step1', compact('lingkups', 'subtemas', 'temas'));
    }

    public function createStep2(Request $request)
{
    $request->validate([
        'lingkup_id' => 'required|exists:lingkup_perkembangan,id',
        'subtema_id' => 'nullable|exists:subtema,id',
        'ceklis_anekdot' => 'required|in:Ceklis,Anekdot',
        'jumlah' => 'required|integer|min:1|max:20',
    ]);

    return view('kepala_sekolah.penilaian.modul.create_step2', [
        'lingkup_id' => $request->lingkup_id,
        'subtema_id' => $request->subtema_id,
        'ceklis_anekdot' => $request->ceklis_anekdot,
        'jumlah' => $request->jumlah,
    ]);
}


public function store(Request $request)
{
    $validated = $request->validate([
        'lingkup_id' => 'required|exists:lingkup_perkembangan,id',
        'subtema_id' => 'nullable|exists:subtema,id',
        'ceklis_anekdot' => 'required|in:Ceklis,Anekdot',
        'moduls' => 'required|array',
        'moduls.*.rencana_pembelajaran' => 'required|string',
    ]);

    foreach ($validated['moduls'] as $modul) {
        ModulAjar::create([
            'lingkup_id' => $validated['lingkup_id'],
            'subtema_id' => $validated['subtema_id'],
            'ceklis_anekdot' => $validated['ceklis_anekdot'],
            'rencana_pembelajaran' => $modul['rencana_pembelajaran'],
        ]);
    }

    return redirect()->route('modulAjar.index')->with('success', 'Modul ajar berhasil ditambahkan.');
}
 
public function edit($id)
{
    $modul = ModulAjar::findOrFail($id);
    $subtemas = Subtema::all();
    $temas = Tematk::all();
    $lingkups = LingkupPerkembangan::all();

    return view('kepala_sekolah.penilaian.modul.edit', compact('modul', 'subtemas', 'lingkups', 'temas'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'lingkup_id' => 'required',
        'rencana_pembelajaran' => 'required',
        'ceklis_anekdot' => 'required|in:Ceklis,Anekdot',
    ]);

    $modul = ModulAjar::findOrFail($id);
    $modul->update([
        'lingkup_id' => $request->lingkup_id,
        'subtema_id' => $request->subtema_id,
        'rencana_pembelajaran' => $request->rencana_pembelajaran,
        'ceklis_anekdot' => $request->ceklis_anekdot,
    ]);

    return redirect()->route('modulAjar.index')->with('success', 'Modul Ajar berhasil diperbarui');
}

public function destroy($id)
{
    $modul = ModulAjar::findOrFail($id);
    $modul->delete();

    return redirect()->route('modulAjar.index')->with('success', 'Modul Ajar berhasil dihapus');
}

}
