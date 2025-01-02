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
        Schema::table('zip_codes', function (Blueprint $table) {
            $table->foreign('city_id', 'zip_codes_ibfk_1')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('type_id', 'zip_codes_ibfk_2')->references('id')->on('types')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zip_codes', function (Blueprint $table) {
            $table->dropForeign('zip_codes_ibfk_1');
            $table->dropForeign('zip_codes_ibfk_2');
        });
    }
};
