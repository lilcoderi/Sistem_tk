<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TumbuhKembang;
use App\Models\IdentitasAnak;

class TumbuhKembangController extends Controller
{
    public function index()
    {
        $data = TumbuhKembang::with('siswa')->get();
        return view('kepala_sekolah.prediksi.data_tumbuh_kembang.index', compact('data'));
    }

    public function create()
    {
        $siswa = IdentitasAnak::all();
        return view('kepala_sekolah.prediksi.data_tumbuh_kembang.create', compact('siswa'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:identitas_anak,id',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'lingkar_kepala' => 'required|numeric',
            'umur' => 'required|integer',
        ]);

        TumbuhKembang::create($request->all());

        return redirect()->route('tumbuh_kembang.index')->with('success', 'Data tumbuh kembang berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = TumbuhKembang::findOrFail($id);
        $siswa = IdentitasAnak::all();
        return view('kepala_sekolah.prediksi.data_tumbuh_kembang.edit', compact('data', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required|exists:identitas_anak,id',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'lingkar_kepala' => 'required|numeric',
            'umur' => 'required|integer',
        ]);

        $data = TumbuhKembang::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('tumbuh_kembang.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = TumbuhKembang::findOrFail($id);
        $data->delete();

        return redirect()->route('tumbuh_kembang.index')->with('success', 'Data berhasil dihapus.');
    }
}
