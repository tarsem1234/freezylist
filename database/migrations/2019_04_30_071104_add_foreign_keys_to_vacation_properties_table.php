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
        Schema::table('vacation_properties', function (Blueprint $table) {
            $table->foreign('region_id', 'vacation_properties_ibfk_10')->references('id')->on('regions')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('country_id', 'vacation_properties_ibfk_11')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'vacation_properties_ibfk_7')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('state_id', 'vacation_properties_ibfk_8')->references('id')->on('states')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('subregion_id', 'vacation_properties_ibfk_9')->references('id')->on('sub_regions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacation_properties', function (Blueprint $table) {
            $table->dropForeign('vacation_properties_ibfk_10');
            $table->dropForeign('vacation_properties_ibfk_11');
            $table->dropForeign('vacation_properties_ibfk_7');
            $table->dropForeign('vacation_properties_ibfk_8');
            $table->dropForeign('vacation_properties_ibfk_9');
        });
    }
};
