<?php

use App\Http\Controllers\MeseroController;
use App\Http\Controllers\CocinaController;
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

// Rutas para cocina (accesibles sin autenticación de mesero)
Route::prefix('cocina')->name('cocina.')->group(function () {
    Route::get('/', [CocinaController::class, 'index'])->name('index');
    Route::post('/detalle/{id}/estado', [CocinaController::class, 'cambiarEstado'])->name('cambiar-estado');
    Route::get('/ordenes', [CocinaController::class, 'getOrdenes'])->name('get-ordenes');
});
