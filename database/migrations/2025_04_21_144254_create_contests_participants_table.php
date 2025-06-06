<?php

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
        Schema::create('contests_participants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('contests_count')->default(0);
            $table->integer('rating')->nullable()->default(null);
            $table->integer('display_rating')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests_participants');
    }
};
