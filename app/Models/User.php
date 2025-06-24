<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'telefono', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function cortesCaja()
    {
        return $this->hasMany(CorteCaja::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFarmacia()
    {
        return $this->role === 'farmacia';
    }

    public function isVendedor()
    {
        return $this->role === 'vendedor';
    }
}

// app/Models/Categoria.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
