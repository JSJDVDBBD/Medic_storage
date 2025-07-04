<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoVenta extends Model
{
    protected $table = 'puntos_ventas';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'user_id',
    ];
}
