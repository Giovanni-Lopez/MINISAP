<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::orderBy('nombre', 'asc')->get();
        return view('ops.sucursales', compact('sucursales'));
    }

    public function store(Request $request)
    {
        // Interceptamos el nombre si viene de la opción "OTRA"
        $nombreFinal = $request->nombre_select === 'OTRA' ? $request->otra_sucursal : $request->nombre_select;
        $request->merge(['nombre' => $nombreFinal]);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'encargado' => 'required|string|max:255',
            'telefono'  => 'required|string',
            'direccion' => 'required|string'
        ]);

        Sucursal::create($request->all());

        return redirect()->route('sucursales.index')->with('exito', 'Sucursal registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::findOrFail($id);

        // Interceptamos el nombre si viene de la opción "OTRA" en la edición
        $nombreFinal = $request->nombre_select === 'OTRA' ? $request->otra_sucursal : $request->nombre_select;
        $request->merge(['nombre' => $nombreFinal]);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'encargado' => 'required|string|max:255',
            'telefono'  => 'required|string',
            'direccion' => 'required|string'
        ]);

        $sucursal->update($request->all());

        return redirect()->route('sucursales.index')->with('exito', 'Sucursal actualizada correctamente.');
    }

    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();

        return redirect()->route('sucursales.index')->with('exito', 'La sucursal ha sido eliminada.');
    }
}