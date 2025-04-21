<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContestResult extends Model
{
    public function participant(): BelongsTo
    {
        return $this->belongsTo(ContestsParticipant::class);
    }

    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
}
