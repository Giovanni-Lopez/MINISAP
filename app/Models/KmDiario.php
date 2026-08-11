<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KmDiario extends Model
{
    use HasFactory;

    protected $table = 'km_diarios';

    protected $fillable = [
        'sucursal',
        'placa',
        'km_inicial',
        'km_final',
        'total_recorrido',
    ];
}