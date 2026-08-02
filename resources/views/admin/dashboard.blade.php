<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | WebPedimentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 flex flex-col min-h-screen relative bg-slate-900">

    <img src="{{ asset('css/Fondo.jpg') }}" alt="Fondo" class="fixed inset-0 w-full h-full object-cover z-0">
    <div class="fixed inset-0 bg-black/50 z-0"></div>

    <!-- Navegación superior -->
    <header class="bg-slate-900/80 backdrop-blur-md text-white shadow-md relative z-10 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-wide">S.E.P.A.</span>
                <span class="text-xs bg-red-600 text-white px-2 py-0.5 rounded font-semibold uppercase">Admin</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-300">Hola, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg transition shadow-sm">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10 space-y-6">
        
        <!-- Tarjeta de Bienvenida -->
        <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20">
            <h1 class="text-2xl font-bold text-slate-900">Panel de Control General</h1>
            <p class="text-sm text-gray-600">Bienvenido al sistema de administración de WebPedimentos.</p>
        </div>

        <!-- Tarjetas Metricas/Acciones Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20">
                <div class="text-xs font-bold uppercase text-blue-600 tracking-wider">Gestión</div>
                <h2 class="text-xl font-extrabold text-slate-900 mt-1">Usuarios</h2>
                <p class="text-sm text-gray-600 mt-2">Administrar cuentas, roles y permisos de acceso.</p>
            </div>

            <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20">
                <div class="text-xs font-bold uppercase text-blue-600 tracking-wider">Métricas</div>
                <h2 class="text-xl font-extrabold text-slate-900 mt-1">Pedimentos Totales</h2>
                <p class="text-sm text-gray-600 mt-2">Revisión global de operaciones registradas.</p>
            </div>

            <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20">
                <div class="text-xs font-bold uppercase text-blue-600 tracking-wider">Seguridad</div>
                <h2 class="text-xl font-extrabold text-slate-900 mt-1">Auditoría</h2>
                <p class="text-sm text-gray-600 mt-2">Registro de inicios de sesión y actividad.</p>
            </div>
        </div>
    </main>
    <footer class="bg-slate-900/80 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} WebPedimentos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>