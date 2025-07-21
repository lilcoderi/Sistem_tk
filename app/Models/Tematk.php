<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tematk extends Model
{
    use HasFactory;

    protected $table = 'tematk';

    protected $fillable = [
    'tema',
    'kelas',
    'usia',
    'waktu',
    'guru_id',
    'tanggal_mulai',
    'updated_at',   // tambahkan ini supaya bisa mass assign
];


    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function subtema()
    {
        return $this->hasMany(Subtema::class);
    }
}

