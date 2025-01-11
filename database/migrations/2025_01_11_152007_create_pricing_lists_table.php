<?php

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
        Schema::create('pricing_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('tour_id')->constrained('tours')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(TourPackage::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_lists');
    }
};
