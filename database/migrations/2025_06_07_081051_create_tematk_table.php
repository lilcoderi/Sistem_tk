<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tematk', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('tema'); // Tema pembelajaran utama
            $table->string('sub_tema'); // Sub tema dari tema
            $table->string('kelas'); // Kelas (A, B, dll)
            $table->enum('usia', ['4', '5']); // Usia anak
            $table->string('waktu'); // Durasi per minggu
            $table->date('tanggal_mulai');
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade'); // FK ke tabel guru
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tematk');
    }
};
