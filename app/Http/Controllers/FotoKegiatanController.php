<?php

namespace App\Http\Controllers;

use App\Models\FotoKegiatan;
use App\Models\KegiatanTK;
use Illuminate\Http\Request;
use Cloudinary\Api\Upload\UploadApi; // ✅ pakai langsung SDK

class FotoKegiatanController extends Controller
{
    public function index()
    {
        $data = KegiatanTK::with('fotoKegiatan')->orderBy('tanggal', 'desc')->get();
        return view('kepala_sekolah.siswa.foto.index', compact('data'));
    }

    public function create()
    {
        $kegiatan = KegiatanTK::all();
        return view('kepala_sekolah.siswa.foto.create', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_tk_id' => 'required|exists:kegiatan_tk,id',
            'foto.*'         => 'required|image|mimes:jpg,jpeg,png|max:10000',
            'keterangan'     => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                // ✅ Upload ke Cloudinary dengan UploadApi
                $uploadedFile = (new UploadApi())->upload(
                    $file->getRealPath(),
                    [
                        'folder' => 'foto_kegiatan'
                    ]
                );

                FotoKegiatan::create([
                    'kegiatan_tk_id' => $request->kegiatan_tk_id,
                    'foto'           => $uploadedFile['secure_url'], // URL file
                    'public_id'      => $uploadedFile['public_id'],  // simpan public_id untuk delete nanti
                    'keterangan'     => $request->keterangan
                ]);
            }
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
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // ✅ Hapus file lama dari Cloudinary
            if ($foto->public_id) {
                (new UploadApi())->destroy($foto->public_id);
            }

            // Upload file baru
            $uploadedFile = (new UploadApi())->upload(
                $request->file('foto')->getRealPath(),
                [
                    'folder' => 'foto_kegiatan'
                ]
            );

            $foto->foto      = $uploadedFile['secure_url'];
            $foto->public_id = $uploadedFile['public_id'];
        }

        $foto->keterangan = $request->keterangan;
        $foto->save();

        return redirect()->route('fotokegiatan.show', $foto->kegiatan_tk_id)
                         ->with('success', 'Foto dan keterangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $foto = FotoKegiatan::findOrFail($id);

        // ✅ Hapus dari Cloudinary
        if ($foto->public_id) {
            (new UploadApi())->destroy($foto->public_id);
        }

        $foto->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function deleteGroup($id)
    {
        $fotos = FotoKegiatan::where('kegiatan_tk_id', $id)->get();

        foreach ($fotos as $foto) {
            if ($foto->public_id) {
                (new UploadApi())->destroy($foto->public_id);
            }
            $foto->delete();
        }

        return back()->with('success', 'Semua foto pada kegiatan ini telah dihapus.');
    }

    public function show($id)
    {
        $kegiatan = KegiatanTK::with('fotoKegiatan')->findOrFail($id);
        return view('kepala_sekolah.siswa.foto.detail', compact('kegiatan'));
    }
}
