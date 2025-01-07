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
        Schema::table('property_images', function (Blueprint $table) {
            $table->foreign('property_id', 'property_images_ibfk_2')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropForeign('property_images_ibfk_2');
        });
    }
};
