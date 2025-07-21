<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_persyaratan';

    protected $fillable = [
        'id_siswa',
        'id_pendaftaran',
        'akta_kelahiran',
        'kartu_keluarga',
        'ktp_orang_tua',
    ];

    public function identitas_anak()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa', 'id');
    }
}
