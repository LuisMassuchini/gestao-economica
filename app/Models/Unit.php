<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    public function flag(): BelongsTo
    {
        return $this->belongsTo(Flag::class);
    }

     public function collaborators(): HasMany
    {
        return $this->hasMany(Collaborator::class);
    }
}
