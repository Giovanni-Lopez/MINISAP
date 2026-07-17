<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    protected $table = 'conductores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'dui',
        'no_licencia',
        'clase',
        'vence',
        'activo'
    ];

    // Cast opcional para manejar la fecha como objeto Carbon si lo necesitas después
    protected $casts = [
        'vence' => 'date',
        'activo' => 'boolean'
    ];
}