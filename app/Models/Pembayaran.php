<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_siswa',
        'id_pendaftaran',
        'tanggal_pembayaran',
        'status',
        'bukti_pembayaran',
    ];

    public function identitas_anak()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa', 'id');
    }
    public function siswa()
    {
        return $this->belongsTo(IdentitasAnak::class, 'id_siswa', 'id');
    }


    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
