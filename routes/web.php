<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRol;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\AdminController;

Route::middleware(['auth', CheckRol::class . ':administrador'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Gestión de usuarios
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::post('/usuarios', [AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
    Route::put('/usuarios/{id}', [AdminController::class, 'updateUsuario'])->name('admin.usuarios.update');
    Route::delete('/usuarios/{id}', [AdminController::class, 'destroyUsuario'])->name('admin.usuarios.destroy');

    // Métricas y Pedimentos Totales
    Route::get('/metricas', [AdminController::class, 'metricas'])->name('admin.metricas');

    // Auditoría y Seguridad
    Route::get('/auditoria', [AdminController::class, 'auditoria'])->name('admin.auditoria');
});

Route::middleware(['auth', CheckRol::class . ':capturista'])->prefix('capturista')->group(function () {
    Route::get('/dashboard', function () {
        return view('capturista.dashboard');
    })->name('capturista.dashboard');
});

use App\Http\Controllers\PedimentoController;

// ruta para el login y archivos de autenticación del sistema
require __DIR__ . '/auth.php';

// Rutas protegidas para capturistas (requiere autenticación y verificación)
Route::middleware(['auth', 'verified', CheckRol::class . ':capturista'])->group(function () {
    Route::get('/captura', function () {
        return view('capturista.panel.captura');
    })->name('captura');

    // chingadera para controlar la insercion en la DB (Ruta protegida para almacenar pedimentos)
    Route::post('/pedimentos', [PedimentoController::class, 'store'])->name('pedimentos.store');
});

Route::middleware(['auth', 'verified', CheckRol::class . ':capturista,administrador'])->group(function () {
    Route::get('/pedimentos', [PedimentoController::class, 'index'])->name('pedimentos.index');
    Route::get('/pedimentos/{id}', [PedimentoController::class, 'show'])->name('pedimentos.show');
    Route::get('/pedimentos/{id}/pdf', [PedimentoController::class, 'pdf'])->name('pedimentos.pdf');
});

Route::delete('/pedimentos/{pedimento}', [PedimentoController::class, 'destroy'])
    ->name('pedimentos.destroy');
