<?php

namespace App\Http\Controllers;

use App\Models\Subtema;
use App\Models\Tematk;
use Illuminate\Http\Request;
use Carbon\Carbon;
class SubtemaController extends Controller
{
    // Tampilkan daftar subtema
    public function index(Request $request)
{
    $query = Subtema::with(['tematk']);

    $kelas = $request->get('kelas', 'A'); // default ke A
    $request->merge(['kelas' => $kelas]);

    if ($kelas) {
        $query->whereHas('tematk', function ($q) use ($kelas) {
        $q->where('kelas', $kelas);
        });
    }


    if ($request->filled('tema_id')) {
        $query->where('tema_id', $request->tema_id);
    }

    if ($request->filled('sort')) {
        $sortDirection = $request->sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy('tanggal_mulai', $sortDirection);
    }

    $subtemas = $query->paginate(6)->appends($request->all()); // biar pagination tetap bawa filter

    $temats = Tematk::all();

    return view('kepala_sekolah.penilaian.subtema.index', compact('subtemas', 'temats'));
}
 

public function show(Subtema $subtema)
{
    $subtema->load(['tematk']);

    $tanggal_berakhir = null;
    if ($subtema->tanggal_mulai && is_numeric($subtema->waktu)) {
        $tanggal_berakhir = \Carbon\Carbon::parse($subtema->tanggal_mulai)->addWeeks((int) $subtema->waktu);
    }

    // Kirim $tanggal_berakhir ke view bersama $subtema
    return view('kepala_sekolah.penilaian.subtema.detail', compact('subtema', 'tanggal_berakhir'));
}


    // Tampilkan form buat subtema baru
    public function create()
    {
        $temats = Tematk::all();
        return view('kepala_sekolah.penilaian.subtema.create', compact('temats'));
    }

    // Simpan data subtema baru
    public function store(Request $request)
    {
        $request->validate([
            'sub_tema' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'waktu' => 'required|string|max:100',
            'tema_id' => 'required|exists:tematk,id',
        ]);

        Subtema::create($request->all());

        return redirect()->route('subtema.index')->with('success', 'Subtema berhasil ditambahkan.');
    }

    // Tampilkan form edit subtema
    public function edit(Subtema $subtema)
    {
        $temats = Tematk::all();
        return view('kepala_sekolah.penilaian.subtema.edit', compact('subtema', 'temats'));
    }

    // Update data subtema
    public function update(Request $request, Subtema $subtema)
    {
        $request->validate([
            'sub_tema' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'waktu' => 'required|string|max:100',
            'tema_id' => 'required|exists:tematk,id',
        ]);

        $subtema->update($request->all());

        return redirect()->route('subtema.index')->with('success', 'Subtema berhasil diupdate.');
    }

    // Hapus data subtema
    public function destroy(Subtema $subtema)
    {
        $subtema->delete();

        return redirect()->route('subtema.index')->with('success', 'Subtema berhasil dihapus.');
    }
}
