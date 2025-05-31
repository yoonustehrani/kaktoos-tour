<?php

use App\Models\Location;
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
        Schema::create('airports', function (Blueprint $table) {
            $table->char('code', 3);
            $table->string('name');
            $table->string('name_fa')->nullable();
            $table->string('city_name')->nullable();
            $table->string('city_name_fa')->nullable();
            $table->foreignIdFor(Location::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->char('country_code', 2);
            $table->foreign('country_code')->references('code')->on('countries')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_international');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
