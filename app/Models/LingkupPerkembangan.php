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
        'deskripsi'
    ];

    public function tingkatPencapaian()
    {
        return $this->hasMany(TingkatPencapaian::class, 'lingkup_id');
    }

    
}

