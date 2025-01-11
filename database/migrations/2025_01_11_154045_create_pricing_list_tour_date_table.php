<?php

use App\Models\PricingList;
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
        Schema::create('pricing_list_tour_date', function (Blueprint $table) {
            $table->foreignIdFor(PricingList::class);
            $table->foreignIdFor(TourDate::class);
            $table->primary([
                'pricing_list_id',
                'tour_date_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_list_tour_date');
    }
};
