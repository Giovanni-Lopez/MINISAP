<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = [
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
}