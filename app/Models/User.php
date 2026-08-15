<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Comprueba si es Administrador (Acceso al Dashboard)
     */
    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Comprueba si es Coordinador (Acceso a CheckList, Combustible y KM)
     */
    public function esCoordinador(): bool
    {
        return $this->role === 'coordinador';
    }

    /**
     * Comprueba si es Gestor / Usuario normal (Solo acceso a CheckList)
     */
    public function esGestor(): bool
    {
        return in_array($this->role, ['user', 'gestor']);
    }
}