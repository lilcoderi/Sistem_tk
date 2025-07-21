<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_pendaftaran');
            $table->date('tanggal_pembayaran')->nullable();
            $table->enum('status', ['pending', 'verifikasi', 'ditolak'])->default('pending');
            $table->string('bukti_pembayaran');
            $table->timestamps();

            $table->foreign('id_siswa')->references('id')->on('identitas_anak')->onDelete('cascade');
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
