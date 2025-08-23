<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * Jika Anda menggunakan platform seperti Railway, Vercel, Heroku, dll.,
     * aplikasi Anda biasanya berada di belakang proxy yang IP-nya bisa berubah-ubah.
     * Mengatur ke '**' memercayai semua proxy. Ini umum untuk cloud hosting.
     * Hanya gunakan ini jika Anda yakin semua traffic melalui proxy yang Anda kontrol.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '**';

    /**
     * The headers that should be used to detect proxies.
     * Ini memberi tahu Laravel header HTTP mana yang harus diperiksa
     * untuk mendapatkan informasi proxy (seperti skema asli: HTTP/HTTPS).
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO | // SANGAT PENTING untuk mendeteksi HTTPS
        Request::HEADER_X_FORWARDED_AWS_ELB; // Jika Anda menggunakan AWS ELB, pertahankan ini
}
