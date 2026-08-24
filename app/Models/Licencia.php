<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Licencia extends Model
{
    use HasFactory;

    protected $table = 'licencias';

    protected $fillable = [
        'conductor_id',
        'no_licencia',
        'clase',
        'vence',
        'activa'
    ];

    protected $casts = [
        'vence'  => 'date',
        'activa' => 'boolean'
    ];

    /**
     * La licencia pertenece a un único conductor
     */
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Conductor::class, 'conductor_id');
    }
}