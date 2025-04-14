<?php

use App\Models\Fleets;
use App\Models\Passengers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Trip Type standard = 1
     * Trip Type airport = 2
     * Trip Type Hourly = 3
     *
     * if Hourly has booked, then distance will be how many hour. otherwise, distances as miles.
     *
     *
     * status 0 = Pending for confirming and payment
     * status 1 = Paid and Upcoming Trip
     * status 2 = Trip complete
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('from');
            $table->string('to');
            $table->date('date');
            $table->time('time');
            $table->tinyInteger('remaining_return')->default(0);
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->string('flight_number')->nullable();
            $table->tinyInteger('trip_type');
            $table->decimal('distance',10,2);
            $table->foreignIdFor(Fleets::class);
            $table->foreignIdFor(Passengers::class);
            $table->decimal('fare',10,2);
            $table->integer('people');
            $table->integer('luggages');
            $table->tinyInteger('status');
            $table->text('pay_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
