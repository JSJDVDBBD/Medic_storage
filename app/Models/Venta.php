<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'user_id',
        'subtotal',
        'impuesto',
        'descuento',
        'total',
        'metodo_pago',
        'estado',
        'observaciones'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function generarCodigo()
    {
        $lastId = self::max('id') ?? 0;
        return 'V-' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);
    }
}