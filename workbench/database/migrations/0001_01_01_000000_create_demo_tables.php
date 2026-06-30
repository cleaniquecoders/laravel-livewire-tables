<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
        });

        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('species_id')->constrained('species');
        });

        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('age')->nullable();
            $table->foreignId('species_id')->constrained('species');
            $table->foreignId('breed_id')->constrained('breeds');
            $table->foreignId('owner_id')->nullable()->constrained('owners');
            $table->date('last_visit')->nullable();
            $table->string('favorite_color')->nullable();
            $table->boolean('is_vaccinated')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
        Schema::dropIfExists('breeds');
        Schema::dropIfExists('species');
        Schema::dropIfExists('owners');
    }
};
