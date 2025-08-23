<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        // Pastikan URL ini sesuai dengan domain yang diinginkan
        return url(route('verification.verify', [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ], false));
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->view('emails.verify-email-custom', [
                'actionUrl' => $this->verificationUrl($notifiable),
                'subject'   => 'Verifikasi Email Anda',
                'greeting'  => 'Verifikasi Alamat Email Anda',
            ]);
    }
}
