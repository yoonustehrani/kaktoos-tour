<?php

use App\Models\Location;
use App\Models\Tour;
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
        Schema::create('tour_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Location::class)->index()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUlid('tour_id')->index()->constrained('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->smallInteger('number_of_nights')->unsigned();
            $table->boolean('requires_visa');
            $table->smallInteger('visa_preparation_days')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_destinations');
    }
};
