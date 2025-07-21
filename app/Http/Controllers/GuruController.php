<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    // public function __construct()
    // {
    //     // Batasi akses hanya untuk role kepala sekolah
    //     $this->middleware('role:kepala sekolah');
    // }

    public function index()
    {
        // Mengambil semua data guru sekaligus relasi user-nya
        $gurus = Guru::with('user')->get();
        return view('kepala_sekolah.pengguna.guru.index', compact('gurus'));
    }

    public function create()
    {
        // Ambil user yang punya role guru untuk dropdown user selection
        $users = User::role('guru')->get();
        return view('kepala_sekolah.pengguna.guru.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email',
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:10000',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Guru::create($validated);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        $users = User::role('guru')->get();
        return view('kepala_sekolah.pengguna.guru.edit', compact('guru', 'users'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email',
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:10000',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
            // Jika ingin hapus photo lama bisa tambahkan di sini (optional)
        }

        $guru->update($validated);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        // Hapus file photo jika ada (optional)
        if ($guru->photo && \Storage::disk('public')->exists($guru->photo)) {
            \Storage::disk('public')->delete($guru->photo);
        }

        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function detail($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('kepala_sekolah.pengguna.guru.detail', compact('guru'));
    }

}
