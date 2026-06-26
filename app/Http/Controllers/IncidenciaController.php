<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function index()
{
    // 1. Traemos todas las incidencias de la base de datos para el feed
    $incidencias = Incidencia::orderBy('created_at', 'desc')->get();
    
    // 2. Leemos limpiamente las sucursales y placas desde la "carpeta x" (config/flota.php)
    $sucursalesConPlacas = config('flota.sucursales', []);

    // 3. Le pasamos ambas variables a la vista
    return view('ops.muro', compact('incidencias', 'sucursalesConPlacas'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'sucursal' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'urgencia' => 'required|in:Baja,Media,Alta,Crítica',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen_evidencia'] = $request->file('imagen')->store('evidencias', 'public');
        }

        Incidencia::create($data);

        return back()->with('exito', 'Reporte publicado en el Muro de Operaciones.');
    }
}
