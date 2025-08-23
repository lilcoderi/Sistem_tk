<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // Import Log facade
use App\Models\Pendaftaran; // Import model Pendaftaran

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        Log::debug('EmailVerificationPromptController: Metode __invoke dipanggil.');
        Log::debug('EmailVerificationPromptController: Pengguna ' . $request->user()->id . ' sudah terverifikasi: ' . ($request->user()->hasVerifiedEmail() ? 'true' : 'false'));

        if ($request->user()->hasVerifiedEmail()) {
            // Jika sudah terverifikasi, cari id_pendaftaran dan redirect
            $pendaftaranRecord = Pendaftaran::where('user_id', $request->user()->id)->first();
            if ($pendaftaranRecord) {
                $id_pendaftaran_value = $pendaftaranRecord->id_pendaftaran;
                Log::debug('EmailVerificationPromptController: Mengalihkan pengguna terverifikasi ke form.identitas_anak dengan id_pendaftaran: ' . $id_pendaftaran_value);
                return redirect()->route('form.identitas_anak', ['id_pendaftaran' => $id_pendaftaran_value], false);
            } else {
                Log::warning('EmailVerificationPromptController: Pengguna terverifikasi ' . $request->user()->id . ' tidak memiliki record Pendaftaran. Mengalihkan ke halaman utama.');
                return redirect('/'); // Fallback
            }
        }

        return view('auth.verify-email-standalone');
    }
}
