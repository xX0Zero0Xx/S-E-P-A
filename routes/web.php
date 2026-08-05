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

Route::middleware(['auth', CheckRol::class . ':administrador'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
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

Route::middleware(['auth', 'verified', CheckRol::class . ':capturista'])->group(function () {
    Route::get('/pedimentos', [PedimentoController::class, 'index'])->name('pedimentos.index');
    Route::get('/pedimentos/{id}', [PedimentoController::class, 'show'])->name('pedimentos.show');
    Route::get('/pedimentos/{id}/pdf', [PedimentoController::class, 'pdf'])->name('pedimentos.pdf');
});
