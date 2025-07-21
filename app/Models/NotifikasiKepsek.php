<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiKepsek extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_kepsek';

    protected $fillable = [
        'tipe',
        'pesan',
        'dibaca',
    ];
}