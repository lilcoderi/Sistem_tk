<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('modul_ajar', function (Blueprint $table) {
            $table->id(); // Primary Key

            // Foreign Keys
            $table->foreign('subtema_id')->references('id')->on('subtema')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lingkup_id')->constrained('lingkup_perkembangan')->onDelete('cascade');

            $table->text('rencana_pembelajaran'); // Rencana kegiatan ajar
            $table->enum('ceklis_anekdot', ['Ceklis', 'Anekdot']); // Enum pilihan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modul_ajar');
    }
};
