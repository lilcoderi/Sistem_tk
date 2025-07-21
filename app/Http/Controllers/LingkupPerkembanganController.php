<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LingkupPerkembangan;

class LingkupPerkembanganController extends Controller
{
    public function index(Request $request)
{
    $query = LingkupPerkembangan::query();

    // Sort by nama_lingkup ascending/descending
    if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
        $query->orderBy('nama_lingkup', $request->sort);
    }

    $data = $query->paginate(6)->appends($request->query()); // agar pagination tetap membawa query string
    return view('kepala_sekolah.penilaian.lingkup.index', compact('data'));
}



    public function create()
    {
        return view('kepala_sekolah.penilaian.lingkup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lingkup' => 'required|string|max:255',
   
            'tujuan_pembelajaran' => 'nullable|string',
        'deskripsi' => 'required|string',
        ]);

        LingkupPerkembangan::create($request->all());

        return redirect()->route('lingkup.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
{
    $lingkup = LingkupPerkembangan::findOrFail($id);
    return view('kepala_sekolah.penilaian.lingkup.detail', compact('lingkup'));
}


    public function edit($id)
    {
        $lingkup = LingkupPerkembangan::findOrFail($id);
        return view('kepala_sekolah.penilaian.lingkup.edit', compact('lingkup'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lingkup' => 'required|string|max:255',
         
            'tujuan_pembelajaran' => 'nullable|string',
        'deskripsi' => 'required|string',
        ]);

        $lingkup = LingkupPerkembangan::findOrFail($id);
        $lingkup->update($request->all());

        return redirect()->route('lingkup.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lingkup = LingkupPerkembangan::findOrFail($id);
        $lingkup->delete();

        return redirect()->route('lingkup.index')->with('success', 'Data berhasil dihapus.');
    }
}
