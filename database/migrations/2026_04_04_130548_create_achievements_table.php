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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('athlete_id')->comment('Athlete id');
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->unsignedBigInteger('competition_id')->comment('Competition id');
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->unsignedBigInteger('season_id')->comment('Season id');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->unsignedTinyInteger('place')->comment('1 = oltin, 2 = kumush, 3 = bronza');
            $table->enum('medal', ['gold', 'silver', 'bronze', 'none'])->default('none')->comment('Turi');
            $table->string('weight_category')->comment('Vazni kategoriyasi');
            $table->integer('points')->comment('Natija');
            $table->text('notes')->nullable()->comment('Qisqacha ma\'lumotlar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
