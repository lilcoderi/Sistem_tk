<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAsesmen extends Model
{
    use HasFactory;

    protected $table = 'detail_asesmen';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_asesmen',
        'modulajar_id',
        'skala_nilai',
    ];

    // Relasi ke Asesmen
    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class, 'id_asesmen', 'id_asesmen');
    }

    // Relasi ke Modul Ajar
    public function modulAjar()
    {
        return $this->belongsTo(ModulAjar::class, 'modulajar_id');
    }
}
