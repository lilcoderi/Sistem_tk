<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        // Set default string length untuk MySQL InnoDB
        Schema::defaultStringLength(191);

        // Atur timezone
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');

        // Paksa HTTPS di production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            // Tambahan penting agar Laravel tahu koneksi sebenarnya HTTPS
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
