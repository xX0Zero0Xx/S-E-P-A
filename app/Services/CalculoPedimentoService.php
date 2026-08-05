<?php

namespace App\Services;

class CalculoPedimentoService
{
    /**
     * Tasa estándar de IVA en México (16%)
     */
    public const TASA_IVA = 0.16;

    /**
     * Cuota fija mínima de DTA (Derecho de Trámite Aduanero) aproximada para simulación
     */
    public const DTA_CUOTA_FIJA = 410.00;

    /**
     * chingadera para calcular el valor en aduana y los impuestos del pedimento
     *
     * @param array $datos
     * @return array
     */
    public function calcularTotales(array $datos): array
    {
        $valorComercial = floatval($datos['valor_comercial'] ?? 0);
        $tipoCambio = floatval($datos['tipo_cambio'] ?? 1);
        if ($tipoCambio <= 0) {
            $tipoCambio = 1.0;
        }

        // fletes, seguros, embalajes y otros incrementables en moneda extranjera/pesos
        $fletes = floatval($datos['fletes'] ?? 0);
        $seguros = floatval($datos['seguros'] ?? 0);
        $embalajes = floatval($datos['embalajes'] ?? 0);
        $otrosIncrementables = floatval($datos['otros_incrementables'] ?? 0);

        // chingadera para convertir moneda extranjera a pesos mexicanos
        $valorComercialMXN = $valorComercial * $tipoCambio;
        $incrementablesMXN = ($fletes + $seguros + $embalajes + $otrosIncrementables) * $tipoCambio;

        // Valor en aduana total en MXN
        $valorAduana = $valorComercialMXN + $incrementablesMXN;

        // Cálculo del DTA (Derecho de Trámite Aduanero: 8 al millar o cuota fija)
        // Para simulación usamos 8 al millar sobre valor aduana o la cuota fija mínima
        $dtaCalculado = max(self::DTA_CUOTA_FIJA, round($valorAduana * 0.008, 2));

        // Impuesto General de Importación (IGI / TIGIE) - Simulación promedio 5%
        $igi = round($valorAduana * 0.05, 2);

        // Base gravable del IVA = Valor en Aduana + DTA + IGI
        $baseIva = $valorAduana + $dtaCalculado + $igi;
        $iva = round($baseIva * self::TASA_IVA, 2);

        // Total de contribuciones a pagar
        $importeContribucion = $dtaCalculado + $igi + $iva;
        $totalEfectivo = $importeContribucion;
        $totalGeneral = $valorAduana + $totalEfectivo;

        return [
            'valor_dolares' => round($valorComercial, 2),
            'valor_aduana' => round($valorAduana, 2),
            'precio_pagado' => round($valorComercialMXN, 2),
            'importe_contribucion' => round($importeContribucion, 2),
            'efectivo' => round($totalEfectivo, 2),
            'total_general' => round($totalGeneral, 2),
            'desglose_impuestos' => [
                'dta' => $dtaCalculado,
                'igi' => $igi,
                'iva' => $iva,
            ],
        ];
    }
}
