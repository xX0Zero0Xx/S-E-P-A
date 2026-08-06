<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Dashboard General de Administración
     */
    public function dashboard()
    {
        $totalUsuarios = User::count();
        $totalPedimentos = Pedimento::count();
        $pedimentosRecientes = Pedimento::with('user')->latest()->take(5)->get();

        $usuariosPorRol = [
            'administrador' => User::where('rol', 'administrador')->count(),
            'capturista' => User::where('rol', 'capturista')->count(),
        ];

        return view('admin.dashboard', compact('totalUsuarios', 'totalPedimentos', 'pedimentosRecientes', 'usuariosPorRol'));
    }

    /**
     * Vista de Gestión de Usuarios
     */
    public function usuarios(Request $request)
    {
        $query = User::query();

        if ($request->filled('buscar')) {
            $busqueda = (string) $request->input('buscar');
            $query->where(function ($q) use ($busqueda) {
                $q->where('name', 'like', "%{$busqueda}%")
                  ->orWhere('email', 'like', "%{$busqueda}%")
                  ->orWhere('username', 'like', "%{$busqueda}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->input('rol'));
        }

        $usuarios = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.usuarios', compact('usuarios'));
    }

    /**
     * Crear un nuevo usuario desde la vista de administración
     */
    public function storeUsuario(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:administrador,capturista',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.usuarios')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Actualizar datos y rol de un usuario existente
     */
    public function updateUsuario(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'rol' => 'required|in:administrador,capturista',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroyUsuario(int $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return redirect()->route('admin.usuarios')->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $user->delete();

        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado con éxito.');
    }

    /**
     * Vista de Métricas y Pedimentos Totales
     */
    public function metricas(Request $request)
    {
        $totalPedimentos = Pedimento::count();
        $valorAduanaTotal = (float) (Pedimento::sum('valor_aduana') ?: 0);
        $valorComercialTotal = (float) (Pedimento::sum('valor_comercial') ?: 0);
        $contribucionesTotal = (float) (Pedimento::sum('total_general') ?: 0);

        // Desglose por Aduana
        $pedimentosPorAduana = Pedimento::selectRaw('clave_aduana, denominacion_aduana, COUNT(*) as total')
            ->groupBy('clave_aduana', 'denominacion_aduana')
            ->orderBy('total', 'desc')
            ->get();

        // Desglose por Régimen
        $pedimentosPorRegimen = Pedimento::selectRaw('clave_regimen, descripcion_regimen, COUNT(*) as total')
            ->groupBy('clave_regimen', 'descripcion_regimen')
            ->orderBy('total', 'desc')
            ->get();

        // Consulta filtrada para la tabla de revisión global
        $query = Pedimento::with('user');

        if ($request->filled('buscar')) {
            $busqueda = (string) $request->input('buscar');
            $query->where(function ($q) use ($busqueda) {
                $q->where('numero_pedimento', 'like', "%{$busqueda}%")
                  ->orWhere('razon_social', 'like', "%{$busqueda}%")
                  ->orWhere('rfc_importador', 'like', "%{$busqueda}%");
            });
        }

        if ($request->filled('aduana')) {
            $query->where('clave_aduana', $request->input('aduana'));
        }

        $pedimentos = $query->latest()->paginate(10);

        return view('admin.metricas', compact(
            'totalPedimentos',
            'valorAduanaTotal',
            'valorComercialTotal',
            'contribucionesTotal',
            'pedimentosPorAduana',
            'pedimentosPorRegimen',
            'pedimentos'
        ));
    }

    /**
     * Vista de Seguridad y Auditoría
     */
    public function auditoria(Request $request)
    {
        $userName = Auth::user() ? Auth::user()->name : 'Administrador';

        // Datos estructurados de auditoría para demostración
        $logsEstaticos = collect([
            [
                'id' => 1,
                'usuario' => $userName,
                'rol' => 'administrador',
                'evento' => 'Inicio de Sesión',
                'descripcion' => 'Autenticación exitosa en el panel administrativo',
                'ip' => '127.0.0.1',
                'nivel' => 'info',
                'fecha' => now()->subMinutes(12)->format('d/m/Y H:i:s'),
            ],
            [
                'id' => 2,
                'usuario' => 'Juan Capturista',
                'rol' => 'capturista',
                'evento' => 'Creación de Pedimento',
                'descripcion' => 'Registro de pedimento #240019283 en Aduana 240',
                'ip' => '192.168.1.45',
                'nivel' => 'exito',
                'fecha' => now()->subHours(1)->format('d/m/Y H:i:s'),
            ],
            [
                'id' => 3,
                'usuario' => 'Sistema SEPA',
                'rol' => 'sistema',
                'evento' => 'Modificación de Usuario',
                'descripcion' => 'Actualización de rol para el usuario carla_admon',
                'ip' => '127.0.0.1',
                'nivel' => 'advertencia',
                'fecha' => now()->subHours(3)->format('d/m/Y H:i:s'),
            ],
            [
                'id' => 4,
                'usuario' => 'Desconocido',
                'rol' => 'invitado',
                'evento' => 'Intento Fallido de Login',
                'descripcion' => 'Contraseña incorrecta para usuario admin_test',
                'ip' => '189.210.44.12',
                'nivel' => 'critico',
                'fecha' => now()->subHours(5)->format('d/m/Y H:i:s'),
            ],
            [
                'id' => 5,
                'usuario' => 'Maria Lopez',
                'rol' => 'capturista',
                'evento' => 'Eliminación de Borrador',
                'descripcion' => 'Se eliminó el borrador de pedimento #240019280',
                'ip' => '192.168.1.50',
                'nivel' => 'advertencia',
                'fecha' => now()->subDay()->format('d/m/Y H:i:s'),
            ],
        ]);

        if ($request->filled('nivel')) {
            $nivelFilter = $request->input('nivel');
            $logsEstaticos = $logsEstaticos->where('nivel', $nivelFilter);
        }

        if ($request->filled('buscar')) {
            $b = strtolower((string) $request->input('buscar'));
            $logsEstaticos = $logsEstaticos->filter(function ($item) use ($b) {
                return str_contains(strtolower($item['usuario']), $b) ||
                    str_contains(strtolower($item['evento']), $b) ||
                    str_contains(strtolower($item['descripcion']), $b) ||
                    str_contains(strtolower($item['ip']), $b);
            });
        }

        return view('admin.auditoria', ['logs' => $logsEstaticos]);
    }
}
