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
        Schema::table('rent_offers', function (Blueprint $table) {
            $table->foreign('property_id', 'rent_offers_ibfk_1')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('owner_id', 'rent_offers_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('buyer_id', 'rent_offers_ibfk_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_offers', function (Blueprint $table) {
            $table->dropForeign('rent_offers_ibfk_1');
            $table->dropForeign('rent_offers_ibfk_2');
            $table->dropForeign('rent_offers_ibfk_3');
        });
    }
};
