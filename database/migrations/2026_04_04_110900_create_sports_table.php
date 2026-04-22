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
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz')->comment('Sport nomi uzbekcha');
            $table->string('name_ru')->comment('Sport nomi ruscha');
            $table->string('name_en')->comment('Sport nomi englicha');
            $table->string('slug')->unique()->comment('Sport slug');
            $table->string('icon')->nullable()->comment('Sport ikonasi');
            $table->string('image')->nullable()->comment('Sport rasmi');
            $table->text('description_uz')->nullable()->comment('Sport haqida uzbekcha');
            $table->text('description_ru')->nullable()->comment('Sport haqida ruscha');
            $table->text('description_en')->nullable()->comment('Sport haqida englicha');
            $table->tinyInteger('is_olympic')->default(0)->comment('Sport olympik sportga kiradimi');
            $table->tinyInteger('status')->default(1)->comment('Sport holati');
            $table->integer('order')->default(0)->comment('Sport sort');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
