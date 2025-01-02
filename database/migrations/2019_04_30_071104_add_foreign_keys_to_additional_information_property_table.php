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
        Schema::table('additional_information_property', function (Blueprint $table) {
            $table->foreign('additional_information_id', 'additional_information_property_ibfk_4')->references('id')->on('additional_information')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('property_id', 'additional_information_property_ibfk_5')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_information_property', function (Blueprint $table) {
            $table->dropForeign('additional_information_property_ibfk_4');
            $table->dropForeign('additional_information_property_ibfk_5');
        });
    }
};
