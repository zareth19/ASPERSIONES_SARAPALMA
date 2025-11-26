<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mix extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}