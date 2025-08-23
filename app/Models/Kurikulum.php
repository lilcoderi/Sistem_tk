<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulum'; // Nama tabel di database
    protected $fillable = ['nama', 'tahun']; // Kolom yang bisa diisi

    // Relasi ke LingkupPerkembangan
    public function lingkupPerkembangans()
    {
        return $this->hasMany(LingkupPerkembangan::class, 'kurikulum_id', 'id');
    }
}