<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class JalankanSistemPakar extends Command
{
    protected $signature = 'sistem-pakar:jalankan';
    protected $description = 'Menjalankan sistem pakar prediksi awal dan menyimpan hasilnya ke database';

    public function handle()
    {
        $this->info("Menjalankan sistem pakar...");

        $pythonPath = base_path('venv/Scripts/python.exe');
        $scriptPath = base_path('prediksi_awal.py');

        $process = new Process([$pythonPath, $scriptPath]);

        $process->run();

        if (!$process->isSuccessful()) {
            $this->error('Gagal menjalankan sistem pakar.');
            throw new ProcessFailedException($process);
        }

        $this->info("✅ Sistem pakar selesai dijalankan dan hasil tersimpan.");
    }
}
