<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IdentitasAnak;
use App\Models\Pendaftaran;

class IdentitasAnakController extends Controller
{
    public function formIdentitasAnak($id_pendaftaran)
    {
        // Pastikan pendaftaran ini milik user yang sedang login
        $pendaftaran = Pendaftaran::where('id_pendaftaran', $id_pendaftaran)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Ambil data identitas anak jika sudah ada
        $identitasAnak = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->first();

        return view('orang_tua.pendaftaran.identitas_anak', compact('id_pendaftaran', 'identitasAnak'));
    }

    public function simpanIdentitasAnak(Request $request, $id_pendaftaran)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_rumah' => 'required|string',
            'agama' => 'required|string|max:10',
            'kelompok' => 'required|in:A,B',
            'jumlah_saudara' => 'required|integer|min:0',
            'anak_ke' => 'required|integer|min:1',
            'bahasa_sehari_hari' => 'required|string|max:100',
            'golongan_darah' => 'required|in:O,A,AB,B',
            'ciri_khusus' => 'nullable|string',
        ]);

        // Pastikan pendaftaran valid dan milik user yang login
        $pendaftaran = Pendaftaran::where('id_pendaftaran', $id_pendaftaran)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Tambahkan id_pendaftaran ke data validasi
        $validated['id_pendaftaran'] = $id_pendaftaran;

        // Cek apakah data sudah ada
        $identitasAnak = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->first();

        if ($identitasAnak) {
            // Jika data sudah ada, lakukan update
            $identitasAnak->update($validated);
        } else {
            // Jika belum ada, lakukan insert
            IdentitasAnak::create($validated);
        }

        return redirect()->route('orangtua.create', ['id_pendaftaran' => $pendaftaran->id_pendaftaran])
                        ->with('success', 'Data identitas anak berhasil disimpan.');
    }

}