<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilAsesmenCeklis extends Model
{
    protected $table = 'hasil_asesmen_ceklis';

    protected $fillable = [
        'id_siswa',
        'id_asesmen',
        'subtema_id',
        'tanggal_proses',
        'hasil',
        'rekomendasi',
        'catatan',
    ];

    protected $casts = [
        'hasil' => 'array',
    ];

    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa');
    }
    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class, 'id_asesmen');
    }
    public function subtema()
{
    return $this->belongsTo(Subtema::class, 'subtema_id');
}

}
