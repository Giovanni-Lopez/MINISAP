<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Licencia;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    // Mostrar la lista de motoristas cargando sus licencias asociadas
    public function index()
    {
        $conductores  = Conductor::with('licencias')->orderBy('created_at', 'desc')->get();
        return view('ops.conductores', compact('conductores'));
    }

    // Guardar nuevo motorista o añadir licencia a uno existente
    public function store(Request $request)
    {
        $request->validate([
            'nombres'      => 'required|string|max:255',
            'apellidos'    => 'required|string|max:255',
            'dui'          => 'required|string|max:10',
            'no_licencia'  => 'nullable|string|max:50',
            'clase_select' => 'required|string',
            'vence'        => 'required|date',
            'otra_clase'   => 'nullable|string|required_if:clase_select,OTROS'
        ]);

        $claseFinal = $request->clase_select === 'OTROS' 
            ? strtoupper($request->otra_clase) 
            : $request->clase_select;

        // 1. Busca si ya existe por DUI o crea el conductor
        $conductor = Conductor::firstOrCreate(
            ['dui' => $request->dui],
            [
                'nombres'   => $request->nombres,
                'apellidos' => $request->apellidos,
                'activo'    => true
            ]
        );

        // 2. Crea la nueva licencia vinculada al conductor
        $conductor->licencias()->create([
            'no_licencia' => $request->no_licencia,
            'clase'       => $claseFinal,
            'vence'       => $request->vence,
            'activa'      => true,
        ]);

        return redirect()->route('conductores.index')->with('exito', 'Motorista y licencia registrados correctamente.');
    }

    // Actualizar datos personales del motorista
    public function update(Request $request, $id)
    {
        $conductor = Conductor::findOrFail($id);

        $request->validate([
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dui'       => 'required|string|unique:conductores,dui,' . $conductor->id,
        ]);

        $conductor->update([
            'nombres'   => $request->nombres,
            'apellidos' => $request->apellidos,
            'dui'       => $request->dui,
        ]);

        return redirect()->route('conductores.index')->with('exito', 'Datos del motorista actualizados correctamente.');
    }

    // Eliminar motorista (por cascada eliminará sus licencias)
    public function destroy($id)
    {
        $conductor = Conductor::findOrFail($id);
        $conductor->delete();

        return redirect()->route('conductores.index')->with('exito', 'El motorista y sus licencias han sido eliminados.');
    }

    // Eliminar una licencia específica de un motorista
    public function destroyLicencia($id)
    {
        $licencia = Licencia::findOrFail($id);
        $licencia->delete();

        return redirect()->route('conductores.index')->with('exito', 'Licencia eliminada correctamente.');
    }
}