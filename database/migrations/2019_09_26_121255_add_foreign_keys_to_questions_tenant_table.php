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
        Schema::table('questions_tenant', function (Blueprint $table) {
            $table->foreign('user_id', 'questions_tenant_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('rent_offer_id', 'questions_tenant_ibfk_2')->references('id')->on('rent_offers')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions_tenant', function (Blueprint $table) {
            $table->dropForeign('questions_tenant_ibfk_1');
            $table->dropForeign('questions_tenant_ibfk_2');
        });
    }
};