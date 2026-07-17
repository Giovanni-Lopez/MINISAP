<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\RegistroCombustible;

class CombustibleController extends Controller
{
    public function index()
    {
        // 1. Traemos de forma dinámica las sucursales y las placas reales de la BD
        $nombresSucursales = \App\Models\Sucursal::pluck('nombre')->toArray();
        $placasVehiculos = \App\Models\Vehiculo::pluck('placa')->toArray();

        // 2. Mapeamos las sucursales con todas las placas reales
        $sucursalesConPlacas = [];
        foreach ($nombresSucursales as $sucursal) {
            $sucursalesConPlacas[$sucursal] = $placasVehiculos;
        }

        // 3. ¡CONECTADO CON TU MODELO! Jalamos los conductores activos uniendo Nombres y Apellidos
        $conductoresReales = \App\Models\Conductor::where('activo', true)
            ->get()
            ->map(function ($conductor) {
                return trim($conductor->nombres . ' ' . $conductor->apellidos);
            })
            ->toArray();

        // 4. Mapeamos para que cualquier sucursal tenga acceso a la lista real de conductores
        $usuariosPorSucursal = [];
        foreach ($nombresSucursales as $sucursal) {
            $usuariosPorSucursal[$sucursal] = $conductoresReales;
        }

        return view('ops.combustible_sucursal', compact('sucursalesConPlacas', 'usuariosPorSucursal'));
    }

    public function store(Request $request)
    {
        // Validamos usando exactamente los "name" de tu formulario HTML
        $request->validate([
            'sucursal' => 'required|string',
            'fecha' => 'required|date',
            'no_vale' => 'required|integer|min:1', 
            'placa' => 'required|string',
            'usuario' => 'required|string',
            'precio_galon' => 'required|numeric|min:0.01',
            'galonaje' => 'required|numeric|min:0.01',
            'tipo_gas' => 'required|string',
            'kilometraje' => 'required|integer|min:0',
            'area' => 'required|string',
        ]);

        $totalCarga = $request->precio_galon * $request->galonaje;

        // Guardamos en la base de datos de Railway
        RegistroCombustible::create([
            'sucursal' => $request->sucursal,
            'fecha' => $request->fecha,
            'no_vale' => $request->no_vale, 
            'placa' => $request->placa,
            'usuario' => $request->usuario,
            'precio_galon' => $request->precio_galon,
            'galonaje' => $request->galonaje,
            'total_carga' => $totalCarga,
            'tipo_gas' => $request->tipo_gas,
            'kilometraje' => $request->kilometraje,
            'area' => $request->area,
        ]);

        return redirect()->back()->with('exito', '¡Registro de Combustible guardado con éxito!');
    }
}