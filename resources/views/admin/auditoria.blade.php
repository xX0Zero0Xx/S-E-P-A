@extends('layouts.admin')

@section('title', 'Seguridad y Auditoría')

@section('content')
<!-- Encabezado -->
<div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-white flex items-center space-x-2">
            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <span>Seguridad y Registro de Auditoría</span>
        </h1>
        <p class="text-xs text-slate-400 mt-1">
            Monitoreo y trazabilidad de eventos de inicio de sesión, cambios de perfil, IPs y acciones críticas en el sistema.
        </p>
    </div>

    <div class="flex items-center space-x-2 bg-emerald-500/10 border border-emerald-500/30 px-3 py-2 rounded-xl">
        <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
        <span class="text-xs font-bold text-emerald-400">Protección Activa</span>
    </div>
</div>

<!-- Tarjetas Informativas de Seguridad -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800 flex items-center space-x-4">
        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Estado de Autenticación</div>
            <div class="text-lg font-black text-white">Sesión Encriptada</div>
            <div class="text-[10px] text-slate-500">Middleware CheckRol Activo</div>
        </div>
    </div>

    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800 flex items-center space-x-4">
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Registro de Inicios</div>
            <div class="text-lg font-black text-blue-400">100% Trazable</div>
            <div class="text-[10px] text-slate-500">IP y User-Agent capturados</div>
        </div>
    </div>

    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800 flex items-center space-x-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-[11px] font-bold uppercase text-slate-400">Nivel de Riesgo Global</div>
            <div class="text-lg font-black text-emerald-400">Bajo (Seguro)</div>
            <div class="text-[10px] text-slate-500">Sin anomalías críticas</div>
        </div>
    </div>
</div>

<!-- Filtros y Búsqueda de Logs -->
<div class="bg-slate-900/80 backdrop-blur-md p-4 rounded-2xl shadow-lg border border-slate-800">
    <form action="{{ route('admin.auditoria') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar usuario, evento, IP o descripción..."
                class="w-full bg-slate-800/90 text-white text-xs rounded-xl pl-9 pr-4 py-2.5 border border-slate-700 focus:outline-none focus:border-purple-500 placeholder-slate-500">
            <svg class="w-4 h-4 text-slate-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <select name="nivel" class="bg-slate-800/90 text-slate-300 text-xs rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-purple-500">
                <option value="">Todos los Eventos</option>
                <option value="info" {{ request('nivel') === 'info' ? 'selected' : '' }}>Información</option>
                <option value="exito" {{ request('nivel') === 'exito' ? 'selected' : '' }}>Éxito</option>
                <option value="advertencia" {{ request('nivel') === 'advertencia' ? 'selected' : '' }}>Advertencia</option>
                <option value="critico" {{ request('nivel') === 'critico' ? 'selected' : '' }}>Crítico</option>
            </select>

            <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold rounded-xl border border-slate-700 transition">
                Filtrar Logs
            </button>

            @if(request('buscar') || request('nivel'))
                <a href="{{ route('admin.auditoria') }}" class="px-3 py-2.5 text-xs text-slate-400 hover:text-white transition">
                    Limpiar
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabla Log de Auditoría -->
<div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-800/90 text-slate-400 uppercase font-semibold text-[10px] tracking-wider border-b border-slate-800">
                <tr>
                    <th class="px-6 py-4">Nivel / Estado</th>
                    <th class="px-6 py-4">Evento</th>
                    <th class="px-6 py-4">Usuario</th>
                    <th class="px-6 py-4">Descripción de la Actividad</th>
                    <th class="px-6 py-4 text-center">Dirección IP</th>
                    <th class="px-6 py-4 text-right">Fecha y Hora</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-6 py-4">
                            @if($log['nivel'] === 'info')
                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/30 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    INFO
                                </span>
                            @elseif($log['nivel'] === 'exito')
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    ÉXITO
                                </span>
                            @elseif($log['nivel'] === 'advertencia')
                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/30 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    ALERTA
                                </span>
                            @elseif($log['nivel'] === 'critico')
                                <span class="bg-red-500/10 text-red-400 border border-red-500/30 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    CRÍTICO
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-white">{{ $log['evento'] }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-200">{{ $log['usuario'] }}</div>
                            <div class="text-[10px] text-slate-500 capitalize">{{ $log['rol'] }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-300">{{ $log['descripcion'] }}</td>
                        <td class="px-6 py-4 text-center font-mono text-purple-300">
                            <span class="bg-slate-800 px-2 py-1 rounded border border-slate-700 text-[11px]">{{ $log['ip'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-400 font-mono text-[11px]">{{ $log['fecha'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500 italic">
                            No se encontraron registros de auditoría coincidentes.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
