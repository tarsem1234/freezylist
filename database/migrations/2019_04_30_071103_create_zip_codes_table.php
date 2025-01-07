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
        Schema::create('zip_codes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('city_id')->index('city_id');
            $table->string('zipcode', 50);
            $table->integer('type_id')->nullable()->index('type_id');
            $table->string('latitude', 100);
            $table->string('longitude', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('zip_codes');
    }
};
