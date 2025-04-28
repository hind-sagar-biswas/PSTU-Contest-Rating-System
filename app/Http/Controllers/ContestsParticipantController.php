<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParticipantResource;
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
}
