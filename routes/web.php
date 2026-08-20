<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\CombustibleController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AsignacionFlotaController;
use App\Http\Controllers\KmDiarioController;
use App\Http\Controllers\UserController;

// Redirección inicial
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// RUTAS PÚBLICAS (Autenticación)
// ==========================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credenciales = $request->only('email', 'password');

    if (Auth::attempt($credenciales)) {
        $request->session()->regenerate();
        return redirect(url('/muro'));
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
});


// ==========================================
// RUTAS PROTEGIDAS (Requieren sesión activa)
// ==========================================
Route::middleware('auth')->group(function () {

    // Cerrar Sesión
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // 1. Muro de Lamentos / Incidencias
    Route::get('/muro', [IncidenciaController::class, 'index'])->name('muro.index');
    Route::post('/incidencias/store', [IncidenciaController::class, 'store'])->name('incidencias.store');
    Route::post('/incidencias/{id}/actualizar', [IncidenciaController::class, 'update'])->name('incidencias.update');

    // 2. Cuentas de Acceso al Sistema (Login, Passwords y Roles)
    Route::get('/gestion-usuarios', [UserController::class, 'index'])->name('gestion-usuarios.index');
    Route::get('/gestion-usuarios/nuevo', [UserController::class, 'create'])->name('gestion-usuarios.create');
    Route::post('/gestion-usuarios', [UserController::class, 'store'])->name('gestion-usuarios.store');

    // 3. Cuentas de Acceso al Sistema (Solo Administradores)   
    Route::middleware(['auth'])->group(function () {
        Route::group(['middleware' => function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                return redirect('/muro')->with('error', 'No tienes permisos para acceder a este módulo.');
            }
            return $next($request);
        }], function () {
            Route::get('/gestion-usuarios', [UserController::class, 'index'])->name('gestion-usuarios.index');
            Route::get('/gestion-usuarios/nuevo', [UserController::class, 'create'])->name('gestion-usuarios.create');
            Route::post('/gestion-usuarios', [UserController::class, 'store'])->name('gestion-usuarios.store');
            Route::put('/gestion-usuarios/{id}', [UserController::class, 'update'])->name('gestion-usuarios.update');
            Route::delete('/gestion-usuarios/{id}', [UserController::class, 'destroy'])->name('gestion-usuarios.destroy');
        });
    });

    // 4. Flota Vehicular
    Route::get('/flota', [VehiculoController::class, 'index'])->name('flota.index');
    Route::post('/flota', [VehiculoController::class, 'store'])->name('flota.store');
    Route::put('/flota/update/{id}', [VehiculoController::class, 'update'])->name('flota.update');
    Route::patch('/flota/{vehiculo}/toggle-estado', [VehiculoController::class, 'toggleEstado'])->name('flota.toggle');
    Route::delete('/flota/{vehiculo}', [VehiculoController::class, 'destroy'])->name('flota.destroy');

    // 5. Control de Sucursales
    Route::get('/sucursales', [SucursalController::class, 'index'])->name('sucursales.index');
    Route::post('/sucursales/registrar', [SucursalController::class, 'store'])->name('sucursales.store');
    Route::put('/sucursales/{id}', [SucursalController::class, 'update'])->name('sucursales.update');
    Route::delete('/sucursales/{id}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');

    // 6. Asignaciones de Flota
    Route::get('/asignaciones-flota', [AsignacionFlotaController::class, 'index'])->name('asignaciones.index');
    Route::post('/asignaciones-flota', [AsignacionFlotaController::class, 'store'])->name('asignaciones.store');
    Route::post('/asignaciones-flota/liberar/{id}', [AsignacionFlotaController::class, 'liberar'])->name('asignaciones.liberar');

    // 7. Control de Combustible
    Route::get('/combustible', [CombustibleController::class, 'index'])->name('combustible.index');
    Route::post('/combustible/store', [CombustibleController::class, 'store'])->name('combustible.store');
    Route::get('/historial-combustible', [CombustibleController::class, 'historial'])->name('combustible.historial');
    Route::put('/combustible/{id}', [CombustibleController::class, 'update'])->name('combustible.update');
    Route::delete('/combustible/{id}', [CombustibleController::class, 'destroy'])->name('combustible.destroy');

    // 8. Registro de Kilometraje Diario
    Route::get('/km-diarios', [KmDiarioController::class, 'index'])->name('km.index');
    Route::post('/km-diarios', [KmDiarioController::class, 'store'])->name('km.store');

});