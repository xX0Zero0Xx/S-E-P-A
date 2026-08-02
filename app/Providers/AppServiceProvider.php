<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

function boot(): void
{
    RateLimiter::for('login', function (Request $request) {
        return Limit::perMinute(5)->by($request->email . $request->ip());
    });
}