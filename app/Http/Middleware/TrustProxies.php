<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    // Jika Anda TIDAK TAHU IP proxy Anda, atau jika itu berubah-ubah (misal di cloud hosting),
    // Anda bisa menggunakan '**' untuk memercayai semua proxy.
    // HATI-HATI: Ini harus digunakan dengan bijak karena dapat memiliki implikasi keamanan jika
    // Anda tidak sepenuhnya mengontrol semua proxy di depan aplikasi Anda.
    protected $proxies = '**';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB; // Tambahkan ini jika Anda menggunakan AWS ELB
}
