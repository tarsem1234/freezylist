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
        Schema::table('property_condition_disclaimer', function (Blueprint $table) {
            $table->foreign('user_id', 'property_condition_disclaimer_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('property_id', 'property_condition_disclaimer_ibfk_4')->references('id')->on('properties')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_condition_disclaimer', function (Blueprint $table) {
            $table->dropForeign('property_condition_disclaimer_ibfk_2');
            $table->dropForeign('property_condition_disclaimer_ibfk_4');
        });
    }
};
