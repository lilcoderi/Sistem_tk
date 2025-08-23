<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            font-size: 20px;
            color: #111827;
            text-align: center;
            margin-bottom: 16px;
        }
        p {
            font-size: 14px;
            color: #374151;
            line-height: 1.5;
            text-align: center;
            margin-bottom: 24px;
        }
        .btn {
            display: block;
            text-align: center;
            background-color: #4f46e5;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin: 0 auto;
            width: fit-content;
        }
        .btn:hover {
            background-color: #4338ca;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifikasi Alamat Email Anda</h1>
        <p>Terima kasih telah mendaftar di TK Marhamah Hasanah 2! Klik tombol di bawah ini untuk memverifikasi alamat email Anda.</p>
        <a href="{{ $actionUrl }}" class="btn">Verifikasi Email</a>
        <p>Jika Anda tidak mendaftar, abaikan email ini.</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
