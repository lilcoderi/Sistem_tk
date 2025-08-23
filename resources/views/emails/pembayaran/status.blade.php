@component('mail::message')
# Konfirmasi Pembayaran Pendaftaran TK

Halo {{ $pembayaran->nama_siswa }},

Pembayaran pendaftaran TK Anda telah kami terima dengan status: **{{ ucfirst($pembayaran->status) }}**.

Tanggal Pembayaran: {{ $pembayaran->tanggal_pembayaran }}

@component('mail::button', ['url' => url('/status-pendaftaran/'.$pembayaran->id)])
Lihat Detail
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
