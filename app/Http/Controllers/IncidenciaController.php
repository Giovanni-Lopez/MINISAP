<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia; 
use Carbon\Carbon;

class IncidenciaController extends Controller
{
    public function index()
        {
            // 1. Traemos los datos de tus tablas reales para el formulario dinámico
            $nombresSucursales = \App\Models\Sucursal::pluck('nombre')->toArray();
            $placasVehiculos = \App\Models\Vehiculo::pluck('placa')->toArray();

            $sucursalesConPlacas = [];
            foreach ($nombresSucursales as $sucursal) {
                $sucursalesConPlacas[$sucursal] = $placasVehiculos;
            }

            // 2. FILTRO DE ROLES ESTRICTO
            if (auth()->user()->role === 'user' || auth()->user()->role === 'sucursal') {
                // El usuario común SOLO recibe lo necesario para usar el formulario
                return view('ops.muro_sucursal', compact('sucursalesConPlacas'));
            }

            // 3. Si es Administrador, calculamos el resto de la data global
            $incidencias = Incidencia::orderBy('created_at', 'desc')->get();
            $pendientes = Incidencia::where('estado', 'Pendiente')->count();
            $enProceso = Incidencia::where('estado', 'En Revisión')->count(); 
            $finalizados = Incidencia::where('estado', 'Resuelto')->count();
            $alertasCombustible = Incidencia::where('urgencia', 'Crítica')->count();

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
            'imagen_evidencia' => null, 
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
        
        if (\Schema::hasColumn('incidencias', 'comentarios')) {
            $incidencia->comentarios = $request->comentarios;
        }

        $incidencia->save();

        return redirect()->back()->with('success', '¡Registro actualizado con éxito!');
    }
}