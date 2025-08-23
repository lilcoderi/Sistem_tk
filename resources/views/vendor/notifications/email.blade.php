<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notifikasi' }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 30px; }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { max-width: 100px; }
        h1 { font-size: 20px; color: #111827; text-align: center; margin-bottom: 16px; }
        p { font-size: 14px; color: #374151; line-height: 1.6; text-align: center; margin-bottom: 16px; }
        .btn { display: inline-block; background-color: #4f46e5; color: #ffffff !important; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; }
        .btn:hover { background-color: #4338ca; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 24px; }
        .actions { text-align: center; margin: 24px 0; }
        .subcopy { font-size: 12px; color: #6b7280; text-align: center; word-break: break-all; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            {{-- Opsional: ganti ke logo-mu --}}
            <img src="{{ asset('assets/img/favicon.png') }}" alt="Logo">
        </div>

        <h1>{{ $greeting ?? 'Hallo!' }}</h1>

        {{-- Intro lines dari MailMessage --}}
        @if(!empty($introLines))
            @foreach($introLines as $line)
                <p>{!! nl2br(e($line)) !!}</p>
            @endforeach
        @endif

        {{-- Tombol aksi jika ada --}}
        @if(!empty($actionUrl))
            <div class="actions">
                <a href="{{ $actionUrl }}" class="btn">
                    {{ $actionText ?? 'Buka Tautan' }}
                </a>
            </div>
        @endif

        {{-- Outro lines dari MailMessage --}}
        @if(!empty($outroLines))
            @foreach($outroLines as $line)
                <p>{!! nl2br(e($line)) !!}</p>
            @endforeach
        @endif

        {{-- Subcopy (tautan plain) --}}
        @if(!empty($actionUrl))
            <div class="subcopy">
                Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke browser Anda:<br>
                <a href="{{ $actionUrl }}">{{ $displayableActionUrl ?? $actionUrl }}</a>
            </div>
        @endif

        <div class="footer">
            {{ $salutation ?? 'Salam,<br>'.e(config('app.name')) }}
        </div>
    </div>
</body>
</html>
