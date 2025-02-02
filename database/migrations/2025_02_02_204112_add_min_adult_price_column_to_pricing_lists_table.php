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
        Schema::table('pricing_lists', function (Blueprint $table) {
            $table->bigInteger('min_adult_price')->unsigned()->nullable()->default(null)->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_lists', function (Blueprint $table) {
            $table->dropColumn(['min_adult_price']);
        });
    }
};
