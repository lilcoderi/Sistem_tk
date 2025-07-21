<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenPersyaratan;
use App\Models\IdentitasAnak;
use Illuminate\Support\Facades\Storage;

class DokumenPersyaratanController extends Controller
{
    public function create($id_pendaftaran)
    {
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        $dokumen = \App\Models\DokumenPersyaratan::where('id_siswa', $siswa->id)->first();
        return view('orang_tua.pendaftaran.dokumen', compact('id_pendaftaran', 'dokumen'));
    }

    public function store(Request $request, $id_pendaftaran)
    {
        $request->validate([
            'akta_kelahiran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ktp_orang_tua'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cari siswa berdasarkan id_pendaftaran
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();

        // Cek apakah dokumen sudah ada
        $dokumen = DokumenPersyaratan::where('id_siswa', $siswa->id)->first();

        // Siapkan data yang akan di-update atau disimpan
        $data = [
            'id_siswa' => $siswa->id,
            'id_pendaftaran' => $id_pendaftaran,
        ];

        if ($request->hasFile('akta_kelahiran')) {
            if ($dokumen && $dokumen->akta_kelahiran) {
                Storage::disk('public')->delete($dokumen->akta_kelahiran);
            }
            $data['akta_kelahiran'] = $request->file('akta_kelahiran')->store('dokumen', 'public');
        }

        if ($request->hasFile('kartu_keluarga')) {
            if ($dokumen && $dokumen->kartu_keluarga) {
                Storage::disk('public')->delete($dokumen->kartu_keluarga);
            }
            $data['kartu_keluarga'] = $request->file('kartu_keluarga')->store('dokumen', 'public');
        }

        if ($request->hasFile('ktp_orang_tua')) {
            if ($dokumen && $dokumen->ktp_orang_tua) {
                Storage::disk('public')->delete($dokumen->ktp_orang_tua);
            }
            $data['ktp_orang_tua'] = $request->file('ktp_orang_tua')->store('dokumen', 'public');
        }

        if ($dokumen) {
            // Update jika data sudah ada
            $dokumen->update($data);
        } else {
            // Insert jika data belum ada
            DokumenPersyaratan::create($data);
        }

        return redirect()->route('pembayaran.create', ['id_pendaftaran' => $id_pendaftaran]);
    }
}
