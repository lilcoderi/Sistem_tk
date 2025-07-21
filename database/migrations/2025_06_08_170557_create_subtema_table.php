<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtemaTable extends Migration
{
    public function up()
    {
        Schema::create('subtema', function (Blueprint $table) {
            $table->id(); // Primary key (auto increment)
            $table->string('sub_tema'); // Sub tema dari tema
            $table->date('tanggal_mulai'); // Tanggal mulai
            $table->string('waktu'); // Durasi per minggu
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade'); // FK ke tabel guru
            $table->foreignId('tema_id')->constrained('tematk')->onDelete('cascade'); // FK ke tabel tematk
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subtema');
    }
}
