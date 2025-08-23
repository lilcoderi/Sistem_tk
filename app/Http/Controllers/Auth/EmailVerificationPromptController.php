<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // Import Log facade

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Debugging: Catat saat controller ini dipanggil
        Log::debug('EmailVerificationPromptController: Metode __invoke dipanggil.');
        Log::debug('EmailVerificationPromptController: Pengguna ' . $request->user()->id . ' sudah terverifikasi: ' . ($request->user()->hasVerifiedEmail() ? 'true' : 'false'));

        return $request->user()->hasVerifiedEmail()
                                ? redirect()->intended(route('form.identitas_anak', ['id_pendaftaran' => $request->user()->id], absolute: false)) // Ubah ke route 'form.identitas_anak'
                                : view('auth.verify-email-standalone');
    }
}
