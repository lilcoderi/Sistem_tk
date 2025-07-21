<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    protected $table = 'rapor';

    protected $fillable = [
        'id_siswa',
        'pertumbuhan',
        'nilai_agama',
        'jati_diri',
        'literasi',
        'profil_pancasila',
        'saran',
    ];

    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }
}
