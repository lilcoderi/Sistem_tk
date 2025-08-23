<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Tambahkan untuk debugging

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::debug('EmailVerificationNotificationController: Metode store dipanggil.');
        Log::debug('EmailVerificationNotificationController: Pengguna ' . $request->user()->id . ' sudah terverifikasi: ' . ($request->user()->hasVerifiedEmail() ? 'true' : 'false'));

        if ($request->user()->hasVerifiedEmail()) {
            Log::debug('EmailVerificationNotificationController: Email sudah terverifikasi. Mengalihkan secara eksplisit ke form.identitas_anak.');
            // Mengarahkan ke form.identitas_anak jika sudah terverifikasi
            return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $request->user()->id], false);
        }

        $request->user()->sendEmailVerificationNotification();
        Log::debug('EmailVerificationNotificationController: Notifikasi verifikasi email baru telah dikirimkan.');

        return back()->with('status', 'verification-link-sent');
    }
}
