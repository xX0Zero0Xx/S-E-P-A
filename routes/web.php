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

require __DIR__.'/auth.php';
