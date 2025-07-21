<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\IdentitasAnak;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    // Tampilkan form pembayaran berdasarkan ID pendaftaran
    public function create($id_pendaftaran)
    {
        // Validasi: apakah anak dengan ID pendaftaran ini ada
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        // Cek apakah sudah ada data pembayaran
        $pembayaran = Pembayaran::where('id_pendaftaran', $id_pendaftaran)->first();


        return view('orang_tua.pendaftaran.pembayaran', compact('id_pendaftaran', 'pembayaran'));
    }

    // Simpan bukti pembayaran
    public function store(Request $request, $id_pendaftaran)
{
    // Validasi inputan
    $request->validate([
        'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:100000',
    ]);

    // Ambil data anak berdasarkan ID pendaftaran
    $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();

    // Cek apakah sudah ada data pembayaran untuk id_pendaftaran ini
    $pembayaran = Pembayaran::where('id_pendaftaran', $id_pendaftaran)->first();

    // Simpan file bukti pembayaran ke storage
    $path = $request->file('bukti_pembayaran')->store('pembayaran', 'public');

    if ($pembayaran) {
        // Hapus bukti lama jika ada
        if ($pembayaran->bukti_pembayaran && Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }

        // Update data
        $pembayaran->update([
            'tanggal_pembayaran' => now(),
            'status' => 'pending',
            'bukti_pembayaran' => $path,
        ]);
    } else {
        // Buat data baru
        Pembayaran::create([
            'id_siswa' => $siswa->id,
            'id_pendaftaran' => $id_pendaftaran,
            'tanggal_pembayaran' => now(),
            'status' => 'pending',
            'bukti_pembayaran' => $path,
        ]);
    }

    return redirect()->route('orang_tua.dashboard', ['id_pendaftaran' => $siswa->id_pendaftaran]);
}

public function riwayatOrangtua()
{
    $user = auth()->user();

    // Ambil semua siswa milik user
    $siswaList = \App\Models\IdentitasAnak::whereHas('pendaftaran', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->pluck('id');

    // Ambil semua pembayaran milik anak-anak tersebut
    $pembayaranList = \App\Models\Pembayaran::whereIn('id_siswa', $siswaList)
        ->with('siswa')
        ->orderBy('tanggal_pembayaran', 'desc')
        ->get();

    return view('orang_tua.siswa.pembayaran.index', compact('pembayaranList'));
}


}
