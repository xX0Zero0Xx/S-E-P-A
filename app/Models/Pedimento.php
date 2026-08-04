<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedimento extends Model
{
    use HasFactory;

    protected $table = 'pedimentos';

    protected $fillable = [
        'numero_pedimento',
        'tipo_operacion',
        'tipo_transporte',
        'clave_pedimento',
        'user_id',

        // Datos de Aduana y Régimen
        'clave_aduana',
        'seccion_aduanera',
        'denominacion_aduana',
        'clave_regimen',
        'descripcion_regimen',
        'destino',
        'destino_clave',

        // Importador / Exportador
        'clave_pais',
        'nombre_pais',
        'rfc_importador',
        'razon_social',
        'curp',
        'domicilio',

        // Valores e Incrementables
        'val_seguros',
        'seguros',
        'fletes',
        'embalajes',
        'otros_incrementables',

        // Datos del Pedimento y Fechas
        'acuse_electronico',
        'marcas_bultos',
        'fecha_entrada',
        'fecha_pago',
        'fecha_emision',
        'tasa_pedimento',
        'tipo_cambio',
        'peso_bruto',
        'valor_dolares',
        'valor_aduana',
        'precio_pagado',

        // Datos de la Factura y Proveedor
        'numero_factura',
        'fecha_factura',
        'proveedor',
        'valor_comercial',
        'moneda',
        'estatus_pago',
        'tipo_factura',
        'pais_proveedor',
        'direccion_proveedor',
        'ciudad_proveedor',

        // Datos de la Mercancía
        'descripcion_mercancia',
        'cantidad',
        'precio_unitario',
        'importe_total',

        // Transportes
        'transporte_entrada_salida',
        'transporte_arribo',
        'transporte_salida',

        // Contribuciones y Totales
        'contribucion',
        'fp',
        'importe_contribucion',
        'efectivo',
        'otros_totales',
        'total_general',
    ];

    /**
     * Relación con el usuario capturista.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}