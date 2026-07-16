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
        // 1. Validamos los datos y aplicamos la regla 'unique' para la placa
        $request->validate([
            'sucursal' => 'required|string',
            'placa' => 'required|string|unique:vehiculos,placa', // Evita duplicados en la tabla 'vehiculos'
        ], [
            // Personalizamos el mensaje en español para que sea amigable
            'placa.unique' => '¡Error! Esta placa ya se encuentra registrada en el sistema.',
            'placa.required' => 'El número de placa es obligatorio.',
            'sucursal.required' => 'Debes seleccionar una sucursal.',
        ]);

        // 2. Si pasa la validación, se guarda con normalidad
        Vehiculo::create([
            'sucursal' => $request->sucursal,
            'placa' => trim(strtoupper($request->placa)), // Lo guardamos limpio en mayúsculas
            'activo' => true,
        ]);

        return redirect()->back()->with('exito', '¡Unidad registrada con éxito en el sistema!');
    }

    public function toggleEstado(Vehiculo $vehiculo)
    {
        // Cambia de true a false, o de false a true
        $vehiculo->update([
            'activo' => !$vehiculo->activo
        ]);

        $mensaje = $vehiculo->activo ? '¡Unidad reactivada con éxito!' : '¡Unidad dada de baja correctamente!';
        return redirect()->route('flota.index')->with('exito', $mensaje);
    }
}