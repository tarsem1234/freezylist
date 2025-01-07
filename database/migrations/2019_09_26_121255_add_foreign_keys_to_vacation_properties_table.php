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
            $table->foreign('user_id', 'vacation_properties_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('country_id', 'vacation_properties_ibfk_2')->references('id')->on('countries')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('state_id', 'vacation_properties_ibfk_3')->references('id')->on('states')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('region_id', 'vacation_properties_ibfk_4')->references('id')->on('regions')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('subregion_id', 'vacation_properties_ibfk_5')->references('id')->on('sub_regions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacation_properties', function (Blueprint $table) {
            $table->dropForeign('vacation_properties_ibfk_1');
            $table->dropForeign('vacation_properties_ibfk_2');
            $table->dropForeign('vacation_properties_ibfk_3');
            $table->dropForeign('vacation_properties_ibfk_4');
            $table->dropForeign('vacation_properties_ibfk_5');
        });
    }
};
