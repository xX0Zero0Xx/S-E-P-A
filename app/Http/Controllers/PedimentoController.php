<?php

namespace App\Http\Controllers;

use App\Models\Pedimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedimentoController extends Controller
{
    /**
     * Almacena un nuevo pedimento en la base de datos.
     */
    public function store(Request $request)
    {
        // Control de acceso: Verificar que el usuario tenga sesión activa
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado.');
        }

        $validatedData = $request->validate([
            'numero_pedimento' => 'required|string|max:15|unique:pedimentos,numero_pedimento',
            'tipo_operacion' => 'nullable|integer',
            'tipo_transporte' => 'nullable|integer',
            'clave_pedimento' => 'nullable|string|max:2',
            
            // Datos de Aduana y Régimen
            'clave_aduana' => 'nullable|string|max:3',
            'seccion_aduanera' => 'nullable|string|max:1',
            'denominacion_aduana' => 'nullable|string|max:100',
            'clave_regimen' => 'nullable|string|max:4',
            'descripcion_regimen' => 'nullable|string|max:100',
            'destino' => 'nullable|string|max:150',
            'destino_clave' => 'nullable|string|max:5',

            // Importador / Exportador
            'clave_pais' => 'nullable|string|max:3',
            'nombre_pais' => 'nullable|string|max:80',
            'rfc_importador' => 'nullable|string|max:13',
            'razon_social' => 'nullable|string|max:150',
            'curp' => 'nullable|string|max:18',
            'domicilio' => 'nullable|string|max:250',

            // Valores e Incrementables
            'val_seguros' => 'nullable|numeric',
            'seguros' => 'nullable|numeric',
            'fletes' => 'nullable|numeric',
            'embalajes' => 'nullable|numeric',
            'otros_incrementables' => 'nullable|numeric',

            // Datos del Pedimento y Fechas
            'acuse_electronico' => 'nullable|string|max:100',
            'marcas_bultos' => 'nullable|string|max:200',
            'fecha_entrada' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'fecha_emision' => 'nullable|date',
            'tasa_pedimento' => 'nullable|string|max:100',
            'tipo_cambio' => 'nullable|numeric',
            'peso_bruto' => 'nullable|numeric',
            'valor_dolares' => 'nullable|numeric',
            'valor_aduana' => 'nullable|numeric',
            'precio_pagado' => 'nullable|numeric',

            // Datos de la Factura y Proveedor
            'numero_factura' => 'nullable|string|max:30',
            'fecha_factura' => 'nullable|date',
            'proveedor' => 'nullable|string|max:100',
            'valor_comercial' => 'nullable|numeric',
            'moneda' => 'nullable|string|max:10',
            'estatus_pago' => 'nullable|in:Adeudo,Liquidado',
            'tipo_factura' => 'nullable|string|max:20',
            'pais_proveedor' => 'nullable|string|max:80',
            'direccion_proveedor' => 'nullable|string|max:200',
            'ciudad_proveedor' => 'nullable|string|max:100',

            // Datos de la Mercancía
            'descripcion_mercancia' => 'nullable|string|max:250',
            'cantidad' => 'nullable|integer',
            'precio_unitario' => 'nullable|numeric',
            'importe_total' => 'nullable|numeric',

            // Transportes
            'transporte_entrada_salida' => 'nullable|integer',
            'transporte_arribo' => 'nullable|integer',
            'transporte_salida' => 'nullable|integer',

            // Contribuciones y Totales
            'contribucion' => 'nullable|string|max:50',
            'fp' => 'nullable|string|max:10',
            'importe_contribucion' => 'nullable|numeric',
            'efectivo' => 'nullable|numeric',
            'otros_totales' => 'nullable|numeric',
            'total_general' => 'nullable|numeric',
        ]);

        // Asignar obligatoriamente el ID del usuario autenticado
        $validatedData['user_id'] = Auth::id();

        // chingadera para controlar la insercion en la DB
        Pedimento::create($validatedData);

        return redirect()->back()->with('success', 'Pedimento registrado correctamente.');
    }
}