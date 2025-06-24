<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Medicamento extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'presentacion', 'laboratorio',
        'stock', 'stock_minimo', 'precio_compra', 'precio_venta',
        'fecha_caducidad', 'lote', 'requiere_receta', 'imagen'
    ];

    // Asegúrate de convertir la fecha a Carbon
    protected $dates = ['fecha_caducidad'];

    protected $appends = ['imagen_url'];

    protected $casts = [
        'fecha_caducidad' => 'datetime',
    ];

    public function getImagenUrlAttribute()
    {
        return $this->imagen ? Storage::url('medicamentos/'.$this->imagen) : asset('img/default-medicamento.png');
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }

    public function scopeProximosCaducar($query, $dias = 30)
    {
        return $query->where('fecha_caducidad', '<=', now()->addDays($dias))
                    ->orderBy('fecha_caducidad');
    }

    public function scopeStockBajo($query)
    {
        return $query->whereColumn('stock', '<=', 'stock_minimo')
                    ->orderBy('stock');
    }

    public function generarAlertas()
    {
        if ($this->stock <= $this->stock_minimo) {
            $this->alertas()->firstOrCreate([
                'tipo' => 'stock',
                'fecha_alerta' => now(),
            ], [
                'observaciones' => "Stock bajo: {$this->stock} unidades (mínimo {$this->stock_minimo})"
            ]);
        }

        if ($this->fecha_caducidad->diffInDays(now()) <= 30) {
            $this->alertas()->firstOrCreate([
                'tipo' => 'caducidad',
                'fecha_alerta' => now(),
            ], [
                'observaciones' => "Caduca en {$this->fecha_caducidad->diffForHumans()}"
            ]);
        }
    }
}