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
        Schema::create('tour_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('tour_id')->constrained('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('start_date')->index();
            $table->date('end_date')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_dates');
    }
};
