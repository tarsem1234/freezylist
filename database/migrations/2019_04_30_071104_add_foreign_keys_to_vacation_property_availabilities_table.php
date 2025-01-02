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
        Schema::table('vacation_property_availabilities', function (Blueprint $table) {
            $table->foreign('vacation_property_id', 'vacation_property_availabilities_ibfk_1')->references('id')->on('vacation_properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacation_property_availabilities', function (Blueprint $table) {
            $table->dropForeign('vacation_property_availabilities_ibfk_1');
        });
    }
};
