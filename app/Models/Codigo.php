<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    protected $fillable = ['mezcla_id', 'codigo'];

    public function mezcla()
    {
        return $this->belongsTo(Mezcla::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Product::class, 'codigo_producto', 'codigo_id', 'producto_id')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function aspersions()
    {
        return $this->hasMany(Aspersion::class, 'mix_code_id');
    }
}