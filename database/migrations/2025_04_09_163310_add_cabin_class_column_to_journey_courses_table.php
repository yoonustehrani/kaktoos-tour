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
        Schema::table('journey_courses', function (Blueprint $table) {
            $table->smallInteger('cabin_class')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journey_courses', function (Blueprint $table) {
            $table->dropColumn([
                'cabin_class'
            ]);
        });
    }
};
