<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified; // <--- INI SUDAH DIPERBAIKI
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Models\Pendaftaran; // Import model Pendaftaran

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        Log::debug('VerifyEmailController: Metode __invoke dipanggil.');
        Log::debug('VerifyEmailController: ID Pengguna: ' . $request->user()->id . ', Email: ' . $request->user()->email);

        Log::debug('VerifyEmailController: URL Lengkap yang Diterima: ' . $request->fullUrl());
        Log::debug('VerifyEmailController: Validasi tanda tangan URL: ' . ($request->hasValidSignature() ? 'true' : 'false'));

        if (!$request->hasValidSignature()) {
            Log::error('VerifyEmailController: ERROR - Tanda tangan URL TIDAK valid.');
            // Middleware 'signed' seharusnya sudah menangani 403, tapi ini untuk log konfirmasi.
        }

        // Cek jika email sudah terverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            Log::debug('VerifyEmailController: Email sudah terverifikasi. Mencoba mengalihkan ke form.identitas_anak.');
        } else {
            // Tandai email sebagai terverifikasi
            Log::debug('VerifyEmailController: Mencoba menandai email sebagai terverifikasi.');
            if ($request->user()->markEmailAsVerified()) {
                Log::debug('VerifyEmailController: Email berhasil ditandai sebagai terverifikasi. Memicu event Verified.');
                event(new Verified($request->user()));
            } else {
                Log::error('VerifyEmailController: Gagal menandai email sebagai terverifikasi untuk pengguna ' . $request->user()->id);
            }
        }

        // --- Logika baru untuk mendapatkan id_pendaftaran ---
        $pendaftaranRecord = Pendaftaran::where('user_id', $request->user()->id)->first();

        if ($pendaftaranRecord) {
            $id_pendaftaran_value = $pendaftaranRecord->id_pendaftaran;
            Log::debug('VerifyEmailController: Ditemukan Pendaftaran dengan id_pendaftaran: ' . $id_pendaftaran_value . ' untuk User ID: ' . $request->user()->id);

            if (Route::has('form.identitas_anak')) {
                try {
                    $redirectUrl = route('form.identitas_anak', ['id_pendaftaran' => $id_pendaftaran_value], false);
                    Log::debug('VerifyEmailController: URL Pengalihan yang Dibuat: ' . $redirectUrl);
                    return redirect($redirectUrl);
                } catch (\Exception $e) {
                    Log::error('VerifyEmailController: ERROR saat membuat URL pengalihan untuk form.identitas_anak: ' . $e->getMessage());
                    return redirect('/'); // Fallback jika pembuatan URL gagal
                }
            } else {
                Log::error('VerifyEmailController: ERROR - Rute form.identitas_anak tidak ditemukan!');
                return redirect('/'); // Fallback jika rute tidak ada
            }
        } else {
            // Jika tidak ada record Pendaftaran yang ditemukan untuk user ini
            Log::warning('VerifyEmailController: Tidak ditemukan record Pendaftaran untuk User ID: ' . $request->user()->id . ' setelah verifikasi email. Mengalihkan ke halaman utama.');
            // Anda bisa mengubah ini ke rute di mana user bisa memulai pendaftaran anak
            return redirect('/');
        }
    }
}
