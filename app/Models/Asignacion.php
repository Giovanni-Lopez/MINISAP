<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asignacion extends Model
{
    // Forzamos el nombre de la tabla si tu migración se llama asignaciones
    protected $table = 'asignaciones'; 

    protected $fillable = [
        'vehiculo_id',
        'conductor_id',
        'fecha_asignacion',
        'estado_vehiculo',
        'observaciones',
        'activo'
    ];

    // Relación: Una asignación pertenece a un Vehículo
    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    // Relación: Una asignación pertenece a un Conductor
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Conductor::class, 'conductor_id');
    }
}