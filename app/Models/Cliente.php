<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Models
use App\Models\OrdenTrabajo;

class Cliente extends Model
{
    protected $fillable = [
        'nombre', 
        'telefono', 
        'correo'
    ];

    public function ordenesTrabajo(): Hasmany
    {
        return $this->hasMany(OrdenTrabajo ::class);
    }
}
