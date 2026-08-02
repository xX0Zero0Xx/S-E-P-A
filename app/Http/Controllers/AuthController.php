<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        # Detecta si ingresó email o username
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        # Intento de autenticación
        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $request->filled('remember'))) {
            
            # Cierra la sesión activa en otros navegadores o dispositivos (restricción)
            Auth::logoutOtherDevices($credentials['password']);

            $request->session()->regenerate();

            # Redirección según la columna 'rol'
            $user = Auth::user();
            if ($user->rol === 'administrador') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/capturista/dashboard');
        }

        return back()->withErrors([
            'login' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}