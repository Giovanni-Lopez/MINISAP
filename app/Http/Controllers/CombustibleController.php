<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\RegistroCombustible;

class CombustibleController extends Controller
{
    public function index()
    {
        $sucursalesConPlacas = Vehiculo::where('activo', true)
            ->get()
            ->groupBy('sucursal')
            ->map(function ($items) {
                return $items->pluck('placa')->toArray();
            })
            ->toArray();

        $usuariosPorSucursal = [
            'Distribucion' => ['Piloto Distribucion 1', 'Piloto Distribucion 2'],
            'Operaciones' => ['Piloto Operaciones 1', 'Piloto Operaciones 2'],
            'Suc. Ilopango' => ['Piloto Ilopango 1', 'Piloto Ilopango 2'],
            'Suc. Lourdes' => ['Piloto Lourdes 1', 'Piloto Lourdes 2'],
            'Suc. San Salvador' => ['Piloto San Salvador 1', 'Piloto San Salvador 2'],
            'Suc. Santa Ana' => ['Piloto Santa Ana 1', 'Piloto Santa Ana 2'],
        ];

        return view('ops.combustible_sucursal', compact('sucursalesConPlacas', 'usuariosPorSucursal'));
    }

    public function store(Request $request)
    {
        // Validamos usando exactamente los "name" de tu formulario HTML
        $request->validate([
            'sucursal' => 'required|string',
            'fecha' => 'required|date',
            'no_vale' => 'required|integer|min:1', // <-- Validado como no_vale
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
            'no_vale' => $request->no_vale, // <-- Mapeado correctamente
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