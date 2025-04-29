<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParticipantResource;
use App\Models\ContestResult;
use App\Models\ContestsParticipant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContestsParticipantController extends Controller
{
    public function __invoke()
    {
        $data = ContestsParticipant::orderBy('display_rating', 'desc')->latest()->get();
        return Inertia::render('Participant/Index', [
            'data' => ParticipantResource::collection($data),
        ]);
    }

    public function show(string $name)
    {
        $participant = ContestsParticipant::where('name', $name)->firstOrFail();

        // With Contest Date: Participant->Result->Contest.date
        $results = $participant->results()->with('contest')->latest()->get();


        foreach ($results as $result) {
            $result->contest_date = $result->contest->date->format('Y-m-d');
        }

        return Inertia::render('Participant/Show', [
            'participant' => new ParticipantResource($participant),
            'results' => $results,
        ]);
    }
}
