<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    protected $fillable = [
        'sucursal_id', // <-- Permite asignación masiva de la sucursal
        'placa',
        'anio',
        'marca',
        'modelo',
        'capacidad',
        'tipo',
        'clase',
        'en_calidad',
        'color',
        'n_chasis',
        'n_motor',
        'n_vin',
        'activo'
    ];

    // Relación con la sucursal
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    // Para obtener el historial de todas las asignaciones que ha tenido este vehículo
    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class);
    }

    // Para obtener la asignación activa de manera directa
    public function asignacionActiva(): HasOne
    {
        return $this->hasOne(Asignacion::class)->where('activo', true);
    }
}