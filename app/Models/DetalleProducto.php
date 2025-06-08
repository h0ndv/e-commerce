<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Models
use App\Models\Producto;

class DetalleProducto extends Model
{
    protected $fillable = [
        'orden_trabajo_id',
        'producto_id',
        'cantidad',
    ];
    
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

}
