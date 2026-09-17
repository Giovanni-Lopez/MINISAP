<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Permite guardar el ID del usuario emisor
        'sucursal',
        'placa',
        'urgencia',
        'descripcion',
        'revisiones', // Permite asignación masiva de los cheques
        'estado',
        'imagen_evidencia'
    ];

    protected $casts = [
        'revisiones' => 'array', // Convierte el campo JSON de la BD a Array en PHP
    ];

    /**
     * Relación con el usuario que creó la incidencia
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}