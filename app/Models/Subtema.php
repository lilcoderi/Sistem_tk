<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtema extends Model
{
    use HasFactory;

    protected $table = 'subtema';

    protected $fillable = [
        'sub_tema',
        'tanggal_mulai',
        'waktu',
        'tema_id',
    ];


    // Relasi ke Tematk (tema)
    public function tematk()
    {
        return $this->belongsTo(Tematk::class, 'tema_id');
    }
}
