<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    // Permitimos que Laravel inserte datos en estas columnas
    protected $fillable = [
        'sucursal',
        'placa',
    ];
}