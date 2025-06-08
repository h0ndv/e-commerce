<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Models
use App\Models\Cliente;
use App\Models\DetalleServicio;
use App\Models\DetalleProducto;

class OrdenTrabajo extends Model
{
    protected $fillable = [
        'cliente_id',
        'titulo',
        'descripcion',
        'estado',
    ];

    public function detalleServicios(): HasMany
    {
        return $this->hasMany(DetalleServicio::class);
    }

    public function detalleProductos(): HasMany
    {
        return $this->hasMany(DetalleProducto::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
