<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aspersion extends Model
{
    protected $fillable = [
        'finca_id',
        'user_id',
        'application_date',
        'week_number',
        'hectares',
        'mix_description'
    ];

    protected $casts = [
        'application_date' => 'date',
        'hectares' => 'decimal:2'
    ];

    public function finca(): BelongsTo
    {
        return $this->belongsTo(Finca::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'aspersion_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}