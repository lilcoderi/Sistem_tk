<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->view('emails.verify-email-custom', [
                'actionUrl' => $verificationUrl,
                'subject'   => 'Verifikasi Email Anda',
                'greeting'  => 'Verifikasi Alamat Email Anda',
            ]);
    }
}
