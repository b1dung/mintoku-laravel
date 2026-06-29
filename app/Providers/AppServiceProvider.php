<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL; // 1. Nhớ thêm dòng import này

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
        Response::macro('allowIframe', function ($response) {
            $response->headers->set('Content-Security-Policy', "frame-ancestors 'self' https://mintoku.vn");
            $response->headers->remove('X-Frame-Options');
            return $response;
        });

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
