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
        Schema::create('rent_agreement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rent_offer_id')->index('rent_offer_id');
            $table->boolean('landlord_contract_tool_status')->nullable()->default(0)->comment('0=>uncomplete, 1=>complete');
            $table->boolean('tenant_contract_tool_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('rent_agreement');
    }
};
