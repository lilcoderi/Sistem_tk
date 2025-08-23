<x-guest-layout>
    <div style="width: 100%; max-width: 450px; text-align: center;">
        <div style="margin-bottom: 24px;">
            <a href="/">
                <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo" style="max-width: 150px; height: auto; display: block; margin: 0 auto;">
            </a>
        </div>
        <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); padding: 40px; width: 100%;">
            <h1 style="font-size: 20px; font-weight: 600; color: #1f2937; margin-bottom: 16px;">Verifikasi Alamat Email Anda</h1>
            <p style="font-size: 14px; color: #6b7280; line-height: 1.6; margin-bottom: 24px;">
                Terima kasih telah mendaftar! Sebelum memulai, tolong verifikasi alamat email Anda dengan mengklik tautan yang sudah kami kirimkan. Jika Anda belum menerima email, kami akan dengan senang hati mengirimkan yang baru.
            </p>
            @if (session('status') == 'verification-link-sent')
                <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                    Tautan verifikasi baru telah dikirimkan ke alamat email Anda.
                </div>
            @endif
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" style="background-color: #4f46e5; color: #ffffff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; font-size: 14px; width: 100%; box-sizing: border-box;">Kirim Ulang Email Verifikasi</button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="font-size: 14px; color: #6b7280; text-decoration: underline; border: none; background: none; cursor: pointer; text-align: left; padding: 0; margin-top: 16px;">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>