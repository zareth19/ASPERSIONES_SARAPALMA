<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MixCode extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'active'
    ];

    public function aspersions(): HasMany
    {
        return $this->hasMany(Aspersion::class);
    }

    public function mezclas(): HasMany
    {
        return $this->hasMany(Mezcla::class, 'codigo_id');
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'mezclas', 'codigo_id', 'producto_id');
    }
}
