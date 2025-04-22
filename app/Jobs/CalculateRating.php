<?php

namespace App\Jobs;

use App\Models\Contest;
use App\Services\RatingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateRating implements ShouldQueue
{
    use Queueable;

    protected RatingService $ratingService;

    /**
     * Create a new job instance.
     */
    public function __construct(public Contest $contest)
    {
        $this->ratingService = new RatingService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->contest->calculated) return;
        $this->ratingService->updateRatings($this->contest);
    }
}
