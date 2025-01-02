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
        Schema::create('property_contract_user_addresses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('sale_agreement_id')->nullable()->index('sale_agreement_id');
            $table->integer('rent_agreement_id')->nullable()->index('rent_agreement_id');
            $table->integer('state_id')->index('state_id');
            $table->string('city', 191);
            $table->string('county', 191);
            $table->integer('zip_code');
            $table->string('address', 191);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('property_contract_user_addresses');
    }
};
