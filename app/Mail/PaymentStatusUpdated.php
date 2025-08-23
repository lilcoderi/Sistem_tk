<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $pembayaran;

    /**
     * Create a new message instance.
     */
    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Konfirmasi Pembayaran Pendaftaran TK')
                    ->markdown('emails.pembayaran.status')
                    ->with([
                        'pembayaran' => $this->pembayaran
                    ]);
    }
}
