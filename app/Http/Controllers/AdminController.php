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
        $logPath = storage_path('logs/audit.log');
        $logsReal = collect();

        if (file_exists($logPath)) {
            $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $idCounter = 1;

            foreach (array_reverse($lines) as $line) {
                // Parsear formato básico del log de laravel: [2026-08-06 20:52:21] local.INFO: mensaje {json}
                if (preg_match('/^\[(.*?)\]\s+(\w+)\.(\w+):\s+([^\{]+)\s*(\{.*\})?/', $line, $matches)) {
                    $fecha = $matches[1];
                    $nivelStr = strtolower($matches[3]); // info, warning, error, etc.
                    $evento = trim($matches[4]);
                    $contextData = isset($matches[5]) ? json_decode($matches[5], true) : [];

                    $nivelMap = [
                        'info'    => 'info',
                        'notice'  => 'info',
                        'warning' => 'advertencia',
                        'error'   => 'critico',
                    ];

                    $logsReal->push([
                        'id'          => $idCounter++,
                        'usuario'     => $contextData['email'] ?? ($contextData['user_id'] ?? 'Sistema/Guest'),
                        'rol'         => $contextData['rol'] ?? 'N/A',
                        'evento'      => $evento,
                        'descripcion' => json_encode($contextData, JSON_UNESCAPED_UNICODE),
                        'ip'          => $contextData['ip'] ?? 'N/A',
                        'nivel'       => $nivelMap[$nivelStr] ?? 'info',
                        'fecha'       => $fecha,
                    ]);
                }
            }
        }

        // Si aún no hay logs en el archivo, mostrar ejemplos de fallback
        if ($logsReal->isEmpty()) {
            $userName = Auth::user() ? Auth::user()->name : 'Administrador';
            $logsReal = collect([
                [
                    'id' => 1,
                    'usuario' => $userName,
                    'rol' => 'administrador',
                    'evento' => 'Inicio de Sesión',
                    'descripcion' => 'Autenticación exitosa en el panel administrativo',
                    'ip' => '127.0.0.1',
                    'nivel' => 'info',
                    'fecha' => now()->format('d/m/Y H:i:s'),
                ],
            ]);
        }

        if ($request->filled('nivel')) {
            $nivelFilter = $request->input('nivel');
            $logsReal = $logsReal->where('nivel', $nivelFilter);
        }

        if ($request->filled('buscar')) {
            $b = strtolower((string) $request->input('buscar'));
            $logsReal = $logsReal->filter(function ($item) use ($b) {
                return str_contains(strtolower($item['usuario']), $b) ||
                    str_contains(strtolower($item['evento']), $b) ||
                    str_contains(strtolower($item['descripcion']), $b) ||
                    str_contains(strtolower($item['ip']), $b);
            });
        }

        return view('admin.auditoria', ['logs' => $logsReal]);
    }

}
