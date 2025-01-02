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
            $table->foreign('property_id', 'property_availabilities_ibfk_1')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'property_availabilities_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_availabilities', function (Blueprint $table) {
            $table->dropForeign('property_availabilities_ibfk_1');
            $table->dropForeign('property_availabilities_ibfk_2');
        });
    }
};
