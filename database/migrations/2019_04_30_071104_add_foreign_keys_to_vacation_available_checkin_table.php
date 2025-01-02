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
        Schema::table('vacation_available_checkin', function (Blueprint $table) {
            $table->foreign('vacation_property_id', 'vacation_available_checkin_ibfk_2')->references('id')->on('vacation_properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacation_available_checkin', function (Blueprint $table) {
            $table->dropForeign('vacation_available_checkin_ibfk_2');
        });
    }
};
