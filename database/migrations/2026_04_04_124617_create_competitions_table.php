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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->text('title_uz')->comment('Sarlavha uzbekcha');
            $table->text('title_ru')->comment('Sarlavha ruscha');
            $table->text('title_en')->comment('Sarlavha englicha');
            $table->unsignedBigInteger('sport_id')->comment('Sport id');
            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->unsignedBigInteger('season_id')->comment('Season id');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->enum('level', ['international', 'national', 'regional', 'local'])->comment('Musobaqa Turi');
            $table->string('organizer')->comment('Organizator');
            $table->string('location_uz')->comment('Manzil Uzbekcha');
            $table->string('location_ru')->comment('Manzil Ruscha');
            $table->string('location_en')->comment('Manzil Englicha');
            $table->string('location_country')->comment('Manzil Mamlakat');
            $table->date('start_date')->comment('Boshlanish sanasi');
            $table->date('end_date')->comment('Tugash sanasi');
            $table->integer('participants_count')->default(0)->comment('Maksimal Qatnashuvchilar soni');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming')->comment('Holati');
            $table->text('description_uz')->comment('Tavsif uzbekcha');
            $table->text('description_ru')->comment('Tavsif ruscha');
            $table->text('description_en')->comment('Tavsif englicha');
            $table->string('image')->nullable()->comment('Rasm');
            $table->decimal('rating', 3, 1)
                ->default(1.0)
                ->comment('0.5=mahalliy, 1.0=viloyat, 2.0=respublika, 3.0=xalqaro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
