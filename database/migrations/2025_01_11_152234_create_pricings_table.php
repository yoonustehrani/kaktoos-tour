<?php

use App\Models\PricingList;
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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PricingList::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('price')->unsigned();
            $table->char('currency', 3);
            $table->smallInteger('room_type')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
