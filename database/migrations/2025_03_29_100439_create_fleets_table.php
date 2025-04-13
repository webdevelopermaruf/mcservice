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
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('passengers')->nullable();
            $table->integer('luggages')->nullable();
            // one-way, return, airport-pickup
            $table->integer('min_pay')->nullable();
            $table->integer('min_distances')->nullable();
            $table->integer('after_min')->nullable();
            $table->integer('airport_charge')->nullable();
            // hourly
            $table->integer('min_hours')->nullable();
            $table->integer('min_hours_pay')->nullable();
            $table->integer('after_min_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
