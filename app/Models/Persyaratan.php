<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'persyaratan';
    protected $primaryKey = 'id_persyaratan';

    protected $fillable = [
        'id_siswa',
        'fc_akte_kelahiran',
        'fc_kartu_keluarga',
        'fc_ktp_orangtua',
    ];

    public function identitas_anak()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa', 'id_siswa');
    }
}
