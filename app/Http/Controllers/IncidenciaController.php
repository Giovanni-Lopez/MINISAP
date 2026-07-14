<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia; // <--- IMPORTAMOS TU MODELO REAL
use Carbon\Carbon;

class IncidenciaController extends Controller
{
    public function index()
    {
        // 1. Jalamos TODAS las incidencias reales ordenadas desde la base de datos
        $incidencias = Incidencia::orderBy('created_at', 'desc')->get();
        
        $sucursalesConPlacas = config('flota.sucursales', []);

        // 🌟 2. Si el usuario es de Sucursal, cargamos su plantilla exclusiva
        // Nota: Asegúrate de que el rol guardado en tu base de datos coincida con 'user' o 'sucursal'
        if (auth()->user()->role === 'user' || auth()->user()->role === 'sucursal') {
            return view('ops.muro_sucursal', compact('sucursalesConPlacas'));
        }

        // 3. Si es Administrador, se carga el muro completo con el feed histórico real
        return view('ops.muro', compact('incidencias', 'sucursalesConPlacas'));
    }

    public function store(Request $request)
    {
        // 1. Validamos los datos reales que llegan del formulario
        $request->validate([
            'sucursal' => 'required|string',
            'descripcion' => 'required|string',
            'urgencia' => 'required',
        ]);

        // 2. Guardamos la incidencia DIRECTO en tu base de datos de Railway
        Incidencia::create([
            'sucursal' => $request->sucursal,
            'placa' => $request->placa, 
            'urgencia' => $request->urgencia,
            'descripcion' => $request->descripcion,
            'estado' => 'Pendiente', // Estado por defecto
            'imagen_evidencia' => null, // De momento null, luego puedes procesar archivos si lo requieres
        ]);

        // 3. Redireccionamos con el mensaje de éxito
        return back()->with('exito', 'Reporte publicado en el Muro de Operaciones y guardado en la Base de Datos.');
    }
}