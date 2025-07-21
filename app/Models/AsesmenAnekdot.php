<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesmenAnekdot extends Model
{
    use HasFactory;

    protected $table = 'asesmen_anekdot';

    protected $fillable = [
        'siswa_id',
        'lingkup_id',
        'subtema_id',
        'tanggal_pelaksanaan',
        'dokumentasi_foto',
        'keterangan',
    ];

    // Relasi ke siswa (identitas_anak)
    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'siswa_id');
    }

    // Relasi ke lingkup perkembangan
    public function lingkup()
    {
        return $this->belongsTo(LingkupPerkembangan::class, 'lingkup_id');
    }

    // Relasi ke subtema
    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'subtema_id');
    }
}
