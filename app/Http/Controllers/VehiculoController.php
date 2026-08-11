<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        //sucursales para el select del formulario/modal
        $sucursales = Sucursal::orderBy('nombre')->get();

        //vehículos incluyendo su relación con la sucursal
        $vehiculos = Vehiculo::with('sucursal')->orderBy('placa')->get();

        return view('ops.flota', compact('vehiculos', 'sucursales'));
    }

    public function store(Request $request)
    {
        //Validamos incluyendo la sucursal
        $request->validate([
            'sucursal_id' => 'nullable|exists:sucursales,id', // Se valida que la sucursal exista en BD
            'placa'       => 'required|string|unique:vehiculos,placa',
            'anio'        => 'required|integer',
            'marca'       => 'required|string',
            'modelo'      => 'required|string',
            'capacidad'   => 'required|string',
            'tipo'        => 'required|string',
            'clase'       => 'required|string',
            'en_calidad'  => 'required|string|in:Propietario,A Plazos',
            
            'n_chasis'    => 'required|string|unique:vehiculos,n_chasis', 
            'n_motor'     => 'required|string|unique:vehiculos,n_motor',  
            'n_vin'       => 'required|string|unique:vehiculos,n_vin',    
        ], [
            'sucursal_id.exists' => 'La sucursal seleccionada no es válida.',
            'placa.unique'       => '¡Error! Esta placa ya se encuentra registrada en el sistema.',
            'n_chasis.unique'    => '¡Error! El número de chasis ya pertenece a otro vehículo registrado.',
            'n_motor.unique'     => '¡Error! El número de motor ya pertenece a otro vehículo registrado.',
            'n_vin.unique'       => '¡Error! El número VIN ya pertenece a otro vehículo registrado.',
            'en_calidad.in'      => 'La calidad seleccionada no es válida.',
        ]);

        //Guardamos incluyendo sucursal_id
        Vehiculo::create([
            'sucursal_id' => $request->sucursal_id,
            'placa'       => trim(strtoupper($request->placa)),
            'anio'        => $request->anio,
            'marca'       => $request->marca,
            'modelo'      => $request->modelo,
            'capacidad'   => $request->capacidad,
            'tipo'        => $request->tipo,
            'clase'       => $request->clase,
            'en_calidad'  => $request->en_calidad,
            'color'       => $request->color,
            'n_chasis'    => trim(strtoupper($request->n_chasis)),
            'n_motor'     => trim(strtoupper($request->n_motor)),
            'n_vin'       => trim(strtoupper($request->n_vin)),
            'activo'      => true,
        ]);

        return redirect()->back()->with('exito', '¡Unidad registrada con éxito en el sistema!');
    }

    public function toggleEstado(Vehiculo $vehiculo)
    {
        $vehiculo->update([
            'activo' => !$vehiculo->activo
        ]);

        $mensaje = $vehiculo->activo ? '¡Unidad reactivada con éxito!' : '¡Unidad dada de baja correctamente!';
        return redirect()->back()->with('exito', $mensaje);
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $request->validate([
            'sucursal_id' => 'nullable|exists:sucursales,id',
            'placa'       => 'required|string|unique:vehiculos,placa,' . $vehiculo->id,
            'anio'        => 'required|integer',
            'marca'       => 'required|string',
            'modelo'      => 'required|string',
            'capacidad'   => 'required|string',
            'tipo'        => 'required|string',
            'clase'       => 'required|string',
            'en_calidad'  => 'required|string|in:Propietario,A Plazos',
            'color'       => 'required|string',
            'n_chasis'    => 'required|string',
            'n_motor'     => 'required|string',
            'n_vin'       => 'required|string',
        ], [
            'sucursal_id.exists' => 'La sucursal seleccionada no es válida.',
            'placa.unique'       => '¡Error! Esta placa ya está registrada en otra unidad.',
        ]);

        $vehiculo->update([
            'sucursal_id' => $request->sucursal_id,
            'placa'       => trim(strtoupper($request->placa)),
            'anio'        => $request->anio,
            'marca'       => $request->marca,
            'modelo'      => $request->modelo,
            'capacidad'   => $request->capacidad,
            'tipo'        => $request->tipo,
            'clase'       => $request->clase,
            'en_calidad'  => $request->en_calidad,
            'color'       => $request->color,
            'n_chasis'    => trim(strtoupper($request->n_chasis)),
            'n_motor'     => trim(strtoupper($request->n_motor)),
            'n_vin'       => trim(strtoupper($request->n_vin)),
        ]);

        return redirect()->back()->with('exito', '¡La unidad fue actualizada con éxito!');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();
        return redirect()->back()->with('exito', '¡Unidad eliminada permanentemente del sistema!');
    }

    /**
     * Endpoint API para filtrar vehículos por sucursal en el Muro/Incidencias
     */
    public function getPorSucursal($sucursalId)
    {
        $vehiculos = Vehiculo::where('sucursal_id', $sucursalId)
            ->where('activo', true)
            ->select('id', 'placa')
            ->orderBy('placa')
            ->get();

        return response()->json($vehiculos);
    }
}