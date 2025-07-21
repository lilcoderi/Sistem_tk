<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detail_asesmen', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('modulajar_id');
            $table->enum('skala_nilai', ['BB', 'MB', 'BSH', 'BSB']);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_asesmen')->references('id')->on('asesmen')->onDelete('cascade');
            $table->foreign('modulajar_id')->references('id')->on('modul_ajar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_asesmen');
    }
};
