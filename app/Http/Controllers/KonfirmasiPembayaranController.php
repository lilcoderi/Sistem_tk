<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\NotifikasiOrangTua;
use App\Notifications\PaymentStatusUpdated;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class KonfirmasiPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['identitas_anak', 'pendaftaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahun')) {
            $query->whereRaw('SUBSTRING(id_pendaftaran, 4, 4) = ?', [$request->tahun]);
        }

        $pembayaran = $query->latest()->get();
        $statusOptions = ['pending', 'verifikasi', 'ditolak'];

        $tahunOptions = Pembayaran::selectRaw('SUBSTRING(id_pendaftaran, 4, 4) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('kepala_sekolah.siswa.pembayaran.index', compact('pembayaran', 'statusOptions', 'tahunOptions'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['identitas_anak', 'pendaftaran'])->findOrFail($id);
        return view('kepala_sekolah.siswa.pembayaran.detail', compact('pembayaran'));
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::with(['identitas_anak', 'pendaftaran'])->findOrFail($id);
        $statusOptions = ['pending', 'verifikasi', 'ditolak'];
        return view('kepala_sekolah.siswa.pembayaran.edit', compact('pembayaran', 'statusOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verifikasi,ditolak',
        ]);

        $pembayaran = Pembayaran::with(['identitas_anak', 'pendaftaran'])->findOrFail($id);
        $oldStatus = $pembayaran->status;
        $newStatus = $request->status;

        // Log::info() untuk memulai proses debugging
        Log::info('Memulai update status pembayaran', [
            'id_pembayaran' => $id,
            'status_lama' => $oldStatus,
            'status_baru' => $newStatus,
            'id_pendaftaran' => $pembayaran->pendaftaran->id ?? 'N/A'
        ]);

        $pembayaran->update([
            'status' => $newStatus,
        ]);

        // Periksa apakah status benar-benar berubah
        if ($oldStatus !== $newStatus) {
            Log::info('Status pembayaran berubah, memproses notifikasi.');
            
            // Periksa apakah ada user yang terhubung
            $userId = $pembayaran->pendaftaran->user_id ?? null;

            if ($userId) {
                $user = User::find($userId);

                if ($user) {
                    Log::info('User ditemukan, akan mengirim notifikasi.', ['user_id' => $user->id, 'email' => $user->email]);

                    // Kirim notifikasi email hanya jika statusnya 'verifikasi' atau 'ditolak'
                    if (in_array($newStatus, ['verifikasi', 'ditolak'])) {
                        $user->notify(new PaymentStatusUpdated($pembayaran, $oldStatus));
                        Log::info('Notifikasi email berhasil di-queue untuk dikirim.');
                    } else {
                        Log::info('Status baru bukan verifikasi atau ditolak, tidak mengirim notifikasi email.');
                    }
                    
                    // Simpan juga di tabel notifikasi (opsional)
                    $statusText = $newStatus === 'verifikasi' ? 'diterima' : ($newStatus === 'ditolak' ? 'ditolak' : 'diperbarui');
                    NotifikasiOrangTua::create([
                        'user_id' => $user->id,
                        'tipe' => 'pembayaran',
                        'referensi_id' => $pembayaran->id,
                        'pesan' => 'Status pembayaran untuk anak ' . ($pembayaran->identitas_anak->nama_lengkap ?? '-') . ' telah ' . $statusText . '.',
                    ]);
                    Log::info('Notifikasi berhasil disimpan ke tabel NotifikasiOrangTua.');

                } else {
                    Log::warning('User tidak ditemukan untuk ID pendaftaran.', ['user_id' => $userId]);
                }
            } else {
                Log::warning('ID user tidak ditemukan pada pendaftaran ini. Notifikasi tidak dapat dikirim.');
            }
        } else {
            Log::info('Status pembayaran tidak berubah, tidak perlu mengirim notifikasi.');
        }

        return redirect()->route('konfirmasi-pembayaran.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}