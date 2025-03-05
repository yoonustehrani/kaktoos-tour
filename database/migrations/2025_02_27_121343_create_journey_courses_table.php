<?php

use App\Models\Location;
use App\Models\TourDate;
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
        Schema::create('journey_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('tour_id')->constrained('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(TourDate::class);
            $table->unsignedTinyInteger('order'); // number > 0
            $table->char('transportation_type', 1); // App\Enums\TransportationType::values()
            $table->foreignIdFor(Location::class, 'origin_location_id');
            $table->foreignIdFor(Location::class, 'destination_location_id');
            $table->string('departure_type')->nullable(); // Airport, Location, TrainStation, etc.
            $table->string('departure_id')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('departure_time', 5)->nullable(); // 00:00
            $table->string('duration', 5)->nullable(); // 00:00
            $table->string('transition_time', 5)->nullable(); // 00:00
            $table->string('arrival_type')->nullable(); // Airport, Location, TrainStation, etc.
            $table->string('arrival_id')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('transportation_firm_type')->nullable(); // Airline, etc.
            $table->string('transportation_firm_id')->nullable();
            $table->string('item_number', 24)->nullable(); // flight number, etc.
            $table->unsignedSmallInteger('baggage'); // 30
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journey_courses');
    }
};
