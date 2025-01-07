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
        Schema::table('property_architectures', function (Blueprint $table) {
            $table->foreign('property_id', 'property_architectures_ibfk_1')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('school_district_id', 'property_architectures_ibfk_2')->references('id')->on('school_districts')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('school_id', 'property_architectures_ibfk_3')->references('id')->on('schools')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_architectures', function (Blueprint $table) {
            $table->dropForeign('property_architectures_ibfk_1');
            $table->dropForeign('property_architectures_ibfk_2');
            $table->dropForeign('property_architectures_ibfk_3');
        });
    }
};
