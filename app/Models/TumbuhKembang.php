<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TumbuhKembang extends Model
{
    use HasFactory;

    protected $table = 'tumbuh_kembang';

    protected $fillable = [
        'id_siswa',
        'tinggi_badan',
        'berat_badan',
        'lingkar_kepala',
        'umur',
        'tanggal_input'
    ];

    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }
}
