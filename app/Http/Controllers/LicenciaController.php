<?php

namespace App\Http\Controllers;
use App\Models\Licencia;
use Illuminate\Http\Request;

class LicenciaController extends Controller
{
    public function destroy($id)
    {
        $licencia = Licencia::findOrFail($id);
        $licencia->delete();

        return redirect()->back()->with('exito', 'Licencia eliminada con éxito.');
    }
}
