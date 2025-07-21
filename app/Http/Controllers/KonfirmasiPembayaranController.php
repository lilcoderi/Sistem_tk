<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\NotifikasiOrangTua;


class KonfirmasiPembayaranController extends Controller
{
    public function index(Request $request)
{
    $query = Pembayaran::with(['identitas_anak', 'pendaftaran']);

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter tahun dari id_pendaftaran, ambil posisi 4 sampai 7 (misal: 'PDK2025...')
    if ($request->filled('tahun')) {
        $query->whereRaw('SUBSTRING(id_pendaftaran, 4, 4) = ?', [$request->tahun]);
    }

    $pembayaran = $query->latest()->get();

    $statusOptions = ['pending', 'verifikasi', 'ditolak'];

    // Ambil tahun unik dari id_pendaftaran
    $tahunOptions = Pembayaran::selectRaw('SUBSTRING(id_pendaftaran, 4, 4) as tahun')
        ->distinct()
        ->orderBy('tahun', 'desc')
        ->pluck('tahun');

    return view('kepala_sekolah.siswa.pembayaran.index', compact('pembayaran', 'statusOptions', 'tahunOptions'));
}




    public function show($id)
    {
        $pembayaran = Pembayaran::with(['identitas_anak', 'pendaftaran'])->findOrFail($id);
        return view('kepala_sekolah.siswa.pembayaran.detail', compact('pembayaran'));
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $statusOptions = ['pending', 'verifikasi', 'ditolak'];
        return view('kepala_sekolah.siswa.pembayaran.edit', compact('pembayaran', 'statusOptions'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,verifikasi,ditolak',
    ]);

    $pembayaran = Pembayaran::with('identitas_anak', 'pendaftaran')->findOrFail($id);
    $pembayaran->update([
        'status' => $request->status,
    ]);

    // Cek apakah pendaftaran terkait user orang tua
    $userOrtu = $pembayaran->pendaftaran?->user_id;

    if ($userOrtu) {
        $statusText = $request->status === 'verifikasi' ? 'diterima' : 'ditolak';

        NotifikasiOrangTua::create([
            'user_id' => $userOrtu,
            'tipe' => 'pembayaran',
            'referensi_id' => $pembayaran->id,
            'pesan' => 'Status pembayaran untuk anak ' . $pembayaran->identitas_anak->nama_lengkap . ' telah ' . $statusText . '.',
        ]);
    }

    return redirect()->route('konfirmasi-pembayaran.index')->with('success', 'Status pembayaran berhasil diperbarui.');
}

}
