<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasAnak extends Model
{
    use HasFactory;

    protected $table = 'identitas_anak';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pendaftaran',
        'nama_lengkap',
        'nama_panggilan',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_rumah',
        'agama',
        'kelompok',
        'jumlah_saudara',
        'anak_ke',
        'bahasa_sehari_hari',
        'golongan_darah',
        'ciri_khusus',
        'id_pendaftaran',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    public function orangtua()
{
    return $this->hasOne(OrangTua::class, 'id_siswa', 'id');
}

public function kondisiAnak()
{
    return $this->hasOne(KondisiAnak::class, 'id_siswa', 'id');
}

public function keadaanJasmani()
{
    return $this->hasOne(KeadaanJasmani::class, 'id_siswa', 'id');
}

public function dokumenPersyaratan()
{
    return $this->hasOne(DokumenPersyaratan::class, 'id_siswa', 'id');
}

public function hasil_prediksi_awal()
{
    return $this->hasOne(HasilPrediksiAwal::class, 'id_siswa', 'id');
}

public function ddtk()
{
    return $this->hasOne(Ddtk::class, 'id_siswa');
}

public function tumbuh()
{
    return $this->hasMany(TumbuhKembang::class, 'id_siswa');
}

public function rapor()
{
    return $this->hasOne(Rapor::class, 'id_siswa', 'id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}



}