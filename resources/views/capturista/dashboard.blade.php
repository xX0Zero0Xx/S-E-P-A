<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Captura | WebPedimentos</title>
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
                <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded font-semibold uppercase">Capturista</span>
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
            <h1 class="text-2xl font-bold text-slate-900">Módulo de Captura</h1>
            <p class="text-sm text-gray-600">Área de trabajo para la generación y consulta de pedimentos aduanales.</p>
        </div>

        <!-- Módulos Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20 flex flex-col justify-between space-y-4">
                <div>
                    <div class="text-xs font-bold uppercase text-blue-600 tracking-wider">Nuevo Registro</div>
                    <h2 class="text-xl font-extrabold text-slate-900 mt-1">Capturar Pedimento</h2>
                    <p class="text-sm text-gray-600 mt-2">Ingresa datos de importación o exportación, partidas y contribuciones.</p>
                </div>
                <div>
                    <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm shadow transition">
                        Iniciar Captura
                    </button>
                </div>
            </div>

            <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20 flex flex-col justify-between space-y-4">
                <div>
                    <div class="text-xs font-bold uppercase text-blue-600 tracking-wider">Consultas</div>
                    <h2 class="text-xl font-extrabold text-slate-900 mt-1">Mis Pedimentos</h2>
                    <p class="text-sm text-gray-600 mt-2">Revisa el historial de registros realizados y sus estatus.</p>
                </div>
                <div>
                    <button type="button" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-medium rounded-lg text-sm shadow transition">
                        Ver Historial
                    </button>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-slate-900/80 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} WebPedimentos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>