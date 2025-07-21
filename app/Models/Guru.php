<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'email',
        'nama',
        'nip',
        'kontak',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tematk()
    {
        return $this->hasMany(Tematk::class);
    }

}
