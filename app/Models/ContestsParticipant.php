<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContestsParticipant extends Model
{
    public function contest(): BelongsToMany
    {
        return $this->belongsToMany(Contest::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(ContestResult::class);
    }
}
