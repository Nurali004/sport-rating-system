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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->comment('Ism');
            $table->string('last_name')->comment('Familiya');
            $table->string('middle_name')->nullable()->comment('Otasining ismi');
            $table->string('slug')->unique()->comment('Slug');
            $table->unsignedBigInteger('sport_id')->comment('Sport id');
            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->unsignedBigInteger('region_id')->comment('Region id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->comment('Foydalanuvchi id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('birth_date')->comment('Tug\'ilgan sanasi');
            $table->string('gender')->comment('Jins');
            $table->string('photo')->nullable()->comment('Rasm');
            $table->string('cover_photo')->nullable()->comment('Rasm');
            $table->string('height')->comment("Bo'yi");
            $table->string('weight')->comment("Vazni");
            $table->string('weight_category')->comment('Vazni kategoriyasi');
            $table->string('coach_name')->comment('O\'qituvchi ismi');
            $table->string('club_name')->comment('Klub nomi');
            $table->integer('experience_years')->comment('Tajribasi yilliklar');
            $table->tinyInteger('is_national_team')->default(0)->comment('Xalqaro Jamoa turi');
            $table->enum('status', ['active', 'inactive', 'suspended', 'retired'])->default('active')->comment('Holati');
            $table->text('bio_uz')->nullable()->comment('Biografiya uzbekcha');
            $table->text('bio_ru')->nullable()->comment('Biografiya ruscha');
            $table->text('bio_en')->nullable()->comment('Biografiya englicha');
            $table->integer('rating_score')->default(0)->comment('Reyting');
            $table->integer('rank_position')->default(0)->comment('Rank Pozitsiyasi');
            $table->integer('world_rank')->nullable()->comment('Dunyo reytingi');
            $table->integer('gold_medals')->default(0)->comment('Gold medali');
            $table->integer('silver_medals')->default(0)->comment('Silver medali');
            $table->integer('bronze_medals')->default(0)->comment('Bronze medali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
