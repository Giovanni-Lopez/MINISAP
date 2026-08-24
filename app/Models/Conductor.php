<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conductor extends Model
{
    use HasFactory;

    protected $table = 'conductores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'dui',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    /**
     * Un conductor posee múltiples licencias (Particular, Motocicleta, Pesada, etc.)
     */
    public function licencias(): HasMany
    {
        return $this->hasMany(Licencia::class, 'conductor_id');
    }

    /**
     * Relación existente con asignaciones de vehículos
     */
    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class, 'conductor_id');
    }
}