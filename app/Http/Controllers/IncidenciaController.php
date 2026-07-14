<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia; // <--- IMPORTAMOS TU MODELO REAL
use Carbon\Carbon;

class IncidenciaController extends Controller
{
    public function index()
{
    // 1. Jalamos TODAS las incidencias reales ordenadas desde la base de datos (Railway)
    $incidencias = Incidencia::orderBy('created_at', 'desc')->get();

    // Obtenemos todos los vehículos de la base de datos agrupados por su sucursal
    $sucursalesConPlacas = \App\Models\Vehiculo::all()
        ->groupBy('sucursal')
        ->map(function ($items) {
            return $items->pluck('placa')->toArray();
        })
        ->toArray();

    // 🌟 NUEVO: Calculamos los conteos para las 5 tarjetas usando los estados reales de la BD
    $pendientes = Incidencia::where('estado', 'Pendiente')->count();
    $enProceso = Incidencia::where('estado', 'En Revisión')->count(); // Si tu "tercero" guarda 'En Revisión' o 'Proceso'
    $finalizados = Incidencia::where('estado', 'Resuelto')->count();

    // Contador de alertas de combustible (por ejemplo, incidencias con urgencia 'Alta' o 'Crítica')
    $alertasCombustible = Incidencia::where('urgencia', 'Crítica')->count();

    // 2. Si el usuario es de Sucursal, cargamos su plantilla exclusiva
    if (auth()->user()->role === 'user' || auth()->user()->role === 'sucursal') {
        return view('ops.muro_sucursal', compact('sucursalesConPlacas'));
    }

    // 3. Si es Administrador, se carga el muro completo enviando también los contadores
    return view('ops.muro', compact(
        'incidencias', 
        'sucursalesConPlacas', 
        'pendientes', 
        'enProceso', 
        'finalizados', 
        'alertasCombustible'
    ));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,En Revisión,Resuelto',
            'comentarios' => 'nullable|string|max:1000'
        ]);

        $incidencia = Incidencia::findOrFail($id);
        $incidencia->estado = $request->estado;
        
        // Si tu tabla de incidencias ya tiene un campo para notas, comentarios o bitácora, lo guardamos.
        // Si no lo tiene, podemos guardar temporalmente el comentario o puedes crear la columna en la BD.
        if (\Schema::hasColumn('incidencias', 'comentarios')) {
            $incidencia->comentarios = $request->comentarios;
        }

        $incidencia->save();

        return redirect()->back()->with('success', '¡Registro actualizado con éxito!');
    }


}