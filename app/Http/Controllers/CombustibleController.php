<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\RegistroCombustible;

class CombustibleController extends Controller
{
    public function index()
    {
        // 1. Cargar sucursales con SUS vehículos asociados activos
        $sucursales = \App\Models\Sucursal::with(['vehiculos' => function($q) {
            $q->where('activo', true);
        }])->get();

        // 2. Mapeamos cada sucursal ÚNICAMENTE con sus placas correspondientes
        $sucursalesConPlacas = [];
        foreach ($sucursales as $sucursal) {
            $sucursalesConPlacas[$sucursal->nombre] = $sucursal->vehiculos->pluck('placa')->toArray();
        }

        // 3. Jalamos los conductores activos uniendo Nombres y Apellidos
        $conductoresReales = \App\Models\Conductor::where('activo', true)
            ->get()
            ->map(function ($conductor) {
                return trim($conductor->nombres . ' ' . $conductor->apellidos);
            })
            ->toArray();

        // 4. Mapeamos los conductores por sucursal
        $usuariosPorSucursal = [];
        foreach ($sucursales as $sucursal) {
            $usuariosPorSucursal[$sucursal->nombre] = $conductoresReales;
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