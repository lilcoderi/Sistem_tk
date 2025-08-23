<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        Log::debug('CustomVerifyEmail: Generating verification URL for user ID: ' . $notifiable->getKey() . ' email: ' . $notifiable->getEmailForVerification());
        
        // Dapatkan APP_URL yang digunakan oleh Laravel saat ini
        Log::debug('CustomVerifyEmail: config(\'app.url\') saat ini: ' . config('app.url'));
        Log::debug('CustomVerifyEmail: config(\'app.key\') saat ini: ' . config('app.key'));

        // Pastikan APP_FORCE_HTTPS diaktifkan jika aplikasi Anda menggunakan HTTPS di belakang proxy
        // if (env('APP_ENV') === 'production' && env('APP_FORCE_HTTPS', false)) {
        //     URL::forceScheme('https');
        //     Log::debug('CustomVerifyEmail: forceScheme(\'https\') diterapkan.');
        // }

        $url = parent::verificationUrl($notifiable);
        Log::debug('CustomVerifyEmail: Generated verification URL: ' . $url);
        return $url;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $actionUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->view('emails.verify-email-custom', [
                'actionUrl' => $actionUrl,
                'subject'   => 'Verifikasi Email Anda',
                'greeting'  => 'Verifikasi Alamat Email Anda',
            ]);
    }
}
