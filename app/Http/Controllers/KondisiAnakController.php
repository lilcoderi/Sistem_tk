<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KondisiAnak;
use App\Models\IdentitasAnak;

class KondisiAnakController extends Controller
{
    // Display the child condition form
    public function create($id_pendaftaran)
    {
        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();
        
        // Ambil data kondisi anak jika sudah ada
        $kondisiAnak = KondisiAnak::where('id_siswa', $siswa->id)->first();

        return view('orang_tua.pendaftaran.keadaan_anak', compact('id_pendaftaran', 'kondisiAnak'));
    }

    // Store or update child condition data
    public function store(Request $request, $id_pendaftaran)
    {
        $request->validate([
            'rumah_waktu_masuk_tk' => 'required|in:Rumah keluarga sendiri,Dengan keluarga lain',
            'jumlah_penguni_rumah' => 'required|integer|min:1',
            'pergaulan_dengan_teman' => 'required|in:Banyak,Cukup,Kurang',
            'nafszu_makan' => 'required|in:Banyak,Cukup,Kurang',
            'pagi_hari' => 'required|in:Banyak,Cukup,Kurang',
            'siang_hari' => 'required|in:Banyak,Cukup,Kurang',
            'malam_hari' => 'required|in:Banyak,Cukup,Kurang',
            'hubungan_dengan_ayah' => 'required|in:Baik sekali,Cukup,Kurang',
            'hubungan_dengan_ibu' => 'required|in:Baik sekali,Cukup,Kurang',
            'kebersihan_buang_air' => 'required|in:Dibantu,Tidak harus dibantu',
            'tidur_siang_mulai' => 'nullable|date_format:H:i',
            'tidur_siang_selesai' => 'nullable|date_format:H:i',
            'tidur_malam_mulai' => 'nullable|date_format:H:i',
            'tidur_malam_selesai' => 'nullable|date_format:H:i',
            'hal_lain_waktu_tidur' => 'nullable|string',
            'sikap_anak_dirumah' => 'required|in:Mudah diatur,Susah diatur',
            'penyakit_pernah_diderita' => 'nullable|string',
            'imunisasi_pernah_diterima' => 'nullable|string',
            'hal_mengenai_anak_yang_perlu_diketahui' => 'nullable|string',
        ]);

        $siswa = IdentitasAnak::where('id_pendaftaran', $id_pendaftaran)->firstOrFail();

        // Cek apakah data kondisi anak sudah ada
        $kondisiAnak = KondisiAnak::where('id_siswa', $siswa->id)->first();

        $data = [
            'id_siswa' => $siswa->id,
            'rumah_waktu_masuk_tk' => $request->rumah_waktu_masuk_tk,
            'jumlah_penguni_rumah' => $request->jumlah_penguni_rumah,
            'pergaulan_dengan_teman' => $request->pergaulan_dengan_teman,
            'nafszu_makan' => json_encode([
                'pagi_hari' => $request->pagi_hari,
                'siang_hari' => $request->siang_hari,
                'malam_hari' => $request->malam_hari,
            ]),
            'pagi_hari' => $request->pagi_hari,
            'siang_hari' => $request->siang_hari,
            'malam_hari' => $request->malam_hari,
            'hubungan_dengan_ayah' => $request->hubungan_dengan_ayah,
            'hubungan_dengan_ibu' => $request->hubungan_dengan_ibu,
            'kebersihan_buang_air' => $request->kebersihan_buang_air,
            'tidur_siang_mulai' => $request->tidur_siang_mulai,
            'tidur_siang_selesai' => $request->tidur_siang_selesai,
            'tidur_malam_mulai' => $request->tidur_malam_mulai,
            'tidur_malam_selesai' => $request->tidur_malam_selesai,
            'hal_lain_waktu_tidur' => $request->hal_lain_waktu_tidur,
            'sikap_anak_dirumah' => $request->sikap_anak_dirumah,
            'penyakit_pernah_diderita' => $request->penyakit_pernah_diderita,
            'imunisasi_pernah_diterima' => $request->imunisasi_pernah_diterima,
            'hal_mengenai_anak_yang_perlu_diketahui' => $request->hal_mengenai_anak_yang_perlu_diketahui,
        ];

        if ($kondisiAnak) {
            // Update data jika sudah ada
            $kondisiAnak->update($data);
        } else {
            // Buat data baru jika belum ada
            KondisiAnak::create($data);
        }

        return redirect()->route('keadaan_jasmani.create', ['id_pendaftaran' => $siswa->id_pendaftaran])
                        ->with('success', 'Data kondisi anak berhasil disimpan.');
    }
}
