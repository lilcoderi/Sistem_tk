<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesmen extends Model
{
    use HasFactory;

    protected $table = 'asesmen';
    protected $primaryKey = 'id_asesmen';

    protected $fillable = [
        'id_siswa',
        'id_subtema',
        'id_guru',
        'semester',
        'tahun_ajar',
        'tipe_penilaian',
    ];

    // Relasi ke identitas anak
    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }

    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'id_subtema');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}

