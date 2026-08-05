<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEPA | Detalle Pedimento {{ $pedimento->numero_pedimento }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 flex flex-col min-h-screen relative bg-slate-900">

    <header class="bg-slate-900/80 backdrop-blur-md text-white shadow-md relative z-10 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-wide">S.E.P.A.</span>
                <span class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded font-semibold uppercase">Detalle</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('pedimentos.index') }}" class="px-3 py-1.5 text-xs font-medium bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition shadow-sm">
                    Volver a Mis Pedimentos
                </a>
                <a href="{{ route('pedimentos.pdf', $pedimento->id) }}" target="_blank" class="px-3 py-1.5 text-xs font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg transition shadow-sm">
                    Generar PDF
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10 space-y-6">
        
        <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pedimento Folio: {{ $pedimento->numero_pedimento }}</h1>
                <p class="text-sm text-gray-600">Registrado el {{ $pedimento->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <span class="px-4 py-1.5 text-sm font-semibold rounded-full bg-blue-100 text-blue-900">
                Estatus: {{ $pedimento->estatus_simulacion ?? 'Borrador' }}
            </span>
        </div>

        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 md:p-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b pb-4">
                <div><span class="text-xs font-bold text-gray-500 uppercase">Clave Pedimento:</span> <p class="text-base font-semibold">{{ $pedimento->clave_pedimento ?? 'N/A' }}</p></div>
                <div><span class="text-xs font-bold text-gray-500 uppercase">Clave Aduana:</span> <p class="text-base font-semibold">{{ $pedimento->clave_aduana ?? 'N/A' }}</p></div>
                <div><span class="text-xs font-bold text-gray-500 uppercase">Clave Régimen:</span> <p class="text-base font-semibold">{{ $pedimento->clave_regimen ?? 'N/A' }}</p></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4">
                <div>
                    <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-2">Importador / Exportador</h3>
                    <p><span class="font-semibold">Razón Social:</span> {{ $pedimento->razon_social ?? 'N/A' }}</p>
                    <p><span class="font-semibold">RFC:</span> {{ $pedimento->rfc_importador ?? 'N/A' }}</p>
                    <p><span class="font-semibold">CURP:</span> {{ $pedimento->curp ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Domicilio:</span> {{ $pedimento->domicilio ?? 'N/A' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-2">Proveedor</h3>
                    <p><span class="font-semibold">Nombre:</span> {{ $pedimento->proveedor ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Factura:</span> {{ $pedimento->numero_factura ?? 'N/A' }}</p>
                    <p><span class="font-semibold">País:</span> {{ $pedimento->pais_proveedor ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-b pb-4 bg-slate-50 p-4 rounded-xl">
                <div><span class="text-xs font-bold text-gray-500 uppercase">Valor Comercial:</span> <p class="text-lg font-bold text-slate-900">${{ number_format($pedimento->valor_comercial ?? 0, 2) }} {{ $pedimento->moneda ?? 'USD' }}</p></div>
                <div><span class="text-xs font-bold text-gray-500 uppercase">Tipo de Cambio:</span> <p class="text-lg font-bold text-slate-900">${{ number_format($pedimento->tipo_cambio ?? 1, 4) }}</p></div>
                <div><span class="text-xs font-bold text-gray-500 uppercase">Valor en Aduana:</span> <p class="text-lg font-bold text-blue-900">${{ number_format($pedimento->valor_aduana ?? 0, 2) }} MXN</p></div>
                <div><span class="text-xs font-bold text-gray-500 uppercase">Total Impuestos:</span> <p class="text-lg font-bold text-green-700">${{ number_format($pedimento->total_general ?? 0, 2) }} MXN</p></div>
            </div>

        </div>

    </main>

    <footer class="bg-slate-900/80 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} S-E-P-A - Módulo de Capturista.</p>
    </footer>
</body>
</html>
