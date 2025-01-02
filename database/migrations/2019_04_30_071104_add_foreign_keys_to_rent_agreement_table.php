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
        Schema::table('rent_agreement', function (Blueprint $table) {
            $table->foreign('rent_offer_id', 'rent_agreement_ibfk_1')->references('id')->on('rent_offers')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rent_agreement', function (Blueprint $table) {
            $table->dropForeign('rent_agreement_ibfk_1');
        });
    }
};
