<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;

function boot(): void
{
    Event::listen(Login::class, function ($event) {
        Log::channel('audit')->info("Usuario se autenticó: {$event->user->email}");
    });

    Event::listen(Logout::class, function ($event) {
        Log::channel('audit')->info("Usuario cerró sesión: {$event->user->email}");
    });

    RateLimiter::for('login', function (Request $request) {
        return Limit::perMinute(5)->by($request->email . $request->ip());
    });
}