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
        Schema::table('property_availabilities', function (Blueprint $table) {
            $table->foreign('property_id', 'property_availabilities_ibfk_2')->references('id')->on('properties')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_availabilities', function (Blueprint $table) {
            $table->dropForeign('property_availabilities_ibfk_2');
        });
    }
};
