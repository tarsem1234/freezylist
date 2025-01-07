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
        Schema::table('property_contract_user_addresses', function (Blueprint $table) {
            $table->foreign('user_id', 'property_contract_user_addresses_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('sale_agreement_id', 'property_contract_user_addresses_ibfk_3')->references('id')->on('sale_agreement')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('rent_agreement_id', 'property_contract_user_addresses_ibfk_4')->references('id')->on('rent_agreement')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('state_id', 'property_contract_user_addresses_ibfk_5')->references('id')->on('states')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_contract_user_addresses', function (Blueprint $table) {
            $table->dropForeign('property_contract_user_addresses_ibfk_1');
            $table->dropForeign('property_contract_user_addresses_ibfk_3');
            $table->dropForeign('property_contract_user_addresses_ibfk_4');
            $table->dropForeign('property_contract_user_addresses_ibfk_5');
        });
    }
};
