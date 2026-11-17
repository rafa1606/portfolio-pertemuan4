<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // API publik: 60 request per menit per IP
        RateLimiter::for('portfolio-api', fn (Request $request) =>
            Limit::perMinute(60)->by($request->ip()));

        // Form contact: 3 pesan per menit per IP
        RateLimiter::for('contact', fn (Request $request) =>
            Limit::perMinute(3)->by($request->ip()));
    }
}