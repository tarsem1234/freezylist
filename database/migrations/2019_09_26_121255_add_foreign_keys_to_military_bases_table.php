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
        Schema::table('military_bases', function (Blueprint $table) {
            $table->foreign('city_id', 'military_bases_ibfk_1')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('state_id', 'military_bases_ibfk_2')->references('id')->on('states')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('zipcode_id', 'military_bases_ibfk_3')->references('id')->on('zip_codes')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('military_bases', function (Blueprint $table) {
            $table->dropForeign('military_bases_ibfk_1');
            $table->dropForeign('military_bases_ibfk_2');
            $table->dropForeign('military_bases_ibfk_3');
        });
    }
};
