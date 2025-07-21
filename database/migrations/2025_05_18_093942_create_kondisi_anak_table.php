<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kondisi_anak', function (Blueprint $table) {
            $table->id('id_kondisi');
            $table->unsignedBigInteger('id_siswa');

            $table->string('rumah_waktu_masuk_tk');
            $table->integer('jumlah_penghuni_rumah'); // perbaikan nama kolom
            $table->string('pergaulan_dengan_teman');
            $table->string('nafsu_makan'); // perbaikan typo
            $table->string('pagi_hari');
            $table->string('siang_hari');
            $table->string('malam_hari');
            $table->string('hubungan_dengan_ayah');
            $table->string('hubungan_dengan_ibu')->nullable();
            $table->string('kebersihan_buang_air');

            $table->time('tidur_siang_mulai')->nullable();
            $table->time('tidur_siang_selesai')->nullable();
            $table->time('tidur_malam_mulai')->nullable();
            $table->time('tidur_malam_selesai')->nullable();

            $table->text('hal_lain_waktu_tidur')->nullable();
            $table->text('sikap_anak_dirumah');
            $table->string('keadaan_anak_waktu_dalam_kandungan')->nullable();
            $table->string('keadaan_anak_waktu_dilahirkan')->nullable();
            $table->string('disusui_asi')->nullable();
            $table->string('makanan_tambahan')->nullable();
            $table->string('kelainan_cacat_tubuh')->nullable();
            $table->string('cara_anak_minum_susu')->nullable();
            $table->string('apakah_masih_pakai_diaper')->nullable();
            $table->text('penyakit_pernah_diderita')->nullable();
            $table->text('imunisasi_pernah_diterima')->nullable();

            $table->foreign('id_siswa')->references('id_siswa')->on('identitas_anak')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kondisi_anak');
    }
};
