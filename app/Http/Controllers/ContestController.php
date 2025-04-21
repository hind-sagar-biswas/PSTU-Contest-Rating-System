<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContestController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Contest/Index');
    }

    public function store() {}
}
