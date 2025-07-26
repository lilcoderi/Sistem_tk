<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\IdentitasAnak;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;

class PembayaranController extends Controller
{
    // Tampilkan form pembayaran berdasarkan ID pendaftaran
    public function create($id_pendaftaran)
    {
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        $pembayaran = Pembayaran::where('id_pendaftaran', $id_pendaftaran)->first();
        return view('orang_tua.pendaftaran.pembayaran', compact('id_pendaftaran', 'pembayaran'));
    }

    // Simpan bukti pembayaran
    public function store(Request $request, $id_pendaftaran)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:100000',
        ]);

        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        $pembayaran = Pembayaran::where('id_pendaftaran', $id_pendaftaran)->first();

        // Upload ke Cloudinary
        $upload = (new UploadApi())->upload(
            $request->file('bukti_pembayaran')->getRealPath(),
            [
                'folder' => 'pembayaran'
            ]
        );

        $secureUrl = $upload['secure_url'];
        $publicId = $upload['public_id'];

        if ($pembayaran) {
            // Hapus bukti lama dari Cloudinary jika ada public_id
            if (!empty($pembayaran->public_id)) {
                try {
                    (new UploadApi())->destroy($pembayaran->public_id);
                } catch (\Exception $e) {
                    // log error jika perlu
                }
            }

            $pembayaran->update([
                'tanggal_pembayaran' => now(),
                'status' => 'pending',
                'bukti_pembayaran' => $secureUrl,
                'public_id' => $publicId,
            ]);
        } else {
            Pembayaran::create([
                'id_siswa' => $siswa->id,
                'id_pendaftaran' => $id_pendaftaran,
                'tanggal_pembayaran' => now(),
                'status' => 'pending',
                'bukti_pembayaran' => $secureUrl,
                'public_id' => $publicId,
            ]);
        }

        return redirect()->route('orang_tua.dashboard', ['id_pendaftaran' => $siswa->id_pendaftaran]);
    }

    // Riwayat pembayaran orang tua
    public function riwayatOrangtua()
    {
        $user = auth()->user();

        $siswaList = \App\Models\IdentitasAnak::whereHas('pendaftaran', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->pluck('id');

        $pembayaranList = \App\Models\Pembayaran::whereIn('id_siswa', $siswaList)
            ->with('siswa')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        return view('orang_tua.siswa.pembayaran.index', compact('pembayaranList'));
    }
}
