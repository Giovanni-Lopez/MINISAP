<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'nombre',
        'encargado',
        'telefono',
        'direccion',
        'activa'
    ];

    /**
     * Relación: Una sucursal tiene muchos vehículos
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'sucursal_id');
    }
}