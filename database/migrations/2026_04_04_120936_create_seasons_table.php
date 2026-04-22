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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->year('year_start')->comment('Yil boshlanishi');
            $table->year('year_end')->comment('Yil tugashi');
            $table->date('start_date')->comment('Boshlanish sanasi');
            $table->date('end_date')->comment('Tugash sanasi');
            $table->tinyInteger('is_active')->default(1);
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
