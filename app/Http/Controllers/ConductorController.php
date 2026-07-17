<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    // Mostrar la lista de usuarios
    public function index()
    {
        // Traemos todos los conductores para pasárselos al JSON de la vista
        $usuarios = Conductor::orderBy('created_at', 'desc')->get();
        return view('ops.usuarios', compact('usuarios'));
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombres'      => 'required|string|max:255',
            'apellidos'    => 'required|string|max:255',
            'dui'          => 'required|string|unique:conductores,dui',
            'no_licencia'  => 'required|string',
            'clase_select' => 'required|string',
            'vence'        => 'required|date',
            'otra_clase'   => 'nullable|string|required_if:clase_select,OTROS'
        ]);

        // LÓGICA CLAVE: Si eligió "OTROS", usamos el valor del input manual; si no, el del select
        $claseFinal = $request->clase_select === 'OTROS' 
            ? strtoupper($request->otra_clase) 
            : $request->clase_select;

        Conductor::create([
            'nombres'     => $request->nombres,
            'apellidos'   => $request->apellidos,
            'dui'         => $request->dui,
            'no_licencia' => $request->no_licencia,
            'clase'       => $claseFinal,
            'vence'       => $request->vence,
        ]);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $conductor = Conductor::findOrFail($id);

        $request->validate([
            'nombres'      => 'required|string|max:255',
            'apellidos'    => 'required|string|max:255',
            'dui'          => 'required|string|unique:conductores,dui,' . $conductor->id,
            'no_licencia'  => 'required|string',
            'clase_select' => 'required|string',
            'vence'        => 'required|date',
            'otra_clase'   => 'nullable|string|required_if:clase_select,OTROS'
        ]);

        $claseFinal = $request->clase_select === 'OTROS' 
            ? strtoupper($request->otra_clase) 
            : $request->clase_select;

        $conductor->update([
            'nombres'     => $request->nombres,
            'apellidos'   => $request->apellidos,
            'dui'         => $request->dui,
            'no_licencia' => $request->no_licencia,
            'clase'       => $claseFinal,
            'vence'       => $request->vence,
        ]);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario actualizado correctamente.');
    }

    // Eliminar permanentemente de la BD (Igual al de tu flota)
    public function destroy($id)
    {
        $conductor = Conductor::findOrFail($id);
        $conductor->delete();

        return redirect()->route('usuarios.index')->with('exito', 'El usuario ha sido eliminado del sistema.');
    }
}