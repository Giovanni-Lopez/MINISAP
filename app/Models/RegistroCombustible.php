<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCombustible extends Model
{
    use HasFactory;

    protected $table = 'registro_combustibles';

    protected $fillable = [
    'sucursal',
    'fecha',
    'no_vale',
    'placa',
    'usuario',
    'precio_galon',
    'galonaje',
    'total_carga',
    'tipo_gas',
    'kilometraje',
    'area'
];
}