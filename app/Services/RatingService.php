<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\ContestResult;
use App\Models\ContestsParticipant;
use Illuminate\Support\Facades\DB;

class RatingService
{
    private const INITIAL_RATING = 100;

    // Elo win‐probability
    protected function winProbability(?int $rA, ?int $rB): float
    {
        $rA = $rA ?? self::INITIAL_RATING;
        $rB = $rB ?? self::INITIAL_RATING;

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

    // Find rating R such that expected seed equals target (via binary search)
    protected function findPerformanceRating(int $id, float $targetSeed, array $participants): float
    {
        $low = 0;
        $high = 10000;

        while ($high - $low > 1) {
            $mid = intval(($low + $high) / 2);
            $seed = 1;

            foreach ($participants as $p) {
                // skip ourselves and any unrated opponent
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
    // 1) eager‐load participants, sort by standing
    $results = $contest
        ->results()
        ->with('participant')
        ->orderBy('standing')
        ->get();

    $n = $results->count();

    // 2) build an array of “nodes” each with id, rating, and place
    $nodes = $results->map(function(ContestResult $r) {
        /** @var ContestsParticipant $p */
        $p = $r->participant;

        return (object)[
            'id'       => $p->id,
            'rating'   => $p->rating,
            'standing' => $r->standing,
        ];
    })->all();

    // 3) compute seeds based on $nodes
    $seeds = $this->computeSeed($nodes);

    // 4) preliminary deltas
    $deltas = [];
    foreach ($nodes as $node) {
        $seed  = $seeds[$node->id];
        $place = $node->standing;              // now comes from the result!
        $m     = sqrt($seed * $place);
        $perf  = $this->findPerformanceRating($node->id, $m, $nodes);
        $deltas[$node->id] = ($perf - $node->rating ?? self::INITIAL_RATING) / 2;
    }

    // 5) inflation adjustment
    $topS    = min(ceil($n * 0.1), 30);
    $topIds  = collect($nodes)
                  ->sortByDesc(fn($n) => $n->rating ?? self::INITIAL_RATING)
                  ->take($topS)
                  ->pluck('id');
    $sumD    = $topIds->sum(fn($id) => $deltas[$id]);
    $deltaAdj = max(min(-$sumD / $topS, 0), -10);

    // 6) persist both the ContestResult.delta and the new participant
    DB::transaction(function () use ($results, $deltas, $deltaAdj, $contest) {
        foreach ($results as $res) {
            $uid   = $res->contests_participant_id;
            $delta = round($deltas[$uid] + $deltaAdj);

            // save into the result row
            $res->delta = $delta;
            $res->save();

            // update the participant’s rating
            $p = $res->participant;
            $p->rating = ($p->rating ?? 100) + $delta;
            $p->save();
        }

        $contest->calculated = true;
        $contest->save();
    });
}}
