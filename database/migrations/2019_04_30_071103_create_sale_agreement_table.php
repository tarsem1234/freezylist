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
        Schema::create('sale_agreement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('offer_id')->index('offer_id');
            $table->string('not_included_insale', 191)->nullable();
            $table->string('leased_items', 191)->nullable();
            $table->string('addenda', 191)->nullable();
            $table->string('other', 191)->nullable();
            $table->date('offer_expiration')->nullable();
            $table->boolean('seller_contract_tool_status')->nullable()->default(0)->comment('Seller prepared contract documents');
            $table->boolean('buyer_contract_tool_status')->nullable()->default(0)->comment('buyer read contract documents');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('sale_agreement');
    }
};
