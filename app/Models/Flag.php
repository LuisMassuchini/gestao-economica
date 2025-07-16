<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importe a classe
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flag extends Model
{
    use HasFactory;

    /**
     * Get the economic group that owns the Flag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function economicGroup(): BelongsTo
    {
        return $this->belongsTo(EconomicGroup::class);
    }

     public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
