<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log; // Import Log facade

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        Log::debug('VerifyEmailController: Metode __invoke dipanggil.');
        Log::debug('VerifyEmailController: ID Pengguna: ' . $request->user()->id . ', Email: ' . $request->user()->email);

        // Jika email sudah terverifikasi, langsung redirect ke form.identitas_anak
        if ($request->user()->hasVerifiedEmail()) {
            Log::debug('VerifyEmailController: Email sudah terverifikasi. Mengalihkan secara eksplisit ke form.identitas_anak.');
            // *** PENTING: Menggunakan redirect()->route() secara eksplisit ***
            return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $request->user()->id], false);
        }

        Log::debug('VerifyEmailController: Mencoba menandai email sebagai terverifikasi.');
        if ($request->user()->markEmailAsVerified()) {
            Log::debug('VerifyEmailController: Email berhasil ditandai sebagai terverifikasi. Memicu event Verified.');
            event(new Verified($request->user()));
        } else {
            Log::error('VerifyEmailController: Gagal menandai email sebagai terverifikasi untuk pengguna ' . $request->user()->id);
        }

        // Setelah berhasil verifikasi (atau jika sudah terverifikasi sebelumnya),
        // redirect ke halaman form.identitas_anak
        Log::debug('VerifyEmailController: Mengalihkan secara eksplisit ke form.identitas_anak setelah percobaan verifikasi.');
        // *** PENTING: Menggunakan redirect()->route() secara eksplisit ***
        return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $request->user()->id], false);
    }
}
