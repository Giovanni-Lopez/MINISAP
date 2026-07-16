<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'vehiculo_id',
        'user_id',
        'sucursal',
        'activo',
        'fecha_asignacion',
        'fecha_devolucion'
    ];

    protected $casts = [
        'fecha_asignacion' => 'date',
        'fecha_devolucion' => 'date',
        'activo' => 'boolean'
    ];

    // Pertenece a un Vehículo
    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }

    // Pertenece a un Usuario (Chofer/Responsable)
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}