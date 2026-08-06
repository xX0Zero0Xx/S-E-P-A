<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRol
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->rol, $roles, true)) {
            abort(403, 'Acceso denegado a esta sección.');
        }

        return $next($request);
    }
}