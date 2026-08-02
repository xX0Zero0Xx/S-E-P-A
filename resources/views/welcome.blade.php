<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEPA | Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 flex flex-col min-h-screen relative bg-slate-900">

    <!-- Imagen de fondo estática desde public/css/Fondo.jpg -->
    <img src="{{ asset('css/Fondo.jpg') }}" alt="Fondo" class="fixed inset-0 w-full h-full object-cover z-0">

    <!-- Capa oscura para legibilidad del texto -->
    <div class="fixed inset-0 bg-black/40 z-0"></div>

    <!-- Navegación superior -->
    <header class="bg-slate-900/80 backdrop-blur-md text-white shadow-md relative z-10 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-wide">S.E.P.A.</span>
            </div>
            
            <div class="flex items-center space-x-4">
    <button type="button" onclick="window.location.href='{{ route('login') }}'" class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white transition">
        Iniciar sesión
    </button>
    <button type="button" onclick="window.location.href='{{ route('register') }}'" class="px-4 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-sm">
        Registrarse
    </button>
</div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow flex items-center justify-center px-4 py-12 relative z-10">
        <div class="max-w-3xl w-full text-center space-y-8 bg-white/90 backdrop-blur-md p-10 rounded-2xl shadow-2xl border border-white/20">
            
            <div class="space-y-4">
                <span class="inline-block px-3 py-1 text-xs font-semibold uppercase tracking-wider text-blue-700 bg-blue-100 rounded-full">
                    Plataforma de Comercio Exterior
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Gestión Integral de Pedimentos Aduanales
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    Optimiza la captura, validación y administración de tus pedimentos. Controla operaciones de importación y exportación, regímenes aduaneros, contribuciones y documentación de manera eficiente y segura.
                </p>
            </div>

        </div>
    </main>
    <footer class="bg-slate-900/80 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} WebPedimentos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>