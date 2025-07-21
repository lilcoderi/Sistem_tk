<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NotifikasiKepsek;
use App\Models\Pendaftaran;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    private function generateIdPendaftaran(): string
{
    $year = now()->format('Y');
    $prefix = 'PDK' . $year . '-';

    $last = Pendaftaran::where('id_pendaftaran', 'like', $prefix . '%')
        ->orderBy('id_pendaftaran', 'desc')
        ->value('id_pendaftaran');

    if ($last) {
        $lastNumber = (int) substr($last, -3);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }

    return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
}


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tambahkan role 'orang tua'
        $user->assignRole('orang tua');

        // Simpan data ke tabel pendaftaran (user_id + tanggal hari ini)
        $pendaftaran = Pendaftaran::create([
            'id_pendaftaran' => $this->generateIdPendaftaran(),
    'user_id' => $user->id,
    'tanggal_pendaftaran' => now()->toDateString(),
        ]);

         // ✅ Tambahkan notifikasi ke kepala sekolah
    NotifikasiKepsek::create([
        'tipe' => 'pendaftaran',
        'pesan' => "Pendaftaran baru dari: {$user->name} ({$user->email})",
        'dibaca' => false,
    ]);
        // Trigger event Laravel
        event(new Registered($user));

        // Login user langsung
        Auth::login($user);

        // Redirect ke form identitas anak dengan id_pendaftaran
        return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $pendaftaran->id_pendaftaran]);
    }
}