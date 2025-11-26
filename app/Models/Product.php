<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['commercial_name', 'active_ingredient', 'unit', 'cantidad_producto', 'category_id', 'active'];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function aspersions(): BelongsToMany
    {
        return $this->belongsToMany(Aspersion::class, 'aspersion_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function mezclas(): HasMany
    {
        return $this->hasMany(Mezcla::class, 'producto_id');
    }

    public function codigos(): BelongsToMany
    {
        return $this->belongsToMany(Codigo::class, 'mezclas', 'producto_id', 'codigo_id');
    }
}