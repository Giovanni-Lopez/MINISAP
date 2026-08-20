<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia; 
use Carbon\Carbon;

class IncidenciaController extends Controller
{
    public function index()
    {
        // 1. Cargar sucursales con vehículos activos
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

        // 2. Datos generales (incidencias y métricas)
        $incidencias = Incidencia::orderBy('created_at', 'desc')->get();
        $pendientes = Incidencia::where('estado', 'Pendiente')->count();
        $enProceso = Incidencia::where('estado', 'En Revisión')->count(); 
        $finalizados = Incidencia::where('estado', 'Resuelto')->count();
        $alertasCombustible = Incidencia::where('urgencia', 'Crítica')->count();

        // 3. Vista para usuarios de sucursal / gestores
        if (in_array(auth()->user()->role, ['user', 'gestor', 'sucursal', 'coordinador'])) {
            return view('ops.muro_sucursal', compact(
                'sucursalesConPlacas',
                'incidencias',
                'pendientes', 
                'enProceso', 
                'finalizados', 
                'alertasCombustible'
            ));
        }

        // 4. Vista para el Administrador
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
            'fecha' => 'nullable|date',
            'revisiones' => 'nullable|array',
            'imagen_evidencia' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // 2. Procesamos la evidencia fotográfica si el usuario tomó/subió una foto
        $rutaImagen = null;
        if ($request->hasFile('imagen_evidencia')) {
            $rutaImagen = $request->file('imagen_evidencia')->store('evidencias', 'public');
        }

        // 3. Guardamos la incidencia con sus revisiones (cheques) en la base de datos
        Incidencia::create([
            'sucursal' => $request->sucursal,
            'placa' => $request->placa, 
            'urgencia' => $request->urgencia,
            'descripcion' => $request->descripcion,
            'revisiones' => $request->input('revisiones', []),
            'estado' => 'Pendiente',
            'imagen_evidencia' => $rutaImagen,
            'created_at' => $request->fecha ? Carbon::parse($request->fecha) : now(),
        ]);

        // 4. Redireccionamos con el mensaje de éxito
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
        
        if (\Schema::hasColumn('incidencias', 'comentarios')) {
            $incidencia->comentarios = $request->comentarios;
        }

        $incidencia->save();

        return redirect()->back()->with('success', '¡Registro actualizado con éxito!');
    }
}