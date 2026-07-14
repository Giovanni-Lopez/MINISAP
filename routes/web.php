<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\Auth;

// Redirección automática: Si alguien entra a la raíz (/), mandarlo directamente al Login
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// RUTAS PROTEGIDAS (Requieren inicio de sesión)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // 1. Ruta para ENTRAR y ver el Muro de Lamentos
    Route::get('/muro', [IncidenciaController::class, 'index'])->name('muro.index');

    // 2. Ruta para RECIBIR los datos del formulario al dar click en "Publicar"
    Route::post('/incidencias/store', [IncidenciaController::class, 'store']);
    
    // Asegúrate de que termine con ->name('incidencias.store')
    Route::post('/incidencias/store', [IncidenciaController::class, 'store'])->name('incidencias.store');
    
    // 3. Ruta para Cerrar Sesión (¡Súper útil para la expo!)
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

});

// ==========================================
// RUTAS PÚBLICAS (Login)
// ==========================================

// Ruta para ver la pantalla de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Ruta para procesar el inicio de sesión en routes/web.php
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credenciales = $request->only('email', 'password');

    if (Auth::attempt($credenciales)) {
        $request->session()->regenerate();
        
        // Redirección directa y forzada a la URL activa de Codespaces
        return redirect(url('/muro'));
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
});

// Rutas para el Registro de Combustible
Route::get('/combustible', function () {
    // Heredamos los mismos datos de flota que ya tienes en tu controlador
    $sucursalesConPlacas = config('flota.sucursales', []);
    $usuariosPorSucursal = config('flota.usuarios', []); // <-- ¡Leído directamente desde el archivo flota!
    return view('ops.combustible_sucursal', compact('sucursalesConPlacas', 'usuariosPorSucursal'));
})->middleware('auth');

Route::post('/combustible/store', function (\Illuminate\Http\Request $request) {
    // Por ahora redirecciona con éxito para simular el guardado en tu entrega
    return redirect()->back()->with('exito', '¡Registro de Combustible guardado con éxito!');
})->name('combustible.store');


// Rutas para el Registro de Kilometraje Diario
Route::get('/km-diarios', function () {
    $sucursalesConPlacas = config('flota.sucursales', []);
    return view('ops.km_sucursal', compact('sucursalesConPlacas'));
})->middleware('auth');

Route::post('/km-diarios/store', function (\Illuminate\Http\Request $request) {
    return redirect()->back()->with('exito', '¡Registro de Kilometraje guardado con éxito!');
})->name('km.store');

Route::post('/incidencias/{id}/actualizar', [App\Http\Controllers\IncidenciaController::class, 'update'])->name('incidencias.update');