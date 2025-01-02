<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('non_us_cities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('city_code', 191);
            $table->string('city', 191);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('non_us_cities');
    }
};
