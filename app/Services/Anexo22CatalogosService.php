<?php

namespace App\Services;

class Anexo22CatalogosService
{
    /**
     * Catálogo perrón de Claves de Pedimento (Anexo 22)
     */
    public static function obtenerClavesPedimento(): array
    {
        return [
            'A1' => 'Importación o exportación definitiva',
            'IN' => 'Importación temporal de bienes para retornar en el mismo estado',
            'AF' => 'Importación temporal de activo fijo por empresas IMMEX',
            'V1' => 'Transferencia de mercancías (virtuales)',
            'RT' => 'Retorno de mercancías elaboradas, transformadas o reparadas',
            'K1' => 'Desaduanamiento libre de equipajes y menajes de casa',
        ];
    }

    /**
     * Catálogo para controlar las aduanas principales de México
     */
    public static function obtenerAduanas(): array
    {
        return [
            '240' => 'Manzanillo, Colima',
            '430' => 'Veracruz, Veracruz',
            '470' => 'Aeropuerto Internacional de la Ciudad de México (AICM)',
            '270' => 'Nuevo Laredo, Tamaulipas',
            '800' => 'Colombia, Nuevo León',
            '160' => 'Ciudad Juárez, Chihuahua',
            '400' => 'Tijuana, Baja California',
        ];
    }

    /**
     * Catálogo de Regímenes Aduaneros
     */
    public static function obtenerRegimenes(): array
    {
        return [
            'IMD' => 'Definitivo de Importación',
            'EXD' => 'Definitivo de Exportación',
            'ITR' => 'Temporal de Importación para Retornar en el mismo estado',
            'RFE' => 'Recinto Fiscalizado Estratégico',
            'DFI' => 'Depósito Fiscal',
        ];
    }

    /**
     * Catálogo de Monedas ISO
     */
    public static function obtenerMonedas(): array
    {
        return [
            'USD' => 'Dólar Estadounidense',
            'MXN' => 'Peso Mexicano',
            'EUR' => 'Euro',
            'CAD' => 'Dólar Canadiense',
            'CNY' => 'Yuan Chino',
        ];
    }
}
