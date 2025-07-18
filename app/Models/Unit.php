<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model implements Auditable
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory, \OwenIt\Auditing\Auditable;
     protected $fillable = [
        'trading_name',
        'company_name',
        'cnpj',
        'flag_id',
    ];

    public function flag(): BelongsTo
    {
        return $this->belongsTo(Flag::class);
    }

     public function collaborators(): HasMany
    {
        return $this->hasMany(Collaborator::class);
    }
}
