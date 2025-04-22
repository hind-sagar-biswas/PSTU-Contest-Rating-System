<?php

use App\Models\Contest;
use App\Models\ContestsParticipant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contest_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contest::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ContestsParticipant::class)->constrained()->cascadeOnDelete();
            $table->integer('standing');
            $table->integer('solved');
            $table->integer('penalty');
            $table->integer('delta')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['contest_id', 'contests_participant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_results');
    }
};
