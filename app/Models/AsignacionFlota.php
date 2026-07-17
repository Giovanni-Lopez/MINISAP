<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionFlota extends Model
{
    // Definimos el nombre correcto de la tabla si no sigue el plural en inglés
    protected $table = 'asignaciones_flota';

    protected $fillable = [
        'flota_id',
        'personal_id',
        'fecha_asignacion',
        'estado_vehiculo',
        'observaciones',
        'activo'
    ];

    // Relación: Una asignación pertenece a un vehículo de la flota
    public function flota()
    {
        return $this->belongsTo(Flota::class, 'flota_id');
    }

    // Relación: Una asignación pertenece a un miembro del personal
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
}