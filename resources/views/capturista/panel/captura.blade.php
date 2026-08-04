<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEPA | Captura</title>
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
                <a href="{{ route('capturista.dashboard') }}" class="px-3 py-1.5 text-xs font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-sm">
                    Volver al Dashboard
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
        
        <!-- Tarjeta de Bienvenida -->
        <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-white/20">
            <h1 class="text-2xl font-bold text-slate-900">Módulo de Captura</h1>
            <p class="text-sm text-gray-600">Área de trabajo para la generación y consulta de pedimentos aduanales.</p>
        </div>

        <!-- Formulario de Captura de Pedimento -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 md:p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 border-b pb-3 border-gray-200">Captura de Pedimento</h2>

            <form action="{{ route('pedimentos.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Generalidades -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">1. Datos Generales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Número de Pedimento *</label>
                            <input type="text" name="numero_pedimento" maxlength="15" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Tipo Operación</label>
                            <input type="number" name="tipo_operacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Tipo Transporte</label>
                            <input type="number" name="tipo_transporte" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Clave Pedimento</label>
                            <input type="text" name="clave_pedimento" maxlength="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Aduana y Régimen -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">2. Aduana y Régimen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Clave Aduana</label>
                            <input type="text" name="clave_aduana" maxlength="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Sección Aduanera</label>
                            <input type="text" name="seccion_aduanera" maxlength="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Denominación Aduana</label>
                            <input type="text" name="denominacion_aduana" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Clave Régimen</label>
                            <input type="text" name="clave_regimen" maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700">Descripción Régimen</label>
                            <input type="text" name="descripcion_regimen" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Destino</label>
                            <input type="text" name="destino" maxlength="150" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Clave Destino</label>
                            <input type="text" name="destino_clave" maxlength="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Importador / Exportador -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">3. Importador / Exportador</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Clave País</label>
                            <input type="text" name="clave_pais" maxlength="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Nombre País</label>
                            <input type="text" name="nombre_pais" maxlength="80" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">RFC Importador</label>
                            <input type="text" name="rfc_importador" maxlength="13" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">CURP</label>
                            <input type="text" name="curp" maxlength="18" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700">Razón Social</label>
                            <input type="text" name="razon_social" maxlength="150" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700">Domicilio</label>
                            <input type="text" name="domicilio" maxlength="250" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Valores e Incrementables -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">4. Valores e Incrementables</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Val. Seguros</label>
                            <input type="number" step="0.01" name="val_seguros" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Seguros</label>
                            <input type="number" step="0.01" name="seguros" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Fletes</label>
                            <input type="number" step="0.01" name="fletes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Embalajes</label>
                            <input type="number" step="0.01" name="embalajes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Otros Incrementables</label>
                            <input type="number" step="0.01" name="otros_incrementables" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Datos del Pedimento y Fechas -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">5. Datos Generales del Pedimento y Fechas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Acuse Electrónico</label>
                            <input type="text" name="acuse_electronico" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Fecha Entrada</label>
                            <input type="date" name="fecha_entrada" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Fecha Pago</label>
                            <input type="date" name="fecha_pago" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Fecha Emisión</label>
                            <input type="date" name="fecha_emision" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Tasa Pedimento</label>
                            <input type="text" name="tasa_pedimento" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Tipo Cambio</label>
                            <input type="number" step="0.00001" name="tipo_cambio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Peso Bruto</label>
                            <input type="number" step="0.01" name="peso_bruto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Valor Dólares</label>
                            <input type="number" step="0.01" name="valor_dolares" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Valor Aduana</label>
                            <input type="number" step="0.01" name="valor_aduana" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Precio Pagado</label>
                            <input type="number" step="0.01" name="precio_pagado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700">Marcas / Bultos</label>
                            <input type="text" name="marcas_bultos" maxlength="200" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Datos Factura y Proveedor -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">6. Factura y Proveedor</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Número Factura</label>
                            <input type="text" name="numero_factura" maxlength="30" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Fecha Factura</label>
                            <input type="date" name="fecha_factura" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Proveedor</label>
                            <input type="text" name="proveedor" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Valor Comercial</label>
                            <input type="number" step="0.01" name="valor_comercial" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Moneda</label>
                            <input type="text" name="moneda" maxlength="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Estatus Pago</label>
                            <select name="estatus_pago" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border bg-white">
                                <option value="Adeudo">Adeudo</option>
                                <option value="Liquidado">Liquidado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Tipo Factura</label>
                            <input type="text" name="tipo_factura" maxlength="20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">País Proveedor</label>
                            <input type="text" name="pais_proveedor" maxlength="80" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700">Dirección Proveedor</label>
                            <input type="text" name="direccion_proveedor" maxlength="200" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Ciudad Proveedor</label>
                            <input type="text" name="ciudad_proveedor" maxlength="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Datos de la Mercancía -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">7. Datos de la Mercancía</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div class="md:col-span-4">
                            <label class="block text-xs font-medium text-gray-700">Descripción Mercancía</label>
                            <input type="text" name="descripcion_mercancia" maxlength="250" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Precio Unitario</label>
                            <input type="number" step="0.01" name="precio_unitario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Importe Total</label>
                            <input type="number" step="0.01" name="importe_total" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Transportes -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">8. Transportes</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Transporte Entrada / Salida</label>
                            <input type="number" name="transporte_entrada_salida" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Transporte Arribo</label>
                            <input type="number" name="transporte_arribo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Transporte Salida</label>
                            <input type="number" name="transporte_salida" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Contribuciones y Totales -->
                <section>
                    <h3 class="text-base font-semibold text-blue-800 mb-4 uppercase tracking-wider">9. Contribuciones y Totales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Contribución</label>
                            <input type="text" name="contribucion" maxlength="50" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">FP (Forma Pago)</label>
                            <input type="text" name="fp" maxlength="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Importe Contribución</label>
                            <input type="number" step="0.01" name="importe_contribucion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Efectivo</label>
                            <input type="number" step="0.01" name="efectivo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Otros Totales</label>
                            <input type="number" step="0.01" name="otros_totales" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Total General</label>
                            <input type="number" step="0.01" name="total_general" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2 border">
                        </div>
                    </div>
                </section>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="reset" class="px-5 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Limpiar Formulario
                    </button>
                    <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-md">
                        Guardar Pedimento
                    </button>
                </div>
            </form>
        </div>

    </main>

    <footer class="bg-slate-900/80 backdrop-blur-md text-gray-400 py-4 text-center text-sm border-t border-slate-800 relative z-10">
        <p>&copy; {{ date('Y') }} S-E-P-A - Todos los derechos reservados.</p>
    </footer>
</body>
</html>