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
        Schema::create('tours', function (Blueprint $table) {
            $table->ulid('id')->unique()->primary();
            $table->string('title');
            $table->string('slug');
            $table->boolean('active')->default(true)->index();
            $table->foreignIdFor(Location::class, 'origin_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->smallInteger('number_of_nights')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
