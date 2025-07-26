<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsesmenAnekdot;
use App\Models\IdentitasAnak;
use App\Models\LingkupPerkembangan;
use App\Models\Subtema;
use App\Models\NotifikasiOrangTua;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Api\Upload\UploadApi;

class AsesmenAnekdotController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua subtema (untuk opsi filter)
        $subtemaList = Subtema::with('tematk')->get();

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
            'siswa_id'           => 'required|exists:identitas_anak,id',
            'lingkup_id'         => 'required|exists:lingkup_perkembangan,id',
            'subtema_id'         => 'required|exists:subtema,id',
            'tanggal_pelaksanaan'=> 'required|date',
            'keterangan'         => 'nullable|string',
            'dokumentasi_foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // ✅ Upload ke Cloudinary
        if ($request->hasFile('dokumentasi_foto')) {
            $uploadedFile = (new UploadApi())->upload(
                $request->file('dokumentasi_foto')->getRealPath(),
                [
                    'folder' => 'dokumentasi_anekdot'
                ]
            );
            $validated['dokumentasi_foto'] = $uploadedFile['secure_url'];
        }

        $asesmen = AsesmenAnekdot::create($validated);

        // Kirim notifikasi ke orang tua
        $siswa = $asesmen->siswa;
        $pendaftaran = $siswa->pendaftaran()->whereNotNull('user_id')->first();

        if ($pendaftaran) {
            NotifikasiOrangTua::create([
                'user_id'       => $pendaftaran->user_id,
                'tipe'          => 'asesmen_anekdot',
                'referensi_id'  => $asesmen->id,
                'pesan'         => 'Asesmen anekdot baru untuk anak ' . $siswa->nama_lengkap . ' telah ditambahkan.',
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
            'siswa_id'           => 'required|exists:identitas_anak,id',
            'lingkup_id'         => 'required|exists:lingkup_perkembangan,id',
            'subtema_id'         => 'required|exists:subtema,id',
            'tanggal_pelaksanaan'=> 'required|date',
            'keterangan'         => 'nullable|string',
            'dokumentasi_foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $item = AsesmenAnekdot::findOrFail($id);

        // ✅ Upload ulang jika ada foto baru
        if ($request->hasFile('dokumentasi_foto')) {
            $uploadedFile = (new UploadApi())->upload(
                $request->file('dokumentasi_foto')->getRealPath(),
                [
                    'folder' => 'dokumentasi_anekdot'
                ]
            );
            $validated['dokumentasi_foto'] = $uploadedFile['secure_url'];
        }

        $item->update($validated);
        return redirect()->route('asesmen.anekdot.index')->with('success', 'Asesmen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = AsesmenAnekdot::findOrFail($id);
        // Kalau mau hapus juga dari Cloudinary, simpan public_id saat upload lalu panggil UploadApi()->destroy()
        $item->delete();
        return redirect()->route('asesmen.anekdot.index')->with('success', 'Asesmen berhasil dihapus.');
    }

    public function profilAnekdotOrangtua()
    {
        $userId = Auth::id();

        $anak = IdentitasAnak::whereHas('pendaftaran', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->pluck('id');

        $data = AsesmenAnekdot::with(['siswa', 'lingkup', 'subtema.tematk'])
            ->whereIn('siswa_id', $anak)
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

        return view('orang_tua.siswa.kegiatan.index', compact('data'));
    }
}
