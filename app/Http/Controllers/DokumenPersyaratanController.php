<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenPersyaratan;
use App\Models\IdentitasAnak;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class DokumenPersyaratanController extends Controller
{
    public function create($id_pendaftaran)
    {
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        $dokumen = DokumenPersyaratan::where('id_siswa', $siswa->id)->first();

        return view('orang_tua.pendaftaran.dokumen', compact('id_pendaftaran', 'dokumen'));
    }

    public function store(Request $request, $id_pendaftaran)
    {
        // ✅ Inisialisasi konfigurasi Cloudinary dari .env
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => ['secure' => true]
        ]);

        $request->validate([
            'akta_kelahiran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ktp_orang_tua'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cari siswa berdasarkan id_pendaftaran
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();

        // Cek apakah dokumen sudah ada
        $dokumen = DokumenPersyaratan::where('id_siswa', $siswa->id)->first();

        // Data yang akan diupdate / disimpan
        $data = [
            'id_siswa'       => $siswa->id,
            'id_pendaftaran' => $id_pendaftaran,
        ];

        // Upload ke Cloudinary
        if ($request->hasFile('akta_kelahiran')) {
            $uploadedAkta = (new UploadApi())->upload(
                $request->file('akta_kelahiran')->getRealPath(),
                ['folder' => 'dokumen_persyaratan']
            );
            $data['akta_kelahiran'] = $uploadedAkta['secure_url'];
        }

        if ($request->hasFile('kartu_keluarga')) {
            $uploadedKK = (new UploadApi())->upload(
                $request->file('kartu_keluarga')->getRealPath(),
                ['folder' => 'dokumen_persyaratan']
            );
            $data['kartu_keluarga'] = $uploadedKK['secure_url'];
        }

        if ($request->hasFile('ktp_orang_tua')) {
            $uploadedKTP = (new UploadApi())->upload(
                $request->file('ktp_orang_tua')->getRealPath(),
                ['folder' => 'dokumen_persyaratan']
            );
            $data['ktp_orang_tua'] = $uploadedKTP['secure_url'];
        }

        // Simpan atau update
        if ($dokumen) {
            $dokumen->update($data);
        } else {
            DokumenPersyaratan::create($data);
        }

        return redirect()->route('pembayaran.create', ['id_pendaftaran' => $id_pendaftaran]);
    }
}
