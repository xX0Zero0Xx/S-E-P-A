<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración') - S.E.P.A.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans text-gray-800 flex flex-col min-h-screen relative bg-slate-950">

    <!-- Imagen de fondo e Overlay Glass -->
    <img src="{{ asset('css/Fondo.jpg') }}" alt="Fondo" class="fixed inset-0 w-full h-full object-cover z-0">
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-0"></div>

    <!-- Encabezado Principal -->
    <header class="bg-slate-900/80 backdrop-blur-md text-white shadow-lg relative z-10 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                        <span class="text-2xl font-black bg-gradient-to-r from-blue-400 via-indigo-300 to-purple-400 bg-clip-text text-transparent tracking-wider">S.E.P.A.</span>
                    </a>
                    <span class="text-[10px] bg-red-600/90 text-white px-2 py-0.5 rounded font-bold uppercase tracking-wider shadow-sm border border-red-500/30">
                        Admin Panel
                    </span>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 bg-slate-800/60 backdrop-blur-sm px-3 py-1.5 rounded-full border border-slate-700/50">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center font-bold text-xs text-white shadow">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="text-xs font-semibold text-slate-200">{{ Auth::user()->name }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 text-xs font-semibold bg-red-600/80 hover:bg-red-600 text-white rounded-lg transition shadow-sm border border-red-500/40 hover:shadow-red-900/40 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Salir</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Navegación por pestañas interactivas -->
            <nav class="flex space-x-1 border-t border-slate-800/80 pt-2 overflow-x-auto">
                <a href="{{ route('admin.dashboard') }}"
                class="px-4 py-2 text-xs font-semibold rounded-t-lg transition flex items-center space-x-2 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800/90 text-blue-400 border-blue-500' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard General</span>
                </a>

                <a href="{{ route('admin.usuarios') }}"
                class="px-4 py-2 text-xs font-semibold rounded-t-lg transition flex items-center space-x-2 border-b-2 {{ request()->routeIs('admin.usuarios*') ? 'bg-slate-800/90 text-blue-400 border-blue-500' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Gestión de Usuarios</span>
                </a>

                <a href="{{ route('admin.metricas') }}"
                class="px-4 py-2 text-xs font-semibold rounded-t-lg transition flex items-center space-x-2 border-b-2 {{ request()->routeIs('admin.metricas*') ? 'bg-slate-800/90 text-blue-400 border-blue-500' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span>Métricas y Pedimentos</span>
                </a>

                <a href="{{ route('admin.auditoria') }}"
                class="px-4 py-2 text-xs font-semibold rounded-t-lg transition flex items-center space-x-2 border-b-2 {{ request()->routeIs('admin.auditoria*') ? 'bg-slate-800/90 text-blue-400 border-blue-500' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40 border-transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Seguridad y Auditoría</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Notificaciones de Sesión -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 relative z-10 space-y-6">
        @if (session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 backdrop-blur-md text-emerald-300 p-4 rounded-xl shadow-lg flex items-center justify-between text-xs">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/10 border border-red-500/30 backdrop-blur-md text-red-300 p-4 rounded-xl shadow-lg flex items-center justify-between text-xs">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Pie de página -->
    <footer class="bg-slate-900/80 backdrop-blur-md text-slate-400 py-4 text-center text-xs border-t border-slate-800 relative z-10 mt-8">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} S-E-P-A. Sistema de Entorno de Pedimento Aduanal.</p>
            <span class="text-[11px] text-slate-500">Módulo de Administración de Seguridad y Operaciones</span>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
