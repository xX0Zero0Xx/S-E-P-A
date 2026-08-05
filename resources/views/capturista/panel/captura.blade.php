<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEPA | Captura de Pedimento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // vista perrona de captura por pestañas
        function cambiarPestana(index) {
            document.querySelectorAll('.pestana-contenido').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            document.getElementById('pestana-' + index).classList.remove('hidden');
            const activeBtn = document.getElementById('btn-tab-' + index);
            activeBtn.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
            activeBtn.classList.remove('border-transparent', 'text-gray-500');
        }
    </script>
</head>
<body class="font-sans text-gray-800 flex flex-col min-h-screen relative bg-slate-900">

    <img src="{{ asset('css/Fondo.jpg') }}" alt="Fondo" class="fixed inset-0 w-full h-full object-cover z-0 opacity-20">
    <div class="fixed inset-0 bg-black/60 z-0"></div>

    <!-- Navegación superior -->
    <header class="bg-slate-900/90 backdrop-blur-md text-white shadow-md relative z-10 border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-wide text-blue-400">S.E.P.A.</span>
                <span class="text-xs bg-blue-600 text-white px-2.5 py-0.5 rounded-full font-semibold uppercase">Captura por Pestañas</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- listado de mis pedimentos capturados por el usuario -->
                <a href="{{ route('pedimentos.index') }}" class="px-3.5 py-1.5 text-xs font-medium bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition shadow-sm">
                    Mis Pedimentos
                </a>
                <a href="{{ route('capturista.dashboard') }}" class="px-3.5 py-1.5 text-xs font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition shadow-sm">
                    Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 text-xs font-medium bg-red-600 hover:bg-red-700 text-white rounded-xl transition shadow-sm">
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
            <h1 class="text-2xl font-bold text-slate-900">Módulo 3.1: Captura de Pedimento Aduanal</h1>
            <p class="text-sm text-gray-600">Completa la información organizada en pestañas para realizar el cálculo e inserción automática.</p>
        </div>

        <!-- Formulario por Pestañas -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            
            <!-- Encabezado de Pestañas -->
            <div class="border-b border-gray-200 bg-gray-50 flex overflow-x-auto">
                <button type="button" id="btn-tab-1" onclick="cambiarPestana(1)" class="tab-btn px-6 py-4 border-b-2 font-bold text-sm border-blue-600 text-blue-600 bg-blue-50 focus:outline-none transition whitespace-nowrap">
                    1. Encabezado & Aduana
                </button>
                <button type="button" id="btn-tab-2" onclick="cambiarPestana(2)" class="tab-btn px-6 py-4 border-b-2 font-bold text-sm border-transparent text-gray-500 hover:text-blue-600 focus:outline-none transition whitespace-nowrap">
                    2. Importador & Proveedor
                </button>
                <button type="button" id="btn-tab-3" onclick="cambiarPestana(3)" class="tab-btn px-6 py-4 border-b-2 font-bold text-sm border-transparent text-gray-500 hover:text-blue-600 focus:outline-none transition whitespace-nowrap">
                    3. Valores & Comercial
                </button>
                <button type="button" id="btn-tab-4" onclick="cambiarPestana(4)" class="tab-btn px-6 py-4 border-b-2 font-bold text-sm border-transparent text-gray-500 hover:text-blue-600 focus:outline-none transition whitespace-nowrap">
                    4. Mercancías
                </button>
                <button type="button" id="btn-tab-5" onclick="cambiarPestana(5)" class="tab-btn px-6 py-4 border-b-2 font-bold text-sm border-transparent text-gray-500 hover:text-blue-600 focus:outline-none transition whitespace-nowrap">
                    5. Liquidación & Impuestos
                </button>
            </div>

            <!-- Formulario Principal -->
            <form action="{{ route('pedimentos.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf

                <!-- Pestaña 1: Encabezado -->
                <div id="pestana-1" class="pestana-contenido space-y-6">
                    <h3 class="text-base font-bold text-slate-800 uppercase border-b pb-2">Datos de Encabezado y Aduana (Anexo 22)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Número de Pedimento *</label>
                            <input type="text" name="numero_pedimento" maxlength="15" required placeholder="Ej. 24 47 3820 4001234" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Clave Aduana</label>
                            <select name="clave_aduana" class="w-full rounded-xl border-gray-300 shadow-sm text-sm p-3 border bg-white">
                                <option value="240">240 - Manzanillo, Colima</option>
                                <option value="430">430 - Veracruz, Veracruz</option>
                                <option value="470">470 - AICM (CDMX)</option>
                                <option value="270">270 - Nuevo Laredo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Clave Pedimento</label>
                            <select name="clave_pedimento" class="w-full rounded-xl border-gray-300 shadow-sm text-sm p-3 border bg-white">
                                <option value="A1">A1 - Importación / Exportación Definitiva</option>
                                <option value="IN">IN - Importación Temporal IMMEX</option>
                                <option value="V1">V1 - Transferencia Virtual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Clave Régimen</label>
                            <select name="clave_regimen" class="w-full rounded-xl border-gray-300 shadow-sm text-sm p-3 border bg-white">
                                <option value="IMD">IMD - Definitivo de Importación</option>
                                <option value="EXD">EXD - Definitivo de Exportación</option>
                                <option value="ITR">ITR - Temporal de Importación</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="button" onclick="cambiarPestana(2)" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition text-sm">
                            Siguiente ➡️
                        </button>
                    </div>
                </div>

                <!-- Pestaña 2: Importador & Proveedor -->
                <div id="pestana-2" class="pestana-contenido space-y-6 hidden">
                    <h3 class="text-base font-bold text-slate-800 uppercase border-b pb-2">Importador / Exportador y Proveedor</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">RFC Importador</label>
                            <input type="text" name="rfc_importador" maxlength="13" placeholder="GOMX900101XXX" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Razón Social Importador</label>
                            <input type="text" name="razon_social" maxlength="150" placeholder="Comercializadora Aduanal S.A. de C.V." class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">CURP</label>
                            <input type="text" name="curp" maxlength="18" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Domicilio Fiscal</label>
                            <input type="text" name="domicilio" maxlength="250" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nombre Proveedor</label>
                            <input type="text" name="proveedor" maxlength="100" placeholder="Global Logistics Corp" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Número Factura</label>
                            <input type="text" name="numero_factura" maxlength="30" placeholder="FAC-2026-99" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-gray-100">
                        <button type="button" onclick="cambiarPestana(1)" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-sm">
                            ⬅️ Anterior
                        </button>
                        <button type="button" onclick="cambiarPestana(3)" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition text-sm">
                            Siguiente ➡️
                        </button>
                    </div>
                </div>

                <!-- Pestaña 3: Valores & Comercial -->
                <div id="pestana-3" class="pestana-contenido space-y-6 hidden">
                    <h3 class="text-base font-bold text-slate-800 uppercase border-b pb-2">Valores Comerciales e Incrementables</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Valor Comercial (Moneda Extranjera)</label>
                            <input type="number" step="0.01" name="valor_comercial" placeholder="10000.00" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Moneda</label>
                            <select name="moneda" class="w-full rounded-xl border-gray-300 text-sm p-3 border bg-white">
                                <option value="USD">USD - Dólar Estadounidense</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="MXN">MXN - Peso Mexicano</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tipo de Cambio</label>
                            <input type="number" step="0.0001" name="tipo_cambio" value="20.5000" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Fletes ($)</label>
                            <input type="number" step="0.01" name="fletes" placeholder="500.00" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Seguros ($)</label>
                            <input type="number" step="0.01" name="seguros" placeholder="150.00" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Embalajes ($)</label>
                            <input type="number" step="0.01" name="embalajes" placeholder="50.00" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-gray-100">
                        <button type="button" onclick="cambiarPestana(2)" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-sm">
                            ⬅️ Anterior
                        </button>
                        <button type="button" onclick="cambiarPestana(4)" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition text-sm">
                            Siguiente ➡️
                        </button>
                    </div>
                </div>

                <!-- Pestaña 4: Mercancías -->
                <div id="pestana-4" class="pestana-contenido space-y-6 hidden">
                    <h3 class="text-base font-bold text-slate-800 uppercase border-b pb-2">Descripción de Mercancías</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Descripción de la Mercancía</label>
                            <input type="text" name="descripcion_mercancia" maxlength="250" placeholder="Componentes electrónicos / Maquinaria industrial" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Cantidad</label>
                            <input type="number" name="cantidad" placeholder="100" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Precio Unitario</label>
                            <input type="number" step="0.01" name="precio_unitario" placeholder="100.00" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Peso Bruto (KG)</label>
                            <input type="number" step="0.01" name="peso_bruto" placeholder="450.50" class="w-full rounded-xl border-gray-300 text-sm p-3 border">
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-gray-100">
                        <button type="button" onclick="cambiarPestana(3)" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-sm">
                            ⬅️ Anterior
                        </button>
                        <button type="button" onclick="cambiarPestana(5)" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition text-sm">
                            Siguiente ➡️
                        </button>
                    </div>
                </div>

                <!-- Pestaña 5: Liquidación -->
                <div id="pestana-5" class="pestana-contenido space-y-6 hidden">
                    <h3 class="text-base font-bold text-slate-800 uppercase border-b pb-2">Finalización & Liquidación</h3>
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-900">
                        💡 <strong>Nota del Simulador:</strong> Al guardar el pedimento, la plataforma calculará automáticamente el <strong>Valor en Aduana (MXN)</strong>, el <strong>DTA</strong>, el <strong>IGI</strong> y el <strong>IVA (16%)</strong>.
                    </div>

                    <!-- Botones de Acción -->
                    <!-- chingadera para controlar la insercion en la DB -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <button type="button" onclick="cambiarPestana(4)" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition text-sm">
                            ⬅️ Anterior
                        </button>
                        <button type="submit" class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition text-base">
                            💾 Guardar y Calcular Pedimento
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </main>

    <footer class="bg-slate-900/90 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} S-E-P-A - Módulo de Capturista.</p>
    </footer>
</body>
</html>