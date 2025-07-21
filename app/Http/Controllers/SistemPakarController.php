<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Asesmen;

class SistemPakarController extends Controller
{
    public function jalankan($id_siswa)
    {
        try {
            // Ambil asesmen terakhir milik siswa ini
            $asesmen = Asesmen::where('id_siswa', $id_siswa)->latest()->first();

            if (!$asesmen) {
                return back()->with('error', 'Asesmen untuk siswa ini belum tersedia.');
            }

            $id_asesmen = $asesmen->id_asesmen;

            // Kirim data ke Flask API untuk menjalankan/overwrite hasil
            $response = Http::post('http://13.239.122.173:5001/hasilasesmen', [
                'id_siswa' => $id_siswa,
                'id_asesmen' => $id_asesmen
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', '✅ Sistem pakar selesai dijalankan & diperbarui.');
            }

            $error = $response->json()['error'] ?? 'Gagal memproses sistem pakar.';
            return back()->with('error', $error);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
