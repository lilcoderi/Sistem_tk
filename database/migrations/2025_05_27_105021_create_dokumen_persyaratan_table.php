<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumen_persyaratan', function (Blueprint $table) {
            $table->id();
    
            // Tambahkan kolom foreign key
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_pendaftaran');
    
            $table->string('akta_kelahiran')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('ktp_orang_tua')->nullable();
            $table->timestamps();

            // Tambahkan constraint foreign key
            $table->foreign('id_siswa')
                ->references('id')->on('identitas_anak')
                ->onDelete('cascade');

            $table->foreign('id_pendaftaran')
                ->references('id_pendaftaran')->on('pendaftaran')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_persyaratan');
    }
};
