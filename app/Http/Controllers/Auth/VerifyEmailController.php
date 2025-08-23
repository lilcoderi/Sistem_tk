<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified; // <--- INI SUDAH DIPERBAIKI
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
        Log::debug('VerifyEmailController: Host & Skema yang Diterima: ' . $request->getSchemeAndHttpHost());
        Log::debug('VerifyEmailController: Path URL yang Diterima: ' . $request->path());
        Log::debug('VerifyEmailController: Query String Diterima: ' . $request->getQueryString());
        Log::debug('VerifyEmailController: Parameter Query Diterima: ' . json_encode($request->query->all()));
        Log::debug('VerifyEmailController: Validasi tanda tangan URL: ' . ($request->hasValidSignature() ? 'true' : 'false'));

        if (!$request->hasValidSignature()) {
            Log::error('VerifyEmailController: ERROR - Tanda tangan URL TIDAK valid.');
        }

        if ($request->user()->hasVerifiedEmail()) {
            Log::debug('VerifyEmailController: Email sudah terverifikasi. Mengalihkan secara eksplisit ke form.identitas_anak.');
            $userId = $request->user()->id;
            Log::debug('VerifyEmailController: userId untuk pengalihan: ' . $userId);

            if ($userId === null) {
                Log::error('VerifyEmailController: ERROR - ID Pengguna NULL saat mencoba redirect ke form.identitas_anak.');
                return redirect('/');
            }

            if (Route::has('form.identitas_anak')) {
                try {
                    $redirectUrl = route('form.identitas_anak', ['id_pendaftaran' => $userId], false);
                    Log::debug('VerifyEmailController: URL Pengalihan yang Dibuat: ' . $redirectUrl);
                    return redirect($redirectUrl);
                } catch (\Exception $e) {
                    Log::error('VerifyEmailController: ERROR saat membuat URL pengalihan untuk form.identitas_anak: ' . $e->getMessage());
                    return redirect('/');
                }
            } else {
                Log::error('VerifyEmailController: ERROR - Rute form.identitas_anak tidak ditemukan!');
                return redirect('/');
            }
        }

        Log::debug('VerifyEmailController: Mencoba menandai email sebagai terverifikasi.');
        if ($request->user()->markEmailAsVerified()) {
            Log::debug('VerifyEmailController: Email berhasil ditandai sebagai terverifikasi. Memicu event Verified.');
            event(new Verified($request->user()));
        } else {
            Log::error('VerifyEmailController: Gagal menandai email sebagai terverifikasi untuk pengguna ' . $request->user()->id);
        }

        Log::debug('VerifyEmailController: Mengalihkan secara eksplisit ke form.identitas_anak setelah percobaan verifikasi.');
        $userId = $request->user()->id;
        Log::debug('VerifyEmailController: userId untuk pengalihan setelah verifikasi: ' . $userId);

        if ($userId === null) {
            Log::error('VerifyEmailController: ERROR - ID Pengguna NULL saat mencoba redirect setelah verifikasi.');
            return redirect('/');
        }

        if (Route::has('form.identitas_anak')) {
            try {
                $redirectUrl = route('form.identitas_anak', ['id_pendaftaran' => $userId], false);
                Log::debug('VerifyEmailController: URL Pengalihan yang Dibuat (setelah verifikasi): ' . $redirectUrl);
                return redirect($redirectUrl);
            } catch (\Exception $e) {
                Log::error('VerifyEmailController: ERROR saat membuat URL pengalihan (setelah verifikasi) untuk form.identitas_anak: ' . $e->getMessage());
                return redirect('/');
            }
        } else {
            Log::error('VerifyEmailController: ERROR - Rute form.identitas_anak tidak ditemukan (setelah verifikasi)!');
            return redirect('/');
        }
    }
}
