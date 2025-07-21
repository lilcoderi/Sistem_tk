<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lingkup_perkembangan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama_lingkup'); // Misal: Motorik, Sosial Emosional, dll
            $table->string('aturan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lingkup_perkembangan');
    }
};
