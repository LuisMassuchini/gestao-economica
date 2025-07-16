<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importe a classe

class EconomicGroup extends Model
{
    use HasFactory;

    /**
     * Get all of the flags for the EconomicGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flags(): HasMany
    {
        return $this->hasMany(Flag::class);
    }
}
