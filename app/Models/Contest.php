<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contest extends Model
{
    protected $casts = [
        'date' => 'date',
        'calculated' => 'boolean',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(ContestResult::class);
    }
}
