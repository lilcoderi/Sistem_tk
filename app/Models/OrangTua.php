<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orangtua';
    protected $primaryKey = 'id_orangtua';

    protected $fillable = [
        'id_siswa',
        'nama_ayah', 'nik_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'agama_ayah', 'kewarganegaraan_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'alamat_rumah_ayah', 'no_telepon_ayah',
        'nama_ibu', 'nik_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'agama_ibu', 'kewarganegaraan_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'alamat_rumah_ibu', 'no_telepon_ibu',
    ];

    public function identitas_anak()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa', 'id');
    }

    
}
