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

        // --- DEBUGGING TANDA TANGAN URL LEBIH DETAIL ---
        Log::debug('VerifyEmailController: URL Lengkap yang Diterima: ' . $request->fullUrl());
        Log::debug('VerifyEmailController: Host & Skema yang Diterima: ' . $request->getSchemeAndHttpHost());
        Log::debug('VerifyEmailController: Path URL yang Diterima: ' . $request->path());
        Log::debug('VerifyEmailController: Query String Diterima: ' . $request->getQueryString());
        Log::debug('VerifyEmailController: Parameter Query Diterima: ' . json_encode($request->query->all()));
        Log::debug('VerifyEmailController: Validasi tanda tangan URL: ' . ($request->hasValidSignature() ? 'true' : 'false'));
        // --- AKHIR DEBUGGING TANDA TANGAN URL ---

        if (!$request->hasValidSignature()) {
            Log::error('VerifyEmailController: ERROR - Tanda tangan URL TIDAK valid.');
            // Middleware 'signed' seharusnya sudah menangani 403, tapi ini untuk log konfirmasi.
            // Anda bisa tambahkan redirect khusus di sini jika ingin penanganan 403 yang berbeda.
        }

        if ($request->user()->hasVerifiedEmail()) {
            Log::debug('VerifyEmailController: Email sudah terverifikasi. Mengalihkan secara eksplisit ke form.identitas_anak.');
            return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $request->user()->id], false);
        }

        Log::debug('VerifyEmailController: Mencoba menandai email sebagai terverifikasi.');
        if ($request->user()->markEmailAsVerified()) {
            Log::debug('VerifyEmailController: Email berhasil ditandai sebagai terverifikasi. Memicu event Verified.');
            event(new Verified($request->user()));
        } else {
            Log::error('VerifyEmailController: Gagal menandai email sebagai terverifikasi untuk pengguna ' . $request->user()->id);
        }

        Log::debug('VerifyEmailController: Mengalihkan secara eksplisit ke form.identitas_anak setelah percobaan verifikasi.');
        return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $request->user()->id], false);
    }
}