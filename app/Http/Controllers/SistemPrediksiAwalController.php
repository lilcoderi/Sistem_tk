<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Log;

class SistemPrediksiAwalController extends Controller
{
    /**
     * Menjalankan sistem pakar untuk prediksi awal berdasarkan ID siswa.
     */
    public function jalankanSistemPakar($id_siswa)
    {
        try {
            // 1. Cek apakah sudah ada hasil prediksi untuk siswa ini
            $sudahAda = DB::table('hasil_prediksi_awal')
                ->where('id_siswa', $id_siswa)
                ->exists();

            if ($sudahAda) {
                return redirect()->back()->with('error', 'Prediksi sudah pernah dilakukan untuk siswa ini.');
            }

            // 2. Kirim data ke sistem pakar (Flask API)
            $client = new Client();
            $response = $client->post('https://sistem-tk-py.up.railway.app/prediksi', [
                'json' => ['id_siswa' => (int) $id_siswa],
                'timeout' => 10, // Tambahkan timeout agar tidak nge-hang
            ]);

            // 3. Pastikan response sukses
            if ($response->getStatusCode() !== 200) {
                return redirect()->back()->with('error', 'Gagal: respons dari sistem pakar tidak berhasil.');
            }

            // 4. Ambil dan decode hasil
            $hasil = json_decode($response->getBody(), true);

            if (!is_array($hasil) || !isset($hasil['nama_siswa'])) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan dalam respons sistem pakar.');
            }

            // 5. Berhasil
            return redirect()->back()->with('success', 'Prediksi berhasil diproses untuk ' . $hasil['nama_siswa']);

        } catch (RequestException $e) {
            Log::error('Request ke Flask gagal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat menghubungi sistem pakar. Pastikan server aktif.');
        } catch (Exception $e) {
            Log::error('Kesalahan sistem pakar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
