<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class CustomVerifyEmail extends BaseVerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        Log::debug('CustomVerifyEmail: Generating verification URL for user ID: ' . $notifiable->getKey() . ' email: ' . $notifiable->getEmailForVerification());
        Log::debug('CustomVerifyEmail: config(\'app.url\') saat ini: ' . config('app.url'));
        Log::debug('CustomVerifyEmail: config(\'app.key\') saat ini: ' . config('app.key'));

        $url = parent::verificationUrl($notifiable);
        Log::debug('CustomVerifyEmail: Generated verification URL: ' . $url);
        return $url;
    }

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
