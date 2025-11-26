<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mezcla extends Model
{
    protected $table = 'mezclas';
    protected $fillable = ['nombre'];

    public function codigos()
    {
        return $this->hasMany(Codigo::class);
    }
}