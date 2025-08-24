<?php

namespace App\Notifications;

// Hapus 'Illuminate\Contracts\Queue\ShouldQueue' dan 'Illuminate\Bus\Queueable'
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pembayaran;

class PaymentStatusUpdated extends Notification
{
    // Hapus 'use Queueable;'
    // use Queueable;

    protected $pembayaran;
    protected $oldStatus;

    /**
     * Buat instance notifikasi baru.
     */
    public function __construct(Pembayaran $pembayaran, string $oldStatus)
    {
        $this->pembayaran = $pembayaran;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Tentukan saluran notifikasi.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Kirim notifikasi via email dengan custom view.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = match ($this->pembayaran->status) {
            'verifikasi' => 'telah berhasil diverifikasi',
            'ditolak' => 'ditolak',
            default => 'diperbarui ke ' . $this->pembayaran->status,
        };

        $actionMessage = match ($this->pembayaran->status) {
            'verifikasi' => 'Anda sekarang dapat melihat detail pendaftaran lengkap dan status pembayaran terbaru di akun Anda.',
            'ditolak' => 'Mohon periksa kembali detail pembayaran Anda atau hubungi admin jika Anda memiliki pertanyaan.',
            default => '',
        };

        $childName = $this->pembayaran->identitas_anak->nama_lengkap ?? 'Siswa';

        return (new MailMessage)
            ->subject('Pembaruan Status Pembayaran: ' . ucfirst($this->pembayaran->status))
            ->view('emails.payment-status', [
                'user' => $notifiable,
                'childName' => $childName,
                'pembayaran' => $this->pembayaran,
                'oldStatus' => $this->oldStatus,
                'statusText' => $statusText,
                'actionMessage' => $actionMessage,
                'pembayaranLink' => url('/pembayaran/' . $this->pembayaran->id),
            ]);
    }

    /**
     * Representasi array dari notifikasi.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pembayaran_id' => $this->pembayaran->id,
            'status_lama' => $this->oldStatus,
            'status_baru' => $this->pembayaran->status,
            'pesan' => 'Status pembayaran pendaftaran anak ' .
                ($this->pembayaran->identitas_anak->nama_lengkap ?? 'Anda') .
                ' telah diperbarui menjadi ' . $this->pembayaran->status . '.',
        ];
    }
}