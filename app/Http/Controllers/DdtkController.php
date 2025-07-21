<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ddtk;
use App\Models\IdentitasAnak;
use App\Models\TumbuhKembang;
use App\Models\HasilAsesmenCeklis;
use Illuminate\Support\Facades\Http;

class DdtkController extends Controller
{
    public function index()
    {
        $siswa = IdentitasAnak::with('pendaftaran')->latest()->paginate(10);
        return view('kepala_sekolah.prediksi.ddtk.index', compact('siswa'));
    }

    // Ubah show() agar menerima ID siswa
public function show($id)
{
    $ddtk = Ddtk::with(['siswa', 'tumbuhKembang', 'hasilAsesmen'])->findOrFail($id);
    return view('kepala_sekolah.prediksi.ddtk.detail', compact('ddtk'));
}



    public function jalankan($id)
    {
        try {
            $response = Http::timeout(10)->get("http://13.239.122.173:5002/predict/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                return back()->with('prediksi', $data);
            } else {
                $errorMessage = 'Terjadi kesalahan saat memproses prediksi.';
                
                if ($response->header('Content-Type') === 'application/json') {
                    $json = $response->json();
                    if (is_array($json) && isset($json['message'])) {
                        $errorMessage = $json['message'];
                    }
                }

                return back()->with('error', 'Prediksi gagal: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Flask API: ' . $e->getMessage());
        }
    }
}
