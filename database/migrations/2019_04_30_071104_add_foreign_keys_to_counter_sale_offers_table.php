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
        Schema::table('counter_sale_offers', function (Blueprint $table) {
            $table->foreign('property_id', 'counter_sale_offers_ibfk_1')->references('id')->on('properties')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('sale_offer_id', 'counter_sale_offers_ibfk_5')->references('id')->on('sale_offers')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'counter_sale_offers_ibfk_6')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counter_sale_offers', function (Blueprint $table) {
            $table->dropForeign('counter_sale_offers_ibfk_1');
            $table->dropForeign('counter_sale_offers_ibfk_5');
            $table->dropForeign('counter_sale_offers_ibfk_6');
        });
    }
};
