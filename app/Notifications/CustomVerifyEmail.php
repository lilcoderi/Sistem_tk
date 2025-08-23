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
        // Debugging: Catat notifiable properties
        Log::debug('CustomVerifyEmail: Generating verification URL for user ID: ' . $notifiable->getKey() . ' email: ' . $notifiable->getEmailForVerification());

        // Gunakan metode parent untuk menghasilkan URL yang ditandatangani dengan benar
        // Ini akan memanggil URL::temporarySignedRoute secara internal.
        $url = parent::verificationUrl($notifiable);

        // Debugging: Catat URL yang dihasilkan
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
        // Pastikan Anda memanggil verificationUrl() untuk mendapatkan URL yang benar
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
