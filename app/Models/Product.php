<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['commercial_name', 'active_ingredient', 'unit', 'category_id', 'active'];

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
}