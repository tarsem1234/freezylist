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
        Schema::table('counter_rent_offers', function (Blueprint $table) {
            $table->foreign('property_id', 'counter_rent_offers_ibfk_1')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'counter_rent_offers_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('rent_offer_id', 'counter_rent_offers_ibfk_3')->references('id')->on('rent_offers')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counter_rent_offers', function (Blueprint $table) {
            $table->dropForeign('counter_rent_offers_ibfk_1');
            $table->dropForeign('counter_rent_offers_ibfk_2');
            $table->dropForeign('counter_rent_offers_ibfk_3');
        });
    }
};
