<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Username salah atau password salah.');
        }

        $request->session()->regenerate();

        return $this->redirectToDashboard();
    }

    protected function redirectToDashboard()
    {
        $user = Auth::user();

        if ($user->hasRole('kepala sekolah')) {
            return redirect()->route('kepala_sekolah.dashboard');
        }

        if ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        }

        if ($user->hasRole('orang tua')) {
            $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

            if (!$pendaftaran) {
                Auth::logout();
                return redirect()->route('register')->withErrors(['Anda harus mendaftar terlebih dahulu.']);
            }

            // Jika belum ada pembayaran, arahkan ke form terakhir
            $pembayaran = Pembayaran::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();

            if (!$pembayaran) {
                $nextFormRoute = $pendaftaran->getNextIncompleteForm();

                if ($nextFormRoute) {
                    return redirect()->route($nextFormRoute, ['id_pendaftaran' => $pendaftaran->id_pendaftaran])
                        ->with('warning', 'Silakan lengkapi pendaftaran Anda terlebih dahulu.');
                }

                // Jika semua form lengkap tapi belum bayar
                return redirect()->route('pembayaran.create', ['id_pendaftaran' => $pendaftaran->id_pendaftaran])
                    ->with('warning', 'Silakan unggah bukti pembayaran terlebih dahulu.');
            }

            // Pembayaran sudah ada
            return redirect()->route('orang_tua.dashboard');
        }

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
