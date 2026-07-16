<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        // Traemos todos los vehículos de la base de datos ordenados por placa
        $vehiculos = Vehiculo::orderBy('placa')->get();

        return view('ops.flota', compact('vehiculos'));
    }

    public function store(Request $request)
{
    // 1. Aquí validamos TODO antes de tocar la base de datos
    $request->validate([
        'placa'      => 'required|string|unique:vehiculos,placa',
        'anio'       => 'required|integer',
        'marca'      => 'required|string',
        'modelo'     => 'required|string',
        'capacidad'  => 'required|string',
        'tipo'       => 'required|string',
        'clase'      => 'required|string',
        'en_calidad' => 'required|string|in:Propietario,A Plazos',
        
        // ¡ESTAS TRES REGLAS SON LAS QUE EVITAN LA PANTALLA ROJA!
        'n_chasis'   => 'required|string|unique:vehiculos,n_chasis', 
        'n_motor'    => 'required|string|unique:vehiculos,n_motor',  
        'n_vin'      => 'required|string|unique:vehiculos,n_vin',    
    ], [
        // Mensajes de error amigables para el usuario
        'placa.unique'      => '¡Error! Esta placa ya se encuentra registrada en el sistema.',
        'n_chasis.unique'   => '¡Error! El número de chasis ya pertenece a otro vehículo registrado.',
        'n_motor.unique'    => '¡Error! El número de motor ya pertenece a otro vehículo registrado.',
        'n_vin.unique'      => '¡Error! El número VIN ya pertenece a otro vehículo registrado.',
        'en_calidad.in'     => 'La calidad seleccionada no es válida.',
    ]);

    // 2. Si la validación pasa (es decir, nada está repetido), guardamos:
    Vehiculo::create([
        'placa'      => trim(strtoupper($request->placa)),
        'anio'       => $request->anio,
        'marca'      => $request->marca,
        'modelo'     => $request->modelo,
        'capacidad'  => $request->capacidad,
        'tipo'       => $request->tipo,
        'clase'      => $request->clase,
        'en_calidad' => $request->en_calidad,
        'color'      => $request->color,
        'n_chasis'   => trim(strtoupper($request->n_chasis)),
        'n_motor'    => trim(strtoupper($request->n_motor)),
        'n_vin'      => trim(strtoupper($request->n_vin)),
        'activo'     => true,
    ]);

    return redirect()->back()->with('exito', '¡Unidad registrada con éxito en el sistema!');
}

    public function toggleEstado(Vehiculo $vehiculo)
    {
        // Alterna el estado activo/inactivo
        $vehiculo->update([
            'activo' => !$vehiculo->activo
        ]);

        $mensaje = $vehiculo->activo ? '¡Unidad reactivada con éxito!' : '¡Unidad dada de baja correctamente!';
        return redirect()->back()->with('exito', $mensaje);
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        // Validamos asegurando que la placa ignore al ID actual en el unique
        $request->validate([
            'placa'      => 'required|string|unique:vehiculos,placa,' . $vehiculo->id,
            'anio'       => 'required|integer',
            'marca'      => 'required|string',
            'modelo'     => 'required|string',
            'capacidad'  => 'required|string',
            'tipo'       => 'required|string',
            'clase'      => 'required|string',
            'en_calidad' => 'required|string|in:Propio,Rentado,Subcontratado',
            'color'      => 'required|string',
            'n_chasis'   => 'required|string',
            'n_motor'    => 'required|string',
            'n_vin'      => 'required|string',
        ], [
            'placa.unique' => '¡Error! Esta placa ya está registrada en otra unidad.',
        ]);

        // Actualizamos el registro con los nuevos valores del Modal de Edición
        $vehiculo->update([
            'placa'      => trim(strtoupper($request->placa)),
            'anio'       => $request->anio,
            'marca'      => $request->marca,
            'modelo'     => $request->modelo,
            'capacidad'  => $request->capacidad,
            'tipo'       => $request->tipo,
            'clase'      => $request->clase,
            'en_calidad' => $request->en_calidad,
            'color'      => $request->color,
            'n_chasis'   => trim(strtoupper($request->n_chasis)),
            'n_motor'    => trim(strtoupper($request->n_motor)),
            'n_vin'      => trim(strtoupper($request->n_vin)),
        ]);

        return redirect()->back()->with('exito', '¡La unidad fue actualizada con éxito!');
    }
}