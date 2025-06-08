<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Models
use App\Models\DetalleServicio;

class Servicio extends Model
{
    protected $fillable = [
        'nombre',
        'precio',
        'descripcion'
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleServicio::class);
    }
}
