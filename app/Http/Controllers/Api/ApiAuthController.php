<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiAuthController extends Controller
{
    /**
     * Autentica a un usuario y genera un token Bearer (Sanctum).
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('login');
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($field, $loginInput)->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            Log::channel('audit')->warning('Intento de autenticación API fallido', [
                'login' => $loginInput,
                'ip'    => $request->ip(),
            ]);

            return response()->json([
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        Log::channel('audit')->info('Autenticación de API exitosa', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'ip'      => $request->ip(),
        ]);

        return response()->json([
            'message'      => 'Autenticación exitosa.',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => [
                'id'       => $user->id,
                'name'     => $user->name,
                'username' => $user->username,
                'email'    => $user->email,
                'rol'      => $user->rol,
            ],
        ], 200);
    }

    /**
     * Revoca el token Bearer del usuario autenticado.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            Log::channel('audit')->info('Cierre de sesión API exitoso', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'ip'      => $request->ip(),
            ]);
        }

        return response()->json([
            'message' => 'Token revocado correctamente.',
        ], 200);
    }
}
