<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Pembayaran Pendaftaran TK</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8f8f8; padding: 20px;">

    <div style="max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px;">
        <h2 style="color: #333;">Pembaruan Status Pembayaran</h2>

        <p>Halo {{ $user->name ?? 'Orang Tua/Wali' }},</p>

        <p>Status pembayaran untuk pendaftaran anak Anda 
            <strong>{{ $childName }}</strong> 
            telah {{ $statusText }}.</p>

        <ul>
            <li><strong>Status Sebelumnya:</strong> {{ ucfirst($oldStatus) }}</li>
            <li><strong>Status Saat Ini:</strong> {{ ucfirst($pembayaran->status) }}</li>
        </ul>

        @if(!empty($actionMessage))
            <p>{{ $actionMessage }}</p>
        @endif


        <p style="margin-top: 20px;">Salam hangat,<br><strong>TK Marhamah Hasanah 2</strong></p>
    </div>

</body>
</html>
