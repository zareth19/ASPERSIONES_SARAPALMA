<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mezcal extends Model
{
    protected $table = 'mezcal';
    
    protected $fillable = [
        'nombre_mezcla',
        'cantidad_aplicacion',
        'producto_id',
        'codigo_id'
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }

    public function codigo(): BelongsTo
    {
        return $this->belongsTo(Codigo::class, 'codigo_id');
    }
}