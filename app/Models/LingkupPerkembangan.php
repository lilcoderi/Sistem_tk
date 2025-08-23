<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LingkupPerkembangan extends Model
{
    use HasFactory;

    protected $table = 'lingkup_perkembangan';

    protected $fillable = [
        'nama_lingkup',
        'tujuan_pembelajaran',
        'deskripsi',
        'kurikulum_id',
    ];

    public function tingkatPencapaian()
    {
        return $this->hasMany(TingkatPencapaian::class, 'lingkup_id');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id', 'id');
    }

    
}

