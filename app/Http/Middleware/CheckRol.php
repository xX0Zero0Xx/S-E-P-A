<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRol
{
    public function handle(Request $request, Closure $next, string $rol)
    {
        if (!Auth::check() || Auth::user()->rol !== $rol) {
            abort(403, 'Acceso denegado a esta sección.');
        }

        return $next($request);
    }
}