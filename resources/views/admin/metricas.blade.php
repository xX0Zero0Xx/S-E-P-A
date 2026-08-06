@extends('layouts.admin')

@section('title', 'Métricas y Pedimentos Totales')

@section('content')
<!-- Encabezado -->
<div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-white flex items-center space-x-2">
            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span>Métricas Globales de Operaciones Aduanales</span>
        </h1>
        <p class="text-xs text-slate-400 mt-1">
            Revisión consolidada de pedimentos capturados, montos acumulados, contribuciones y volumen por aduana.
        </p>
    </div>

    <div class="bg-slate-800/80 px-4 py-2 rounded-xl border border-slate-700 text-xs text-slate-300">
        Actualizado: <span class="font-bold text-emerald-400">{{ now()->format('d/m/Y H:i') }}</span>
    </div>
</div>

<!-- Tarjetas KPI / Financieras -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- KPI 1: Pedimentos Totales -->
    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800">
        <div class="flex justify-between items-center text-slate-400 text-xs">
            <span>Pedimentos Totales</span>
            <div class="p-2 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div class="text-2xl font-black text-white mt-2">{{ number_format($totalPedimentos ?? 0) }}</div>
        <div class="text-[11px] text-slate-500 mt-1">Operaciones registradas en sistema</div>
    </div>

    <!-- KPI 2: Valor en Aduana -->
    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800">
        <div class="flex justify-between items-center text-slate-400 text-xs">
            <span>Valor en Aduana Acumulado</span>
            <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="text-2xl font-black text-emerald-400 mt-2">${{ number_format($valorAduanaTotal ?? 0, 2) }}</div>
        <div class="text-[11px] text-slate-500 mt-1">Suma total de valor aduana (MXN/USD)</div>
    </div>

    <!-- KPI 3: Valor Comercial -->
    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800">
        <div class="flex justify-between items-center text-slate-400 text-xs">
            <span>Valor Comercial Total</span>
            <div class="p-2 rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="text-2xl font-black text-indigo-400 mt-2">${{ number_format($valorComercialTotal ?? 0, 2) }}</div>
        <div class="text-[11px] text-slate-500 mt-1">Monto de facturación mercantil</div>
    </div>

    <!-- KPI 4: Contribuciones Totales -->
    <div class="bg-slate-900/80 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-800">
        <div class="flex justify-between items-center text-slate-400 text-xs">
            <span>Contribuciones Calculadas</span>
            <div class="p-2 rounded-lg bg-purple-500/10 text-purple-400 border border-purple-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="text-2xl font-black text-purple-400 mt-2">${{ number_format($contribucionesTotal ?? 0, 2) }}</div>
        <div class="text-[11px] text-slate-500 mt-1">Impuestos (IGI/DTA/IVA) estimados</div>
    </div>

</div>

<!-- Paneles Estadísticos Desglosados -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Distribución por Aduana -->
    <div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 space-y-4">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center justify-between border-b border-slate-800 pb-3">
            <span>Volumen por Aduana</span>
            <span class="text-[11px] text-slate-400 font-normal">Aduanas Registradas</span>
        </h3>

       <div class="space-y-3">
    @forelse($pedimentosPorAduana as $aduana)

        @php
            $cantAduana = (int) ($aduana->total ?? 0);
            $porcentaje = $totalPedimentos > 0
                ? round(($cantAduana / $totalPedimentos) * 100)
                : 0;
        @endphp

        <div class="space-y-1 text-xs">

            <div class="flex justify-between text-slate-300 font-medium">
                <span>
                    Aduana {{ $aduana->clave_aduana }} -
                    {{ $aduana->denominacion_aduana ?? 'Sección Aduanera' }}
                </span>

                <span class="font-bold text-blue-400">
                    {{ $cantAduana }} pedimentos ({{ $porcentaje }}%)
                </span>
            </div>

            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">

                <div
                    class="h-full bg-gradient-to-r from-blue-500 to-indigo-400 rounded-full"
                    style="width: {{ $porcentaje . '%' }};">
                </div>

            </div>

        </div>

    @empty

        <div class="text-center py-6 text-slate-500 text-xs italic">
            Sin registros de aduanas disponibles.
        </div>

    @endforelse
</div>
    </div>

    <!-- Distribución por Régimen -->
    <div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 space-y-4">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center justify-between border-b border-slate-800 pb-3">
            <span>Operaciones por Régimen</span>
            <span class="text-[11px] text-slate-400 font-normal">Tipos de Régimen</span>
        </h3>

        <div class="space-y-3">
    @forelse($pedimentosPorRegimen as $regimen)

        @php
            $cantRegimen = (int) ($regimen->total ?? 0);
            $porcentajeRegimen = $totalPedimentos > 0
                ? round(($cantRegimen / $totalPedimentos) * 100)
                : 0;
        @endphp

        <div class="space-y-1 text-xs">

            <div class="flex justify-between text-slate-300 font-medium">
                <span>
                    {{ $regimen->clave_regimen }} -
                    {{ $regimen->descripcion_regimen ?? 'Régimen Aduanero' }}
                </span>

                <span class="font-bold text-emerald-400">
                    {{ $cantRegimen }} ({{ $porcentajeRegimen }}%)
                </span>
            </div>

            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">

                <div
                    class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full"
                    style="width: {{ $porcentajeRegimen . '%' }};">
                </div>

            </div>

        </div>

    @empty

        <div class="text-center py-6 text-slate-500 text-xs italic">
            Sin registros de regímenes aún.
        </div>

    @endforelse
</div>
    </div>

</div>

<!-- Tabla Detallada de Pedimentos Registrados -->
<div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 space-y-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h3 class="text-lg font-bold text-white flex items-center space-x-2">
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span>Revisión Global de Pedimentos</span>
        </h3>

        <form action="{{ route('admin.metricas') }}" method="GET" class="flex items-center space-x-2 w-full sm:w-auto">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Pedimento, RFC o Razón Social..."
                class="bg-slate-800/90 text-white text-xs rounded-xl px-3 py-2 border border-slate-700 focus:outline-none focus:border-blue-500 placeholder-slate-500 w-full sm:w-64">
            <button type="submit" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold rounded-xl border border-slate-700">Buscar</button>
            @if(request('buscar'))
                <a href="{{ route('admin.metricas') }}" class="text-xs text-slate-400 hover:text-white px-2">Limpiar</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-800/90 text-slate-400 uppercase font-semibold text-[10px] tracking-wider border-b border-slate-800">
                <tr>
                    <th class="px-4 py-3">Pedimento</th>
                    <th class="px-4 py-3">Importador (RFC / Razón Social)</th>
                    <th class="px-4 py-3">Clave / Régimen</th>
                    <th class="px-4 py-3">Valor Comercial</th>
                    <th class="px-4 py-3">Capturista</th>
                    <th class="px-4 py-3 text-center">Estado Simulación</th>
                    <th class="px-4 py-3 text-center">Detalles</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse($pedimentos as $pedimento)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 font-bold text-blue-400">{{ $pedimento->numero_pedimento }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-200">{{ $pedimento->razon_social ?? 'N/A' }}</div>
                            <div class="text-[10px] text-slate-500 font-mono">{{ $pedimento->rfc_importador ?? 'SIN RFC' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-slate-800 px-2 py-0.5 rounded border border-slate-700 text-slate-300">
                                {{ $pedimento->clave_pedimento ?? 'A1' }} | {{ $pedimento->clave_regimen ?? 'IMD' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-emerald-400">${{ number_format($pedimento->valor_comercial ?? 0, 2) }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ optional($pedimento->user)->name ?? 'Desconocido' }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $estatus = strtolower($pedimento->estatus_simulacion ?? 'pagado');
                            @endphp
                            @if($estatus === 'borrador')
                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/30 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Borrador</span>
                            @elseif($estatus === 'validado')
                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/30 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Validado</span>
                            @else
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Pagado / Despachado</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('pedimentos.show', $pedimento->id) }}" target="_blank" class="p-1.5 bg-slate-800 hover:bg-blue-600/30 text-slate-300 hover:text-blue-400 rounded-lg border border-slate-700 transition inline-block" title="Ver Pedimento Completo">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500 italic">
                            No existen registros de pedimentos para mostrar en esta vista.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pedimentos->hasPages())
        <div class="pt-4 border-t border-slate-800">
            {{ $pedimentos->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
