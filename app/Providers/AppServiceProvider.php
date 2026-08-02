<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(Login::class, function ($event) {
            Log::channel('audit')->info("Usuario se autenticó: {$event->user->email}");
        });

        Event::listen(Logout::class, function ($event) {
            Log::channel('audit')->info("Usuario cerró sesión: {$event->user->email}");
        });

        RateLimiter::for('login', function (Request $request) {
            $identifier = $request->input('login') ?? $request->ip();

            return Limit::perMinute(5)->by($identifier . '|' . $request->ip());
        });
    }
}