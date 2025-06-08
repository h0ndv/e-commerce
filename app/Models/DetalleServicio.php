<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Models
use App\Models\Servicio;

class DetalleServicio extends Model
{
    protected $fillable = [
        'orden_trabajo_id',
        'servicio_id',
        'cantidad'
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
