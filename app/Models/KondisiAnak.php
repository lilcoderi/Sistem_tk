<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiAnak extends Model
{
    use HasFactory;

    protected $table = 'kondisi_anak';
    protected $primaryKey = 'id_kondisi';

    protected $fillable = [
        'id_siswa',
        'rumah_waktu_masuk_tk',
        'jumlah_penguni_rumah',
        'pergaulan_dengan_teman',
        'nafszu_makan',
        'pagi_hari',
        'siang_hari',
        'malam_hari',
        'hubungan_dengan_ayah',
        'hubungan_dengan_ibu',
        'kebersihan_buang_air',
        'tidur_siang_mulai',
        'tidur_siang_selesai',
        'tidur_malam_mulai',
        'tidur_malam_selesai',
        'hal_lain_waktu_tidur',
        'sikap_anak_dirumah',
        'keadaan_anak_waktu_dalam_kandungan',
        'keadaan_anak_waktu_dilahirkan',
        'disusui_asi',
        'makanan_tambahan',
        'kelainan_cacat_tubuh',
        'cara_anak_minum_susu',
        'apakah_masih_pakai_diaper',
        'penyakit_pernah_diderita',
        'imunisasi_pernah_diterima',
    ];

    public function identitas_anak()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa', 'id_siswa');
    }
}
