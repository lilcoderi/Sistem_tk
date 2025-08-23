<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            /* Menggunakan gambar sebagai background */
            background-image: url('{{ asset('assets/img/marhas2.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .logo {
            margin-bottom: 12px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
            display: block;
            margin-left: 146px;
            margin-bottom: 30px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 40px;
            width: 100%;
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
        }
        
        .card-text {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .button, .resend-button {
            background-color: #4f46e5;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .button:hover, .resend-button:hover {
            background-color: #4338ca;
        }

        .logout-link {
            font-size: 14px;
            color: #6b7280;
            text-decoration: underline;
            border: none;
            background: none;
            cursor: pointer;
            text-align: left;
            padding: 0;
            margin-top: 16px;
        }

        .logout-link:hover {
            color: #1f2937;
        }
    </style>
</head>
<body>
    <div class="container">
        

        <div class="card">
            <div class="logo">
            <img src="{{ asset('assets/img/favicon.png') }}" alt="Logo">
        </div>
            <h1 class="card-title">Verifikasi Alamat Email Anda</h1>
            
            <p class="card-text">
                Terima kasih telah mendaftar! Sebelum memulai, tolong verifikasi alamat email Anda dengan mengklik tautan yang sudah kami kirimkan. Jika Anda belum menerima email, kami akan dengan senang hati mengirimkan yang baru.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert-success">
                    Tautan verifikasi baru telah dikirimkan ke alamat email Anda.
                </div>
            @endif

            <div class="form-actions">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="resend-button">Kirim Ulang Email Verifikasi</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-link">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>