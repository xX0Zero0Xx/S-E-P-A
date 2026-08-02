<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedimentos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_pedimento', 15)->unique();
            $table->tinyInteger('tipo_operacion')->nullable();
            $table->tinyInteger('tipo_transporte')->nullable();
            $table->char('clave_pedimento', 2)->nullable();
            
            // Relación directa con la tabla 'users' de Laravel
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Datos de Aduana y Régimen
            $table->char('clave_aduana', 3)->nullable();
            $table->char('seccion_aduanera', 1)->nullable();
            $table->string('denominacion_aduana', 100)->nullable();
            $table->char('clave_regimen', 4)->nullable();
            $table->string('descripcion_regimen', 100)->nullable();
            $table->string('destino', 150)->nullable();
            $table->string('destino_clave', 5)->nullable();

            // Importador / Exportador
            $table->char('clave_pais', 3)->nullable();
            $table->string('nombre_pais', 80)->nullable();
            $table->string('rfc_importador', 13)->nullable();
            $table->string('razon_social', 150)->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('domicilio', 250)->nullable();

            // Valores e Incrementables
            $table->decimal('val_seguros', 12, 2)->nullable();
            $table->decimal('seguros', 12, 2)->nullable();
            $table->decimal('fletes', 12, 2)->nullable();
            $table->decimal('embalajes', 12, 2)->nullable();
            $table->decimal('otros_incrementables', 12, 2)->nullable();

            // Datos del Pedimento y Fechas
            $table->string('acuse_electronico', 100)->nullable();
            $table->string('marcas_bultos', 200)->nullable();
            $table->date('fecha_entrada')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->date('fecha_emision')->nullable(); // Corregido el typo "emicion"
            $table->string('tasa_pedimento', 100)->nullable();
            $table->decimal('tipo_cambio', 10, 5)->nullable();
            $table->decimal('peso_bruto', 12, 2)->nullable();
            $table->decimal('valor_dolares', 12, 2)->nullable();
            $table->decimal('valor_aduana', 12, 2)->nullable();
            $table->decimal('precio_pagado', 12, 2)->nullable();

            // Datos de la Factura y Proveedor
            $table->string('numero_factura', 30)->nullable();
            $table->date('fecha_factura')->nullable();
            $table->string('proveedor', 100)->nullable();
            $table->decimal('valor_comercial', 12, 2)->nullable();
            $table->string('moneda', 10)->nullable();
            $table->enum('estatus_pago', ['Adeudo', 'Liquidado'])->default('Adeudo');
            $table->string('tipo_factura', 20)->nullable();
            $table->string('pais_proveedor', 80)->nullable();
            $table->string('direccion_proveedor', 200)->nullable();
            $table->string('ciudad_proveedor', 100)->nullable();

            // Datos de la Mercancía
            $table->string('descripcion_mercancia', 250)->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_unitario', 12, 2)->nullable();
            $table->decimal('importe_total', 12, 2)->nullable();

            // Transportes
            $table->tinyInteger('transporte_entrada_salida')->nullable();
            $table->tinyInteger('transporte_arribo')->nullable();
            $table->tinyInteger('transporte_salida')->nullable();

            // Contribuciones y Totales
            $table->string('contribucion', 50)->nullable();
            $table->string('fp', 10)->nullable();
            $table->decimal('importe_contribucion', 12, 2)->nullable();
            $table->decimal('efectivo', 12, 2)->nullable();
            $table->decimal('otros_totales', 12, 2)->nullable();
            $table->decimal('total_general', 12, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedimentos');
    }
};