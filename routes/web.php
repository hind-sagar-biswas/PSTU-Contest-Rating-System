<?php

use App\Http\Controllers\ContestController;
use App\Http\Controllers\ContestsParticipantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', ContestsParticipantController::class)->name('home');

Route::prefix('contest')->name('contest.')->controller(ContestController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store')->middleware('auth');
    Route::get('/{contest}', 'show')->name('show');
});

Route::get('/dashboard', ContestController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->middleware('auth')->group(function () {
    Route::get('/', 'edit')->name('edit');
    Route::patch('/', 'update')->name('update');
    /*Route::delete('/', 'destroy')->name('destroy');*/
});

require __DIR__ . '/auth.php';
