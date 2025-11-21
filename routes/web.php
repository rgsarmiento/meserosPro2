<?php

use App\Http\Controllers\MeseroController;
use Illuminate\Support\Facades\Route;

// Ruta principal: Login de meseros
Route::get('/', [MeseroController::class, 'login'])->name('login');
Route::post('/login', [MeseroController::class, 'authenticate'])->name('authenticate');

// Rutas protegidas para meseros
Route::middleware('mesero')->group(function () {
    Route::get('/mesas', [MeseroController::class, 'mesas'])->name('mesas');
    Route::get('/mesa/{id}/menu', [MeseroController::class, 'menu'])->name('menu');
    Route::post('/mesa/{id}/orden', [MeseroController::class, 'crearOrden'])->name('crear.orden');
    Route::get('/historial', [MeseroController::class, 'historial'])->name('historial');
    Route::get('/logout', [MeseroController::class, 'logout'])->name('logout');
});
