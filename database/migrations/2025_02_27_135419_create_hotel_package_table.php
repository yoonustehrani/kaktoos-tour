<?php

use App\Models\Hotel;
use App\Models\TourPackage;
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
        Schema::create('hotel_package', function (Blueprint $table) {
            $table->foreignIdFor(TourPackage::class)->constrained('hotels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Hotel::class)->constrained('hotels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('service');
            $table->string('room_style');
            $table->text('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_package');
    }
};
