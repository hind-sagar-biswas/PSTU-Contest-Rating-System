<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestResult;
use Illuminate\Support\Facades\DB;

class RatingService
{
    private const INTERNAL_RATING = 1400;
    private const BUMP_SEQUENCE = [500, 350, 250, 150, 100, 50];

    // Elo win‐probability
    protected function winProbability(?int $rA, ?int $rB): float
    {
        $rA = $rA ?? self::INTERNAL_RATING;
        $rB = $rB ?? self::INTERNAL_RATING;

        return 1 / (1 + pow(10, ($rB - $rA) / 400));
    }

    // Compute expected standing (seed)
    protected function computeSeed(array $participants): array
    {
        $n = count($participants);
        $seeds = [];

        foreach ($participants as $i => $pA) {
            $rA = $pA->rating;
            $seed = 1;

            if ($rA === null) {
                // should not happen: rating always set on creation
                $seed = 1 + $n / 2;
            } else {
                foreach ($participants as $j => $pB) {
                    if ($i === $j) continue;
                    $seed += 1 - $this->winProbability($rA, $pB->rating);
                }
            }

            $seeds[$pA->id] = $seed;
        }

        return $seeds;
    }

    // Find performance rating via binary search
    protected function findPerformanceRating(int $id, float $targetSeed, array $participants): float
    {
        $low = 0;
        $high = 10000;

        while ($high - $low > 1) {
            $mid = intval(($low + $high) / 2);
            $seed = 1;

            foreach ($participants as $p) {
                if ($p->id === $id) continue;
                $seed += 1 - $this->winProbability($mid, $p->rating);
            }

            if ($seed > $targetSeed) {
                $low = $mid;
            } else {
                $high = $mid;
            }
        }

        return ($low + $high) / 2;
    }

    public function updateRatings(Contest $contest): void
    {
        $results = $contest
            ->results()
            ->with('participant')
            ->orderBy('standing')
            ->get();

        $n = $results->count();

        $nodes = $results->map(function (ContestResult $r) {
            $p = $r->participant;

            return (object)[
                'id'       => $p->id,
                'rating'   => $p->rating ?? self::INTERNAL_RATING,
                'standing' => $r->standing,
            ];
        })->all();

        $seeds = $this->computeSeed($nodes);

        // preliminary deltas
        $deltas = [];
        foreach ($nodes as $node) {
            $seed  = $seeds[$node->id];
            $place = $node->standing;
            $m     = sqrt($seed * $place);
            $perf  = $this->findPerformanceRating($node->id, $m, $nodes);

            $current = $node->rating;
            $deltas[$node->id] = ($perf - $current) / 2;
        }

        // inflation adjustment
        $topS    = min(ceil($n * 0.1), 30);
        $topIds  = collect($nodes)
            ->sortByDesc(fn($n) => $n->rating)
            ->take($topS)
            ->pluck('id');
        $sumD    = $topIds->sum(fn($id) => $deltas[$id]);
        $deltaAdj = max(min(-$sumD / $topS, 0), -10);

        DB::transaction(function () use ($results, $deltas, $deltaAdj, $contest) {
            foreach ($results as $res) {
                $uid   = $res->contests_participant_id;
                $delta = floor($deltas[$uid] + $deltaAdj);
                $p = $res->participant;

                // apply bump
                $bumpCount = count(self::BUMP_SEQUENCE);
                $bump = ($p->contests_count < $bumpCount) ? self::BUMP_SEQUENCE[$p->contests_count] : 0;


                $res->delta = $bump + $delta;
                $res->save();


                $p->rating = ($p->rating ?? self::INTERNAL_RATING) + $delta;
                $p->contests_count = ($p->contests_count ?? 0) + 1;
                $p->display_rating = ($p->display_rating ?? 0) + $delta + $bump;
                $p->save();
            }

            $contest->calculated = true;
            $contest->save();
        });
    }
}
