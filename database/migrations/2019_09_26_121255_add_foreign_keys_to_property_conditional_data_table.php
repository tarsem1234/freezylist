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
        Schema::table('property_conditional_data', function (Blueprint $table) {
            $table->foreign('property_id', 'property_conditional_data_ibfk_1')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'property_conditional_data_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('state_id', 'property_conditional_data_ibfk_3')->references('id')->on('states')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('city_id', 'property_conditional_data_ibfk_4')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('county_id', 'property_conditional_data_ibfk_5')->references('id')->on('counties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('zip_code_id', 'property_conditional_data_ibfk_6')->references('id')->on('zip_codes')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_conditional_data', function (Blueprint $table) {
            $table->dropForeign('property_conditional_data_ibfk_1');
            $table->dropForeign('property_conditional_data_ibfk_2');
            $table->dropForeign('property_conditional_data_ibfk_3');
            $table->dropForeign('property_conditional_data_ibfk_4');
            $table->dropForeign('property_conditional_data_ibfk_5');
            $table->dropForeign('property_conditional_data_ibfk_6');
        });
    }
};
