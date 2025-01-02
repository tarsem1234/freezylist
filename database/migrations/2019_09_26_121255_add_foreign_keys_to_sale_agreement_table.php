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
        Schema::table('sale_agreement', function (Blueprint $table) {
            $table->foreign('offer_id', 'sale_agreement_ibfk_1')->references('id')->on('sale_offers')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_agreement', function (Blueprint $table) {
            $table->dropForeign('sale_agreement_ibfk_1');
        });
    }
};
