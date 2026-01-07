<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mezcla extends Model
{
    protected $table = 'mezclas';
    protected $fillable = ['codigo_id', 'producto_id'];

    public function codigo()
    {
        return $this->belongsTo(Codigo::class);
    }

    public function producto()
    {
        return $this->belongsTo(Product::class);
    }

    public function codigos()
    {
        return $this->hasMany(Codigo::class);
    }
}