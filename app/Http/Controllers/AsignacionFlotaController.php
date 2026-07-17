<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Vehiculo;
use App\Models\Conductor;
use Illuminate\Http\Request;

class AsignacionFlotaController extends Controller
{
    public function index()
    {
        // 1. Obtener asignaciones activas con sus relaciones
        $asignaciones = Asignacion::with(['vehiculo', 'conductor'])
                            ->where('activo', true)
                            ->get();
        
        // 2. Filtrar vehículos que NO tengan una asignación activa actualmente
        $vehiculosDisponibles = Vehiculo::doesntHave('asignacionActiva')
                                    ->where('activo', true)
                                    ->get();

        // 3. Obtener todos los conductores ordenados por nombre
        $conductores = Conductor::orderBy('nombres', 'asc')->get();

        return view('ops.asignaciones-flota', compact('asignaciones', 'vehiculosDisponibles', 'conductores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id'      => 'required|exists:vehiculos,id',
            'conductor_id'     => 'required|exists:conductores,id', // Verifica si tu tabla es 'conductores' o 'conductors'
            'fecha_asignacion' => 'required|date',
            'estado_vehiculo'  => 'required|string|max:255',
            'observaciones'    => 'nullable|string'
        ]);

        Asignacion::create([
            'vehiculo_id'      => $request->vehiculo_id,
            'conductor_id'     => $request->conductor_id,
            'fecha_asignacion' => $request->fecha_asignacion,
            'estado_vehiculo'  => $request->estado_vehiculo,
            'observaciones'    => $request->observaciones,
            'activo'           => true
        ]);

        return redirect()->back()->with('exito', 'Vehículo asignado al conductor correctamente.');
    }

    public function liberar($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $asignacion->update(['activo' => false]);

        return redirect()->back()->with('exito', 'El vehículo ha sido devuelto y liberado con éxito.');
    }
}