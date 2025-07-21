<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKegiatan extends Model
{
    protected $table = 'fotokegiatan';

    protected $fillable = [
        'kegiatan_tk_id',
        'foto',
        'keterangan',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(KegiatanTk::class, 'kegiatan_tk_id');
    }
}
