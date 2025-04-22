<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContestRequest;
use App\Http\Resources\ContestMiniResource;
use App\Http\Resources\ContestResource;
use App\Jobs\CalculateRating;
use App\Models\Contest;
use App\Models\ContestsParticipant;
use Inertia\Inertia;

class ContestController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Contest/Create');
    }

    public function index()
    {
        $contests = Contest::latest()->get();
        return Inertia::render('Contest/Index', [
            'contests' => ContestMiniResource::collection($contests),
        ]);
    }

    public function show(Contest $contest)
    {
        return Inertia::render('Contest/Show', [
            'contest' => ContestResource::make($contest),
        ]);
    }

    public function store(StoreContestRequest $request)
    {
        $data = $request->validated();

        $contest = Contest::create(['date' => $data['date']]);
        $results = $data['results'];

        foreach ($results as $result) {
            $participant = ContestsParticipant::firstOrCreate(['name' => $result['name']]);
            $contest->results()->create([
                'contests_participant_id' => $participant->id,
                'standing' => $result['standing'],
                'solved'   => $result['solved'],
                'penalty'  => $result['penalty'],
            ]);
        }

        CalculateRating::dispatch($contest);

        return redirect()->route('contest.show', $contest);
    }
}
