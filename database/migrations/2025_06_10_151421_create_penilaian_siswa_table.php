<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianSiswaTable extends Migration
{
    public function up()
    {
        Schema::create('penilaian_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('tematk_id');
            $table->unsignedBigInteger('modulajar_id');
            $table->string('tahunajar', 10);
            $table->enum('tipe_penilaian', ['ceklis', 'anekdot']);
            $table->enum('penilaian', ['BB', 'MB', 'BSH', 'BSB']);
            $table->timestamps();

            // Foreign keys
            $table->foreign('siswa_id')->references('id')->on('identitas_anak')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
            $table->foreign('tematk_id')->references('id')->on('tematk')->onDelete('cascade');
            $table->foreign('modulajar_id')->references('id')->on('modul_ajar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_siswa');
    }
}
