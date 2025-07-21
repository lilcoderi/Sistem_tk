<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPrediksiAwal extends Model
{
    use HasFactory;

    protected $table = 'hasil_prediksi_awal';

    protected $fillable = [
        'id_siswa',
        'prediksi_awal',
        'rekomendasi_awal',
        'catatan_sistem_pakar',
    ];

    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }
}
