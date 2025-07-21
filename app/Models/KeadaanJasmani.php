<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeadaanJasmani extends Model
{
    protected $table = 'keadaan_jasmani';
    protected $primaryKey = 'id_keadaan_jasmani';
    protected $fillable = [
        'id_siswa',
        'sebelum_masuk_tk', 'keadaan_waktu_kandungan', 'keadaan_waktu_dilahirkan', 'anak_disusui_asi',
        'makanan_tambahan', 'kelainan_cacat_yang_diderita', 'cara_anak_minum_susu', 'apakah_masih_pakai_diaper',
    ];

    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }
}