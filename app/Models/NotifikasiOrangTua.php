<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifikasiOrangTua extends Model
{
    protected $table = 'notifikasi_orang_tua';

    protected $fillable = [
        'user_id',
        'tipe',
        'referensi_id',
        'pesan',
        'dibaca',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
