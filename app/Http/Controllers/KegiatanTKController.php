<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanTK;

class KegiatanTKController extends Controller
{
    public function calendar()
    {
        return view('kepala_sekolah.siswa.kegiatan.calender');
    }

    public function calendarOrangtua()
    {
        return view('orang_tua.siswa.kalender.index');
    }


    public function apiEvents()
    {
        $events = KegiatanTK::select('id', 'judul as title', 'tanggal as start')->get();
        return response()->json($events);
    }

    public function create(Request $request)
    {
        $tanggal = $request->query('tanggal');
        return view('kepala_sekolah.siswa.kegiatan.create', compact('tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KegiatanTK::create($request->only('tanggal', 'judul', 'deskripsi'));

        return redirect()->route('kegiatan.calendar')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
{
    $kegiatan = KegiatanTK::findOrFail($id);
    return view('kepala_sekolah.siswa.kegiatan.edit', compact('kegiatan'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'tanggal' => 'required|date',
        'judul' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
    ]);

    $kegiatan = KegiatanTK::findOrFail($id);
    $kegiatan->update($request->only('tanggal', 'judul', 'deskripsi'));

    return redirect()->route('kegiatan.calendar')->with('success', 'Kegiatan berhasil diperbarui.');
}


public function destroy($id)
{
    $kegiatan = KegiatanTK::findOrFail($id);
    $kegiatan->delete();

    return redirect()->route('kegiatan.calendar')->with('success', 'Kegiatan berhasil dihapus.');
}

}
