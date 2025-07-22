<?php

namespace App\Http\Controllers;

use App\Models\FotoKegiatan;

use Illuminate\Http\Request;

class FotoKegiatanController extends Controller
{
    public function index()
    {
        $data = KegiatanTk::with('fotoKegiatan')->orderBy('tanggal', 'desc')->get();
        return view('kepala_sekolah.siswa.foto.index', compact('data'));
    }

    public function create()
    {
        $kegiatan = KegiatanTk::all();
        return view('kepala_sekolah.siswa.foto.create', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_tk_id' => 'required|exists:kegiatan_tk,id',
            'foto.*' => 'required|image|mimes:jpg,jpeg,png|max:10000',
        ]);

        foreach ($request->file('foto') as $file) {
            $filename = $file->store('foto_kegiatan', 'public');

            FotoKegiatan::create([
                'kegiatan_tk_id' => $request->kegiatan_tk_id,
                'foto' => $filename,
                'keterangan' => $request->keterangan
            ]);
        }

        return redirect()->route('fotokegiatan.index')->with('success', 'Foto berhasil disimpan.');
    }

    public function edit($id)
{
    $foto = FotoKegiatan::findOrFail($id);
    return view('kepala_sekolah.siswa.foto.edit', compact('foto'));
}

public function update(Request $request, $id)
{
    $foto = FotoKegiatan::findOrFail($id);

    $request->validate([
        'keterangan' => 'nullable|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Jika user upload foto baru, hapus lama & simpan baru
    if ($request->hasFile('foto')) {
        \Storage::disk('public')->delete($foto->foto);
        $filename = $request->file('foto')->store('foto_kegiatan', 'public');
        $foto->foto = $filename;
    }

    $foto->keterangan = $request->keterangan;
    $foto->save();

    return redirect()->route('fotokegiatan.show', $foto->kegiatan_tk_id)
                     ->with('success', 'Foto dan keterangan berhasil diperbarui.');
}



    public function destroy($id)
    {
        $foto = FotoKegiatan::findOrFail($id);

        // Hapus file dari storage
        \Storage::disk('public')->delete($foto->foto);

        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function deleteGroup($id)
{
    $fotos = FotoKegiatan::where('kegiatan_tk_id', $id)->get();

    foreach ($fotos as $foto) {
        \Storage::disk('public')->delete($foto->foto); // hapus file
        $foto->delete(); // hapus record
    }

    return back()->with('success', 'Semua foto pada kegiatan ini telah dihapus.');
}

    public function show($id)
{
    $kegiatan = KegiatanTk::with('fotoKegiatan')->findOrFail($id);
    return view('kepala_sekolah.siswa.foto.detail', compact('kegiatan'));
}

}
