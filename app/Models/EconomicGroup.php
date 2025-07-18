<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importe a classe

class EconomicGroup extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $fillable = ['name'];
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
