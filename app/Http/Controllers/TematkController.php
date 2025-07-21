<?php

namespace App\Http\Controllers;

use App\Models\Tematk;
use App\Models\Guru;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TematkController extends Controller
{
    // Menampilkan semua data Tematk
    public function index(Request $request)
{
    $sort = $request->query('sort');

    $tematk = Tematk::with('guru');

    // Jika ada parameter sort
    if ($sort === 'asc') {
        $tematk = $tematk->orderBy('tanggal_mulai', 'asc');
    } elseif ($sort === 'desc') {
        $tematk = $tematk->orderBy('tanggal_mulai', 'desc');
    }

    $tematk = $tematk->paginate(6)->appends(['sort' => $sort]);

    return view('kepala_sekolah.penilaian.tema.index', compact('tematk'));
}


    // Form tambah data baru
    public function create()
    {
        $guru = Guru::all();
        return view('kepala_sekolah.penilaian.tema.create', compact('guru'));
    }

    // Proses simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'tema' => 'required',
            'kelas' => 'required',
            'usia' => 'required|numeric',
            'waktu' => 'required',
            'tanggal_mulai' => 'required|date',
            'guru_id' => 'required|exists:guru,id',
        ]);

        Tematk::create($request->all());

        return redirect()->route('tematk.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan detail berdasarkan ID
    public function show($id)
    {
        $tematk = Tematk::with('guru')->findOrFail($id);

     // Hitung tanggal berakhir
    $tanggal_berakhir = null;

    if ($tematk->tanggal_mulai && is_numeric($tematk->waktu)) {
        $tanggal_berakhir = Carbon::parse($tematk->tanggal_mulai)->addWeeks((int) $tematk->waktu);
    }

    return view('kepala_sekolah.penilaian.tema.detail', compact('tematk', 'tanggal_berakhir'));
    }

    // Form edit data
    public function edit($id)
    {
        $tematk = Tematk::findOrFail($id);
        $guru = Guru::all();
        return view('kepala_sekolah.penilaian.tema.edit', compact('tematk', 'guru'));
    }

    // Proses update data (menggunakan POST)
    public function update(Request $request, $id)
{
    $request->validate([
        'tema' => 'required',
        'kelas' => 'required|in:A,B',
        'usia' => 'required|in:4,5',
        'waktu' => 'required',
        'tanggal_mulai' => 'required|date',
        'guru_id' => 'required|exists:guru,id',
    ]);

    $tematk = Tematk::findOrFail($id);
    $tematk->update($request->except(['updated_at']));  // update data kecuali updated_at

    // update updated_at manual dengan timezone Asia/Jakarta
    $tematk->updated_at = Carbon::now('Asia/Jakarta');
    $tematk->save();

    return redirect()->route('tematk.index')->with('success', 'Data berhasil diperbarui.');
}

    // Proses hapus data (menggunakan POST)
    public function destroy($id)
    {
        $tematk = Tematk::findOrFail($id);
        $tematk->delete();

        return redirect()->route('tematk.index')->with('success', 'Data berhasil dihapus.');
    }
}
