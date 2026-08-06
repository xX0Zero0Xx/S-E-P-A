@extends('layouts.admin')

@section('title', 'Panel de Control General')

@section('content')
<!-- Tarjeta de Bienvenida -->
<div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-2xl border border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">
            Panel de Control General
        </h1>
        <p class="text-xs text-slate-400 mt-1">
            Bienvenido al centro de mando y administración del sistema S.E.P.A.
        </p>
    </div>
    <div class="flex items-center space-x-3 bg-slate-800/80 px-4 py-2 rounded-xl border border-slate-700/60 shadow-inner">
        <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
        </span>
        <span class="text-xs font-semibold text-slate-300">Sistema Operativo</span>
    </div>
</div>

<!-- Tarjetas de Acceso Rápido y Métricas Clave -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Tarjeta 1: Gestión de Usuarios -->
    <div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 hover:border-slate-700 transition duration-300 flex flex-col justify-between group">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase text-blue-400 tracking-wider bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded">
                    Gestión
                </span>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 group-hover:scale-110 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>

            <h2 class="text-xl font-extrabold text-white mt-3 group-hover:text-blue-400 transition">Usuarios</h2>
            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                Administrar cuentas de usuarios, asignación de roles (Administrador / Capturista) y permisos de acceso.
            </p>

            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
                <span class="text-slate-400">Total Usuarios:</span>
                <span class="font-bold text-white bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700">{{ $totalUsuarios ?? 0 }}</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.usuarios') }}" class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-xs rounded-xl shadow-lg shadow-blue-900/30 flex items-center justify-center space-x-2 transition">
                <span>Acceder a Usuarios</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>

    <!-- Tarjeta 2: Métricas / Pedimentos Totales -->
    <div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 hover:border-slate-700 transition duration-300 flex flex-col justify-between group">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase text-emerald-400 tracking-wider bg-emerald-500/10 border border-emerald-500/20 px-2 py-0.5 rounded">
                    Métricas
                </span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>

            <h2 class="text-xl font-extrabold text-white mt-3 group-hover:text-emerald-400 transition">Pedimentos Totales</h2>
            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                Revisión global de operaciones registradas, valores comerciales, aduanas activas y estadísticas.
            </p>

            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
                <span class="text-slate-400">Total Pedimentos:</span>
                <span class="font-bold text-emerald-400 bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700">{{ $totalPedimentos ?? 0 }}</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.metricas') }}" class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-semibold text-xs rounded-xl shadow-lg shadow-emerald-900/30 flex items-center justify-center space-x-2 transition">
                <span>Ver Métricas</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>

    <!-- Tarjeta 3: Seguridad y Auditoría -->
    <div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 hover:border-slate-700 transition duration-300 flex flex-col justify-between group">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase text-purple-400 tracking-wider bg-purple-500/10 border border-purple-500/20 px-2 py-0.5 rounded">
                    Seguridad
                </span>
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            </div>

            <h2 class="text-xl font-extrabold text-white mt-3 group-hover:text-purple-400 transition">Auditoría</h2>
            <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                Registro de inicios de sesión, cambios de perfil, IPs y trazabilidad de eventos del sistema.
            </p>

            <div class="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
                <span class="text-slate-400">Estado Auditoría:</span>
                <span class="font-bold text-purple-400 bg-slate-800 px-2 py-0.5 rounded-md border border-slate-700 text-[11px]">Activo / Seguro</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.auditoria') }}" class="w-full py-2.5 px-4 bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-500 hover:to-violet-500 text-white font-semibold text-xs rounded-xl shadow-lg shadow-purple-900/30 flex items-center justify-center space-x-2 transition">
                <span>Ver Auditoría</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>

</div>

<!-- Pedimentos Recientes Registrados -->
<div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800">
    <h3 class="text-lg font-bold text-white flex items-center space-x-2">
        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Últimas Operaciones Registradas</span>
    </h3>

    <div class="mt-4 overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-800/80 text-slate-400 uppercase font-semibold text-[10px] tracking-wider">
                <tr>
                    <th class="px-4 py-3 rounded-l-lg">Pedimento</th>
                    <th class="px-4 py-3">Importador / Razón Social</th>
                    <th class="px-4 py-3">Aduana</th>
                    <th class="px-4 py-3">Capturista</th>
                    <th class="px-4 py-3 rounded-r-lg">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($pedimentosRecientes as $p)
                    <tr class="hover:bg-slate-800/50 transition">
                        <td class="px-4 py-3 font-bold text-blue-400">{{ $p->numero_pedimento }}</td>
                        <td class="px-4 py-3">{{ $p->razon_social ?? 'N/A' }}</td>
                        <td class="px-4 py-3"><span class="bg-slate-800 px-2 py-0.5 rounded border border-slate-700 text-slate-300">{{ $p->clave_aduana }} - {{ $p->denominacion_aduana }}</span></td>
                        <td class="px-4 py-3 text-slate-400">{{ $p->user->name ?? 'Sistema' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500 italic">
                            No hay pedimentos registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection