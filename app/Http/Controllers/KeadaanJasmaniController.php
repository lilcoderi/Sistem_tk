<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeadaanJasmani;
use App\Models\IdentitasAnak;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class KeadaanJasmaniController extends Controller
{
    // Tampilkan form keadaan jasmani
    public function create($id_pendaftaran)
    {
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        $keadaan = KeadaanJasmani::where('id_siswa', $siswa->id)->first();
        return view('orang_tua.pendaftaran.keadaan_jasmani', compact('id_pendaftaran', 'keadaan'));
    }

    // Simpan atau update data keadaan jasmani
    public function store(Request $request, $id_pendaftaran)
{
    $request->validate([
        'keadaan_waktu_kandungan' => 'required|in:Normal,Tidak',
        'keadaan_waktu_dilahirkan' => 'required|in:Normal,Tidak',
        'anak_disusui_asi' => 'required|in:Normal,Tidak',
        'makanan_tambahan' => 'required|string',
        'kelainan_cacat_yang_diderita' => 'nullable|string',
        'cara_anak_minum_susu' => 'required|in:Gelas,Masih pakai botol',
        'apakah_masih_pakai_diaper' => 'required|in:Ya,Tidak',
    ]);

    $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();

    // Cek apakah data sudah ada
    $keadaan = KeadaanJasmani::where('id_siswa', $siswa->id)->first();

    if ($keadaan) {
        $keadaan->update([
            'keadaan_waktu_kandungan' => $request->keadaan_waktu_kandungan,
            'keadaan_waktu_dilahirkan' => $request->keadaan_waktu_dilahirkan,
            'anak_disusui_asi' => $request->anak_disusui_asi,
            'makanan_tambahan' => $request->makanan_tambahan,
            'kelainan_cacat_yang_diderita' => $request->kelainan_cacat_yang_diderita,
            'cara_anak_minum_susu' => $request->cara_anak_minum_susu,
            'apakah_masih_pakai_diaper' => $request->apakah_masih_pakai_diaper,
        ]);
    } else {
        KeadaanJasmani::create([
            'id_siswa' => $siswa->id,
            'keadaan_waktu_kandungan' => $request->keadaan_waktu_kandungan,
            'keadaan_waktu_dilahirkan' => $request->keadaan_waktu_dilahirkan,
            'anak_disusui_asi' => $request->anak_disusui_asi,
            'makanan_tambahan' => $request->makanan_tambahan,
            'kelainan_cacat_yang_diderita' => $request->kelainan_cacat_yang_diderita,
            'cara_anak_minum_susu' => $request->cara_anak_minum_susu,
            'apakah_masih_pakai_diaper' => $request->apakah_masih_pakai_diaper,
        ]);
    }


    return redirect()->route('dokumen.create', ['id_pendaftaran' => $siswa->id_pendaftaran]);
}

}
