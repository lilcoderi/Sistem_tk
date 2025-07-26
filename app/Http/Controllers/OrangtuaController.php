<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IdentitasAnak;
use App\Models\OrangTua;

class OrangtuaController extends Controller
{
    public function create($id_pendaftaran)
    {
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        $orangtua = OrangTua::where('id_siswa', $siswa->id)->first();

        return view('orang_tua.pendaftaran.identitas_ortu', compact('id_pendaftaran', 'orangtua'));
    }

    public function store(Request $request, $id_pendaftaran)
    {
        $request->validate([
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'nullable|string|max:16',
            'tempat_lahir_ayah' => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'agama_ayah' => 'nullable|string|max:10',
            'kewarganegaraan_ayah' => 'nullable|string|max:50',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'alamat_rumah_ayah' => 'nullable|string|max:255',
            'no_telepon_ayah' => 'nullable|string|max:13',

            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'nullable|string|max:16',
            'tempat_lahir_ibu' => 'nullable|string|max:100',
            'tanggal_lahir_ibu' => 'nullable|date',
            'agama_ibu' => 'nullable|string|max:10',
            'kewarganegaraan_ibu' => 'nullable|string|max:50',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'alamat_rumah_ibu' => 'nullable|string|max:255',
            'no_telepon_ibu' => 'nullable|string|max:13',
        ]);

        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();

        OrangTua::updateOrCreate(
            ['id_siswa' => $siswa->id],
            [
                'nama_ayah' => $request->nama_ayah,
                'nik_ayah' => $request->nik_ayah,
                'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                'agama_ayah' => $request->agama_ayah,
                'kewarganegaraan_ayah' => $request->kewarganegaraan_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'alamat_rumah_ayah' => $request->alamat_rumah_ayah,
                'no_telepon_ayah' => $request->no_telepon_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                'agama_ibu' => $request->agama_ibu,
                'kewarganegaraan_ibu' => $request->kewarganegaraan_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'alamat_rumah_ibu' => $request->alamat_rumah_ibu,
                'no_telepon_ibu' => $request->no_telepon_ibu,
                'id_siswa' => $siswa->id
            ]
        );

        return redirect()->route('keadaan_anak.create', ['id_pendaftaran' => $siswa->id_pendaftaran])
                        ->with('success', 'Data orang tua berhasil disimpan.');
    }
}
