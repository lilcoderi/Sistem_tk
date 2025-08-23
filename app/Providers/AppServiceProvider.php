<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; // Sudah diimpor dengan benar

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Set global timezone to Asia/Jakarta
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');

        // Ini adalah solusi untuk 'Invalid signature' di balik HTTPS proxy
        // Jika aplikasi berjalan di lingkungan produksi, paksa Laravel untuk selalu menghasilkan URL dengan skema HTTPS.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
