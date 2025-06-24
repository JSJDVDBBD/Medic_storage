<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicamento_id', 'tipo', 'fecha_alerta', 'resuelta', 'observaciones'
    ];

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}