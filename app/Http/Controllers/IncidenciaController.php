<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Importamos Carbon para manejar las fechas simuladas

class IncidenciaController extends Controller
{
    public function index()
    {
        // 1. Jalamos los datos de la sesión
        $rawIncidencias = session('simulador_incidencias', []);

        // 2. Mapeamos cada elemento forzándolo a ser un objeto con fechas Carbon reales
        $mapped = array_map(function($item) {
            $obj = (object) $item;
            
            // Si created_at es un texto, lo transformamos en un objeto Carbon para que funcione ->diffForHumans()
            if (isset($obj->created_at) && is_string($obj->created_at)) {
                $obj->created_at = Carbon::parse($obj->created_at);
            }
            
            return $obj;
        }, $rawIncidencias);

        // 3. Lo envolvemos en una colección de Laravel para tus KPIs
        $incidencias = collect($mapped);
        
        $sucursalesConPlacas = config('flota.sucursales', []);

        return view('ops.muro', compact('incidencias', 'sucursalesConPlacas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sucursal' => 'required|string',
            'descripcion' => 'required|string',
            'urgencia' => 'required',
        ]);

        $incidenciasArray = session('simulador_incidencias', []);

        // Creamos la nueva incidencia guardando la fecha como un string limpio
        $nuevaIncidencia = [
            'id' => count($incidenciasArray) + 1,
            'sucursal' => $request->sucursal,
            'placa' => $request->placa, 
            'urgencia' => $request->urgencia,
            'descripcion' => $request->descripcion,
            'estado' => 'Pendiente',
            'imagen_evidencia' => null, 
            'created_at' => now()->toDateTimeString(), // Guardamos el momento exacto
        ];

        array_unshift($incidenciasArray, $nuevaIncidencia);

        session(['simulador_incidencias' => $incidenciasArray]);

        return back()->with('exito', 'Reporte publicado en el Muro de Operaciones.');
    }
}