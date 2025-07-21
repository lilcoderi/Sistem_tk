<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = User::role('guru')->get(); // menggunakan Spatie

        foreach ($gurus as $user) {
            Guru::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'nama' => $user->name,
                'nip' => $user->nip ?? null,
                'kontak' => $user->kontak ?? null,
                'photo' => $user->photo ?? null,
            ]);
        }
    }
}
