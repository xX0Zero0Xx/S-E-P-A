<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedimento;
use App\Services\CalculoPedimentoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiPedimentoController extends Controller
{
    protected CalculoPedimentoService $calculoService;

    public function __construct(CalculoPedimentoService $calculoService)
    {
        $this->calculoService = $calculoService;
    }

    /**
     * Listado de pedimentos en formato JSON (GET).
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = Pedimento::query();
        if ($user->rol !== 'administrador') {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('numero_pedimento', 'like', "%{$buscar}%")
                    ->orWhere('rfc_importador', 'like', "%{$buscar}%")
                    ->orWhere('razon_social', 'like', "%{$buscar}%");
            });
        }

        $pedimentos = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data'   => $pedimentos,
        ], 200);
    }

    /**
     * Almacena un nuevo pedimento (POST).
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'numero_pedimento' => 'required|string|max:15|unique:pedimentos,numero_pedimento',
            'tipo_operacion' => 'nullable|integer',
            'tipo_transporte' => 'nullable|integer',
            'clave_pedimento' => 'nullable|string|max:2',
            'clave_aduana' => 'nullable|string|max:3',
            'seccion_aduanera' => 'nullable|string|max:1',
            'denominacion_aduana' => 'nullable|string|max:100',
            'clave_regimen' => 'nullable|string|max:4',
            'descripcion_regimen' => 'nullable|string|max:100',
            'destino' => 'nullable|string|max:150',
            'destino_clave' => 'nullable|string|max:5',
            'clave_pais' => 'nullable|string|max:3',
            'nombre_pais' => 'nullable|string|max:80',
            'rfc_importador' => 'nullable|string|max:13',
            'razon_social' => 'nullable|string|max:150',
            'curp' => 'nullable|string|max:18',
            'domicilio' => 'nullable|string|max:250',
            'val_seguros' => 'nullable|numeric',
            'seguros' => 'nullable|numeric',
            'fletes' => 'nullable|numeric',
            'embalajes' => 'nullable|numeric',
            'otros_incrementables' => 'nullable|numeric',
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
            'descripcion_mercancia' => 'nullable|string|max:250',
            'cantidad' => 'nullable|integer',
            'precio_unitario' => 'nullable|numeric',
            'importe_total' => 'nullable|numeric',
            'transporte_entrada_salida' => 'nullable|integer',
            'transporte_arribo' => 'nullable|integer',
            'transporte_salida' => 'nullable|integer',
            'contribucion' => 'nullable|string|max:50',
            'fp' => 'nullable|string|max:10',
            'importe_contribucion' => 'nullable|numeric',
            'efectivo' => 'nullable|numeric',
            'otros_totales' => 'nullable|numeric',
            'total_general' => 'nullable|numeric',
        ]);

        $validatedData['user_id'] = $user->id;

        if (!empty($validatedData['valor_comercial'])) {
            $calculos = $this->calculoService->calcularTotales($validatedData);
            $validatedData['valor_dolares'] = $validatedData['valor_dolares'] ?? $calculos['valor_dolares'];
            $validatedData['valor_aduana'] = $validatedData['valor_aduana'] ?? $calculos['valor_aduana'];
            $validatedData['precio_pagado'] = $validatedData['precio_pagado'] ?? $calculos['precio_pagado'];
            $validatedData['importe_contribucion'] = $validatedData['importe_contribucion'] ?? $calculos['importe_contribucion'];
            $validatedData['efectivo'] = $validatedData['efectivo'] ?? $calculos['efectivo'];
            $validatedData['total_general'] = $validatedData['total_general'] ?? $calculos['total_general'];
        }

        $pedimento = Pedimento::create($validatedData);

        Log::channel('audit')->info('Pedimento creado vía API', [
            'numero_pedimento' => $pedimento->numero_pedimento,
            'user_id'          => $user->id,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pedimento registrado y calculado correctamente.',
            'data'    => $pedimento,
        ], 201);
    }

    /**
     * Muestra el detalle de un pedimento (GET).
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $pedimento = Pedimento::find($id);

        if (!$pedimento) {
            return response()->json(['message' => 'Pedimento no encontrado.'], 404);
        }

        $user = $request->user();
        if ($user->rol !== 'administrador' && $pedimento->user_id !== $user->id) {
            return response()->json(['message' => 'Acceso denegado.'], 403);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $pedimento,
        ], 200);
    }

    /**
     * Actualiza un pedimento (PUT/PATCH).
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $pedimento = Pedimento::find($id);

        if (!$pedimento) {
            return response()->json(['message' => 'Pedimento no encontrado.'], 404);
        }

        $user = $request->user();
        if ($user->rol !== 'administrador' && $pedimento->user_id !== $user->id) {
            return response()->json(['message' => 'Acceso denegado.'], 403);
        }

        $validatedData = $request->validate([
            'razon_social' => 'nullable|string|max:150',
            'descripcion_mercancia' => 'nullable|string|max:250',
            'valor_comercial' => 'nullable|numeric',
        ]);

        $pedimento->update($validatedData);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pedimento actualizado correctamente.',
            'data'    => $pedimento,
        ], 200);
    }

    /**
     * Elimina un pedimento (DELETE).
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $pedimento = Pedimento::find($id);

        if (!$pedimento) {
            return response()->json(['message' => 'Pedimento no encontrado.'], 404);
        }

        $user = $request->user();
        if ($user->rol !== 'administrador' && $pedimento->user_id !== $user->id) {
            return response()->json(['message' => 'Acceso denegado.'], 403);
        }

        $pedimento->delete();

        Log::channel('audit')->info('Pedimento eliminado vía API', [
            'pedimento_id' => $id,
            'user_id'      => $user->id,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pedimento eliminado correctamente.',
        ], 200);
    }
}
