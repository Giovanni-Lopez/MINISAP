<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KmDiario;

class KmDiarioController extends Controller
{
   public function index()
{
    // Traemos sucursales con sus vehículos activos
    $sucursales = \App\Models\Sucursal::with(['vehiculos' => function($q) {
        $q->where('activo', true);
    }])->get();

    $sucursalesConPlacas = [];
    foreach ($sucursales as $sucursal) {
        $sucursalesConPlacas[$sucursal->nombre] = $sucursal->vehiculos->map(function($v) {
            return [
                'placa' => $v->placa,
                'texto' => "{$v->placa} - {$v->marca} {$v->modelo} ({$v->anio})"
            ];
        })->toArray();
    }

    return view('ops.km_sucursal', compact('sucursalesConPlacas'));
}

    public function store(Request $request)
    {
        $request->validate([
            'sucursal' => 'required|string',
            'placa' => 'required|string',
            'km_inicial' => 'required|numeric|min:0',
            'km_final' => 'required|numeric|gte:km_inicial',
        ]);

        // Si eligió "OTRO", usamos la placa ingresada a mano
        $placaFinal = ($request->placa === 'OTRO') ? $request->placa_manual : $request->placa;

        KmDiario::create([
            'sucursal' => $request->sucursal,
            'placa' => $placaFinal,
            'km_inicial' => $request->km_inicial,
            'km_final' => $request->km_final,
            'total_recorrido' => $request->km_final - $request->km_inicial,
        ]);

        return redirect()->back()->with('exito', '¡Registro de Kilometraje guardado con éxito!');
    }
}