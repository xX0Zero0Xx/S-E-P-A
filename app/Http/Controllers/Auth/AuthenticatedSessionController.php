<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        \Illuminate\Support\Facades\Log::channel('audit')->info('Inicio de sesión web exitoso', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'rol'     => $user->rol,
            'ip'      => $request->ip(),
        ]);

        if ($user && $user->rol === 'administrador') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('capturista.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            \Illuminate\Support\Facades\Log::channel('audit')->info('Cierre de sesión web', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'ip'      => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
