<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    public $incrementing = false; // ← Penting!
    protected $keyType = 'string'; // ← Penting juga

    protected $fillable = [
        'id_pendaftaran', // ← tambahkan ini
        'user_id',
        'tanggal_pendaftaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi untuk mendapatkan form berikutnya yang harus diisi
    // app/Models/Pendaftaran.php

public function getNextIncompleteForm()
{
    // Urutkan step sesuai urutan pendaftaran
    if (!$this->identitas_anak_completed) {
        return 'form.identitas_anak';
    }

    if (!$this->identitas_orangtua_completed) {
        return 'orangtua.create';
    }

    if (!$this->keadaan_anak_completed) {
        return 'keadaan_anak.create';
    }

    if (!$this->keadaan_jasmani_completed) {
        return 'keadaan_jasmani.create';
    }

    if (!$this->dokumen_completed) {
        return 'dokumen.create';
    }

    if (!$this->pembayaran_completed) {
        return 'pembayaran.create';
    }

    // Semua step sudah lengkap
    return null;
}

}
