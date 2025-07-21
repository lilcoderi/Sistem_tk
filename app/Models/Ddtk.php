<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ddtk extends Model
{
    use HasFactory;

    protected $table = 'ddtk';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'id_tumbuhkembang',
        'id_hasilasesmenceklis',
        'hasil_ddtk',
        'rekomendasi',
        'keterangan',
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }

    public function ddtk()
{
    return $this->hasOne(Ddtk::class, 'id_siswa');
}


    // Relasi ke tumbuh kembang
    public function tumbuhKembang()
    {
        return $this->belongsTo(TumbuhKembang::class, 'id_tumbuhkembang');
    }

    // Relasi ke hasil asesmen
    public function hasilAsesmen()
    {
        return $this->belongsTo(HasilAsesmenCeklis::class, 'id_hasilasesmenceklis');
    }
}
