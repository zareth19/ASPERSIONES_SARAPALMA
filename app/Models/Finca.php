<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Finca extends Model
{
    protected $table = 'fincas_temp';
    
    protected $fillable = [
        'name', 'ibm', 'hectares', 'location', 'active', 'cc', 'extension',
        'direct_phone', 'administrator_name', 'administrator_phone',
        'office_worker_name', 'office_worker_phone', 'coordinator_name', 'coordinator_phone',
        'password'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'active' => 'boolean',
        'hectares' => 'decimal:2'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function aspersions(): HasMany
    {
        return $this->hasMany(Aspersion::class);
    }
}