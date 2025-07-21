<?php

namespace App\Http\Controllers;

use App\Models\IdentitasAnak;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataSiswaController extends Controller
{
    public function index(Request $request)
{
    $query = IdentitasAnak::with('pendaftaran');

    // Filter berdasarkan kelompok
    if ($request->filled('kelompok')) {
        $query->where('kelompok', $request->kelompok);
    }

    // Filter berdasarkan tahun id_pendaftaran (PDK2025 → 2025)
    if ($request->filled('tahun')) {
        $query->whereHas('pendaftaran', function ($q) use ($request) {
            $q->whereRaw('SUBSTRING(id_pendaftaran, 4, 4) = ?', [$request->tahun]);
        });
    }

    // Filter pencarian nama
    if ($request->filled('search')) {
        $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
    }

    // Urutkan berdasarkan nama
    if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
        $query->orderBy('nama_lengkap', $request->sort);
    } else {
        $query->orderBy('nama_lengkap', 'asc'); // default
    }

    $data = $query->paginate(10)->withQueryString();

    // Ambil daftar tahun dari id_pendaftaran
    $tahunList = IdentitasAnak::with('pendaftaran')
        ->get()
        ->pluck('pendaftaran.id_pendaftaran')
        ->filter()
        ->map(fn($id) => substr($id, 3, 4))
        ->unique()
        ->sort()
        ->values();

    return view('kepala_sekolah.siswa.data_siswa.index', compact('data', 'tahunList'));
}



    public function create()
    {
        return view('kepala_sekolah.siswa.data_siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pendaftaran' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable|string',
            'agama' => 'nullable|string|max:50',
            'kelompok' => 'nullable|string|max:50',
            'jumlah_saudara' => 'nullable|integer',
            'anak_ke' => 'nullable|integer',
            'bahasa_sehari_hari' => 'nullable|string|max:100',
            'golongan_darah' => 'nullable|string|max:3',
            'ciri_khusus' => 'nullable|string|max:255',
        ]);

        IdentitasAnak::create($validated);
        return redirect()->route('data-siswa.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $siswa = IdentitasAnak::findOrFail($id);
        return view('kepala_sekolah.siswa.data_siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = IdentitasAnak::findOrFail($id);

        $validated = $request->validate([
            'id_pendaftaran' => 'nullable',
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat_rumah' => 'nullable|string',
            'agama' => 'nullable|string|max:50',
            'kelompok' => 'nullable|string|max:50',
            'jumlah_saudara' => 'nullable|integer',
            'anak_ke' => 'nullable|integer',
            'bahasa_sehari_hari' => 'nullable|string|max:100',
            'golongan_darah' => 'nullable|string|max:3',
            'ciri_khusus' => 'nullable|string|max:255',
        ]);

        $siswa->update($validated);
        return redirect()->route('data-siswa.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = IdentitasAnak::findOrFail($id);
        $siswa->delete();
        return redirect()->route('data-siswa.index')->with('success', 'Data berhasil dihapus.');
    }

    public function show($id)
{
    $siswa = IdentitasAnak::with([
        'orangtua',
        'kondisiAnak',
        'keadaanJasmani',
        'dokumenPersyaratan',
        'hasil_prediksi_awal',
    ])->findOrFail($id);

    return view('kepala_sekolah.siswa.data_siswa.detail', compact('siswa'));
}


public function profilSiswaOrangtua()
    {
        $userId = Auth::id();

        // Ambil data anak berdasarkan user login
        $anak = IdentitasAnak::with(['pendaftaran', 'orangtua', 'hasil_prediksi_awal'])
            ->whereHas('pendaftaran', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        // Debug: Log jumlah anak dan ID
        \Log::info('Jumlah anak ditemukan: ' . $anak->count());
        \Log::info('ID anak: ' . $anak->pluck('id')->toJson());

        // Ambil data orang tua pertama yang terkait dengan anak-anak tersebut
        $orangtua = $anak->isNotEmpty() ? OrangTua::whereIn('id_siswa', $anak->pluck('id'))->first() : null;

        // Debug: Log data orang tua
        \Log::info('Data orang tua: ' . ($orangtua ? $orangtua->toJson() : 'null'));

        return view('orang_tua.siswa.profil.index', compact('anak', 'orangtua'));
    }




public function editProfilAnak($id)
{
    $siswa = IdentitasAnak::findOrFail($id);
    return view('orang_tua.siswa.profil.edit_anak', compact('siswa'));
}

public function updateProfilAnak(Request $request, $id)
{
    $siswa = IdentitasAnak::findOrFail($id);

    $validated = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'nama_panggilan' => 'nullable|string|max:255',
        'tempat_lahir' => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'alamat_rumah' => 'nullable|string',
        'agama' => 'nullable|string|max:50',
        'jumlah_saudara' => 'nullable|integer',
        'anak_ke' => 'nullable|integer',
        'bahasa_sehari_hari' => 'nullable|string|max:100',
        'golongan_darah' => 'nullable|string|max:3',
        'ciri_khusus' => 'nullable|string|max:255',
    ]);

    $siswa->update($validated);
    return redirect()->route('profil-siswa.orangtua')->with('success', 'Profil anak berhasil diperbarui.');
}

public function editProfilOrangtua($id)
    {
        $orangtua = OrangTua::findOrFail($id);
        return view('orang_tua.siswa.profil.edit_orangtua', compact('orangtua'));
    }


public function updateProfilOrangtua(Request $request, $id)
{
    $ortu = \App\Models\OrangTua::findOrFail($id);

    $validated = $request->validate([
        'nama_ayah' => 'nullable|string|max:255',
        'nik_ayah' => 'nullable|string|max:20',
        'tempat_lahir_ayah' => 'nullable|string|max:100',
        'tanggal_lahir_ayah' => 'nullable|date',
        'agama_ayah' => 'nullable|string|max:50',
        'kewarganegaraan_ayah' => 'nullable|string|max:50',
        'pendidikan_ayah' => 'nullable|string|max:50',
        'pekerjaan_ayah' => 'nullable|string|max:50',
        'alamat_rumah_ayah' => 'nullable|string',
        'no_telepon_ayah' => 'nullable|string|max:20',
        'nama_ibu' => 'nullable|string|max:255',
        'nik_ibu' => 'nullable|string|max:20',
        'tempat_lahir_ibu' => 'nullable|string|max:100',
        'tanggal_lahir_ibu' => 'nullable|date',
        'agama_ibu' => 'nullable|string|max:50',
        'kewarganegaraan_ibu' => 'nullable|string|max:50',
        'pendidikan_ibu' => 'nullable|string|max:50',
        'pekerjaan_ibu' => 'nullable|string|max:50',
        'alamat_rumah_ibu' => 'nullable|string',
        'no_telepon_ibu' => 'nullable|string|max:20',
    ]);

    $ortu->update($validated);
    return redirect()->route('profil-siswa.orangtua')->with('success', 'Profil orang tua berhasil diperbarui.');
}



}
 