<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiPedimentoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Autenticación de API
Route::middleware('throttle:api')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login'])->name('api.login');

    // Rutas protegidas por Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout'])->name('api.logout');

        // CRUD de Pedimentos RESTful (GET, POST, GET {id}, PUT {id}, DELETE {id})
        Route::get('/pedimentos', [ApiPedimentoController::class, 'index'])->name('api.pedimentos.index');
        Route::post('/pedimentos', [ApiPedimentoController::class, 'store'])->name('api.pedimentos.store');
        Route::get('/pedimentos/{id}', [ApiPedimentoController::class, 'show'])->name('api.pedimentos.show');
        Route::put('/pedimentos/{id}', [ApiPedimentoController::class, 'update'])->name('api.pedimentos.update');
        Route::delete('/pedimentos/{id}', [ApiPedimentoController::class, 'destroy'])->name('api.pedimentos.destroy');
    });
});
