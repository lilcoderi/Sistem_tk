<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanTK extends Model
{
    protected $table = 'kegiatan_tk';

    protected $fillable = [
        'tanggal',
        'judul',
        'deskripsi',
    ];

    public $timestamps = true;
    public function fotoKegiatan()
{
    return $this->hasMany(\App\Models\FotoKegiatan::class, 'kegiatan_tk_id');
}

}
