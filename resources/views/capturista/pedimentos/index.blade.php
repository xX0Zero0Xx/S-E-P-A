<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 flex flex-col min-h-screen relative bg-slate-900">

    <!-- Navegación superior -->
    <header class="bg-slate-900/80 backdrop-blur-md text-white shadow-md relative z-10 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-wide">S.E.P.A.</span>
                <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded font-semibold uppercase">Capturista</span>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('captura') }}" class="px-3 py-1.5 text-xs font-medium bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-sm">
                    + Capturar Pedimento
                </a>
                <a href="{{ route('capturista.dashboard') }}" class="px-3 py-1.5 text-xs font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-sm">
                    Volver al Inicio
                </a>
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

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-200 p-4 rounded-xl backdrop-blur-md shadow-lg flex justify-between items-center">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tarjeta de Encabezado -->
        <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">listado de mis pedimentos capturados por el usuario</h1>
                <p class="text-sm text-gray-600">Consulta, imprime y revisa los pedimentos registrados en la plataforma.</p>
            </div>
            <a href="{{ route('captura') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md transition">
                Nueva Captura
            </a>
        </div>

        <!-- Buscador -->
        <div class="bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/20">
            <form action="{{ route('pedimentos.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por número de pedimento, RFC o razón social..." class="flex-grow rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-3 border">
                <button type="submit" class="px-5 py-3 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition">
                    Buscar
                </button>
                @if(request('buscar'))
                    <a href="{{ route('pedimentos.index') }}" class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold rounded-xl text-center transition">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabla de Pedimentos -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-100 border-b border-gray-200 text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            <th class="p-4">Pedimento</th>
                            <th class="p-4">Importador / RFC</th>
                            <th class="p-4">Aduana / Régimen</th>
                            <th class="p-4">Valor Aduana</th>
                            <th class="p-4">Estatus</th>
                            <th class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pedimentos as $pedimento)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="p-4 font-bold text-blue-900">
                                    {{ $pedimento->numero_pedimento }}
                                    <span class="block text-xs font-normal text-gray-500">{{ $pedimento->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-slate-900">{{ $pedimento->razon_social ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $pedimento->rfc_importador ?? 'Sin RFC' }}</div>
                                </td>
                                <td class="p-4 text-xs">
                                    <span class="font-semibold text-slate-800">Aduana:</span> {{ $pedimento->clave_aduana ?? 'N/A' }}<br>
                                    <span class="font-semibold text-slate-800">Régimen:</span> {{ $pedimento->clave_regimen ?? 'N/A' }}
                                </td>
                                <td class="p-4 font-semibold text-slate-900">
                                    ${{ number_format($pedimento->valor_aduana ?? 0, 2) }} MXN
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                        @if(($pedimento->estatus_simulacion ?? 'Borrador') === 'Borrador') bg-yellow-100 text-yellow-800
                                        @elseif($pedimento->estatus_simulacion === 'Validado') bg-blue-100 text-blue-800
                                        @elseif($pedimento->estatus_simulacion === 'Pagado') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ $pedimento->estatus_simulacion ?? 'Borrador' }}
                                    </span>
                                </td>
                            <td class="p-4">
    <div class="flex justify-center items-center gap-2">

        <a href="{{ route('pedimentos.show', $pedimento->id) }}"
        class="inline-flex items-center px-3 py-2 text-xs font-semibold text-white bg-slate-700 hover:bg-slate-800 rounded-lg shadow transition">
            Ver
        </a>

        <a href="{{ route('pedimentos.pdf', $pedimento->id) }}"
        target="_blank"
        class="inline-flex items-center px-3 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow transition">
            PDF
        </a>

        <form id="formEliminar{{ $pedimento->id }}"
    action="{{ route('pedimentos.destroy', $pedimento->id) }}"
    method="POST"
    class="inline">

    @csrf
    @method('DELETE')

    <button
    type="button"
    data-id="{{ $pedimento->id }}"
    data-numero="{{ $pedimento->numero_pedimento }}"
    data-importador="{{ $pedimento->razon_social ?? 'N/A' }}"
    data-valor="{{ number_format($pedimento->valor_aduana ?? 0, 2) }}"
    onclick="abrirModalEliminar(this)"
    class="inline-flex items-center px-3 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow transition">

    Eliminar

</button>

</form>

    </div>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    No se encontraron pedimentos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pedimentos->hasPages())
                <div class="p-4 bg-gray-50 border-t border-gray-200">
                    {{ $pedimentos->links() }}
                </div>
            @endif
        </div>

    </main>

    <footer class="bg-slate-900/80 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} S-E-P-A - Módulo de Capturista.</p>
    </footer>
    <!-- Modal Eliminar -->
<div id="modalEliminar"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

        <!-- Encabezado -->
        <div class="bg-red-600 text-white px-6 py-4">

            <h2 class="text-xl font-bold">
                Confirmar eliminación
            </h2>

        </div>

        <!-- Contenido -->
        <div class="p-6">

            <p class="text-gray-700 mb-5">
                Vas a eliminar el siguiente pedimento.
            </p>

            <div class="bg-gray-100 rounded-xl p-4 space-y-3">

                <div>
                    <span class="font-semibold text-gray-700">
                        Número:
                    </span>

                    <div id="modalNumero"
                        class="text-blue-700 font-bold">
                    </div>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">
                        Importador:
                    </span>

                    <div id="modalImportador">
                    </div>
                </div>

                <div>
                    <span class="font-semibold text-gray-700">
                        Valor en Aduana:
                    </span>

                    <div id="modalValor"
                        class="font-semibold text-green-700">
                    </div>
                </div>

            </div>

            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-3">

                <p class="text-red-700 text-sm">

                    Esta acción eliminará permanentemente el pedimento y no podrá recuperarse.

                </p>

            </div>

        </div>

        <!-- Botones -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">

            <button
                type="button"
                onclick="cerrarModalEliminar()"
                class="px-5 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 transition">

                Cancelar

            </button>

            <button
                type="button"
                onclick="enviarEliminar()"
                class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition">

                Eliminar

            </button>

        </div>

    </div>

</div>

</div>

<script>

let formularioEliminar = null;

function abrirModalEliminar(boton){

    const id = boton.dataset.id;
    const numero = boton.dataset.numero;
    const importador = boton.dataset.importador;
    const valor = boton.dataset.valor;

    formularioEliminar = document.getElementById('formEliminar' + id);

    document.getElementById('modalNumero').textContent = numero;
    document.getElementById('modalImportador').textContent = importador;
    document.getElementById('modalValor').textContent = '$' + valor + ' MXN';

    document.getElementById('modalEliminar').classList.remove('hidden');
    document.getElementById('modalEliminar').classList.add('flex');
}

function cerrarModalEliminar(){

    document.getElementById('modalEliminar').classList.add('hidden');
    document.getElementById('modalEliminar').classList.remove('flex');

}

function enviarEliminar(){

    if(formularioEliminar){
        formularioEliminar.submit();
    }

}

</script>
</body>
</html>
