<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorteCaja extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'fecha', 'efectivo_inicial', 'efectivo_final',
        'ventas_efectivo', 'ventas_tarjeta', 'ventas_transferencia',
        'total_ventas', 'total_esperado', 'diferencia', 'observaciones'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}