<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidenciaController;

// Ruta para ver el Muro de Lamentos
Route::get('/', [IncidenciaController::class, 'index'])->name('incidencias.index');

// Ruta para procesar el formulario cuando se publica una queja
Route::post('/muro', [IncidenciaController::class, 'store'])->name('incidencias.store');