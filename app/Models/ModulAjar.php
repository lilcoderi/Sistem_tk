<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulAjar extends Model
{
    use HasFactory;

    protected $table = 'modul_ajar';

    protected $fillable = [
        'lingkup_id',
        'subtema_id',
        'rencana_pembelajaran',
        'ceklis_anekdot',
    ];

    // Relasi ke Lingkup Perkembangan
    public function lingkup()
    {
        return $this->belongsTo(LingkupPerkembangan::class, 'lingkup_id');
    }

    // Relasi ke Subtema
    public function subtema()
    {
        return $this->belongsTo(Subtema::class, 'subtema_id');
    }
}
