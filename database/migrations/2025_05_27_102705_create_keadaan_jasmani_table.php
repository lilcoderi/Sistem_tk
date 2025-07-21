<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeadaanJasmaniTable extends Migration
{
    public function up()
    {
        Schema::create('keadaan_jasmani', function (Blueprint $table) {
            $table->id('id_keadaan_jasmani');
            $table->unsignedBigInteger('id_siswa');
        
            $table->string('keadaan_waktu_kandungan');
            $table->string('keadaan_waktu_dilahirkan');
            $table->string('anak_disusui_asi');
            $table->string('makanan_tambahan');
            $table->text('kelainan_cacat_yang_diderita')->nullable();
            $table->string('cara_anak_minum_susu');
            $table->string('apakah_masih_pakai_diaper');
        
            $table->foreign('id_siswa')->references('id')->on('identitas_anak')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keadaan_jasmani');
    }
}