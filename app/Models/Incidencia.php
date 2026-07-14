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
        'estado',
        'imagen_evidencia'
    ];
}