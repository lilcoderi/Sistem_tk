<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran; // Import model Pendaftaran

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
            // Jika sudah terverifikasi, cari id_pendaftaran dan redirect
            $pendaftaranRecord = Pendaftaran::where('user_id', $request->user()->id)->first();
            if ($pendaftaranRecord) {
                $id_pendaftaran_value = $pendaftaranRecord->id_pendaftaran;
                Log::debug('EmailVerificationNotificationController: Mengalihkan pengguna terverifikasi ke form.identitas_anak dengan id_pendaftaran: ' . $id_pendaftaran_value);
                return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $id_pendaftaran_value], false);
            } else {
                Log::warning('EmailVerificationNotificationController: Pengguna terverifikasi ' . $request->user()->id . ' tidak memiliki record Pendaftaran. Mengalihkan ke halaman utama.');
                return redirect('/'); // Fallback
            }
        }

        $request->user()->sendEmailVerificationNotification();
        Log::debug('EmailVerificationNotificationController: Notifikasi verifikasi email baru telah dikirimkan.');

        return back()->with('status', 'verification-link-sent');
    }
}
