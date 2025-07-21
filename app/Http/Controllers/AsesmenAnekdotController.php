<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsesmenAnekdot;
use App\Models\IdentitasAnak;
use App\Models\LingkupPerkembangan;
use App\Models\Subtema;
use App\Models\NotifikasiOrangTua;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AsesmenAnekdotController extends Controller
{
    public function index(Request $request)
{
    // Ambil semua subtema (untuk opsi filter)
    $subtemaList = \App\Models\Subtema::with('tematk')->get();

    // Filter
    $query = AsesmenAnekdot::with(['siswa', 'lingkup', 'subtema.tematk']);
    $kelas = $request->kelas ?? 'A'; 

    if ($request->filled('subtema_id')) {
        $query->where('subtema_id', $request->subtema_id);
    }

    if ($request->filled('kelas')) {
        $query->whereHas('subtema.tematk', function ($q) use ($request) {
            $q->where('kelas', $request->kelas);
        });
    }

    $data = $query->orderBy('tanggal_pelaksanaan', 'desc')->get();

    return view('kepala_sekolah.penilaian.asesmen_anekdot.index', compact('data', 'subtemaList'));
}


    public function create()
    {
        $siswa = IdentitasAnak::all();
        $lingkup = LingkupPerkembangan::all();
        $subtema = Subtema::with('tematk')->get();
        return view('kepala_sekolah.penilaian.asesmen_anekdot.create', compact('siswa', 'lingkup', 'subtema'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'siswa_id' => 'required|exists:identitas_anak,id',
        'lingkup_id' => 'required|exists:lingkup_perkembangan,id',
        'subtema_id' => 'required|exists:subtema,id',
        'tanggal_pelaksanaan' => 'required|date',
        'keterangan' => 'nullable|string',
        'dokumentasi_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('dokumentasi_foto')) {
        $validated['dokumentasi_foto'] = $request->file('dokumentasi_foto')->store('dokumentasi_anekdot', 'public');
    }

    $asesmen = AsesmenAnekdot::create($validated);

    // Ambil user_id orang tua dari relasi siswa -> pendaftaran
    $siswa = $asesmen->siswa;
    $pendaftaran = $siswa->pendaftaran()->whereNotNull('user_id')->first();

    if ($pendaftaran) {
        NotifikasiOrangTua::create([
            'user_id' => $pendaftaran->user_id,
            'tipe' => 'asesmen_anekdot',
            'referensi_id' => $asesmen->id,
            'pesan' => 'Asesmen anekdot baru untuk anak ' . $siswa->nama_lengkap . ' telah ditambahkan.',
        ]);
    }

    return redirect()->route('asesmen.anekdot.index')->with('success', 'Asesmen berhasil ditambahkan.');
}


    public function show($id)
    {
        $item = AsesmenAnekdot::with(['siswa', 'lingkup', 'subtema'])->findOrFail($id);
        return view('kepala_sekolah.penilaian.asesmen_anekdot.detail', compact('item'));
    }

    public function edit($id)
    {
        $item = AsesmenAnekdot::findOrFail($id);
        $siswa = IdentitasAnak::all();
        $lingkup = LingkupPerkembangan::all();
        $subtema = Subtema::with('tematk')->get();
        return view('kepala_sekolah.penilaian.asesmen_anekdot.edit', compact('item', 'siswa', 'lingkup', 'subtema'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:identitas_anak,id',
            'lingkup_id' => 'required|exists:lingkup_perkembangan,id',
            'subtema_id' => 'required|exists:subtema,id',
            'tanggal_pelaksanaan' => 'required|date',
            'keterangan' => 'nullable|string',
            'dokumentasi_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $item = AsesmenAnekdot::findOrFail($id);

        if ($request->hasFile('dokumentasi_foto')) {
            if ($item->dokumentasi_foto) {
                Storage::disk('public')->delete($item->dokumentasi_foto);
            }
            $validated['dokumentasi_foto'] = $request->file('dokumentasi_foto')->store('dokumentasi_anekdot', 'public');
        }

        $item->update($validated);
        return redirect()->route('asesmen.anekdot.index')->with('success', 'Asesmen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = AsesmenAnekdot::findOrFail($id);
        if ($item->dokumentasi_foto) {
            Storage::disk('public')->delete($item->dokumentasi_foto);
        }
        $item->delete();
        return redirect()->route('asesmen.anekdot.index')->with('success', 'Asesmen berhasil dihapus.');
    }

    public function profilAnekdotOrangtua()
{
    $userId = Auth::id();

    // Ambil siswa berdasarkan user yang login
    $anak = \App\Models\IdentitasAnak::whereHas('pendaftaran', function ($q) use ($userId) {
        $q->where('user_id', $userId);
    })->pluck('id'); // Ambil hanya ID-nya

    // Ambil data asesmen untuk anak tersebut
    $data = AsesmenAnekdot::with(['siswa', 'lingkup', 'subtema.tematk'])
        ->whereIn('siswa_id', $anak)
        ->orderBy('tanggal_pelaksanaan', 'desc')
        ->get();

    return view('orang_tua.siswa.kegiatan.index', compact('data'));
}
}
