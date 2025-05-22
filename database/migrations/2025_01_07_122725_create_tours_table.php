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
            $table->boolean('is_inbound')->index();
            $table->boolean('active')->default(false)->index();
            $table->foreignIdFor(Location::class, 'origin_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->smallInteger('number_of_nights')->unsigned()->nullable();
            $table->char('airline_code', 3)->nullable();
            $table->char('payment_type', 1);
            $table->tinyText('image_src');
            $table->tinyText('image_alt')->nullable();
            $table->timestamps();
            $table->timestamp('published_at');
            $table->json('meta')->nullable();
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
