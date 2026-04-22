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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('athlete_id')->comment('Athlete id');
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->unsignedBigInteger('season_id')->comment('Season id');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->unsignedBigInteger('sport_id')->comment('Sport id');
            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->integer('total_points')->default(0)->comment('Jami natija');
            $table->integer('rank_position')->nullable()->comment('Rank pozitsiyasi');
            $table->integer('prev_rank_position')->nullable()->comment('Oldingi rank pozitsiyasi');
            $table->tinyInteger('gold_count')->default(0)->comment('Gold medali');
            $table->tinyInteger('silver_count')->default(0)->comment('Silver medali');
            $table->tinyInteger('bronze_count')->default(0)->comment('Bronze medali');
            $table->tinyInteger('competitions_count')->default(0)->comment('Competition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
