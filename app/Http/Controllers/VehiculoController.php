<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
{
    // Traemos todos los vehículos de la base de datos ordenados
    $vehiculos = Vehiculo::orderBy('sucursal')->orderBy('placa')->get();

    $sucursalesDisponibles = [
        'Distribucion',
        'Operaciones',
        'Suc. Ilopango',
        'Suc. Lourdes',
        'Suc. San Salvador',
        'Suc. Santa Ana'
    ];

    return view('ops.flota', compact('vehiculos', 'sucursalesDisponibles'));
}

    public function store(Request $request)
    {
        $request->validate([
            'sucursal' => 'required|string',
            'placa' => 'required|string|unique:vehiculos,placa',
        ], [
            'placa.unique' => 'Esta placa ya se encuentra registrada en el sistema.',
        ]);

        Vehiculo::create([
            'sucursal' => $request->sucursal,
            'placa' => strtoupper(trim($request->placa)), // Guardar siempre en mayúsculas
        ]);

        return redirect()->route('flota.index')->with('exito', '¡Vehículo registrado correctamente!');
    }
}