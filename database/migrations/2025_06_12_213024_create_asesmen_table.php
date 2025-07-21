<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id('id_asesmen'); // Primary Key
            $table->unsignedBigInteger('id_siswa'); // FK ke identitas_anak
            $table->unsignedBigInteger('id_subtema'); // FK ke subtema
            $table->unsignedBigInteger('id_guru'); // FK ke guru
            $table->string('semester', 10);
            $table->string('tahun_ajar', 9);
            $table->enum('tipe_penilaian', ['anekdot', 'ceklis']);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_siswa')->references('id')->on('identitas_anak')->onDelete('cascade');
            $table->foreign('id_subtema')->references('id')->on('subtema')->onDelete('cascade');
            $table->foreign('id_guru')->references('id')->on('guru')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen');
    }
};
