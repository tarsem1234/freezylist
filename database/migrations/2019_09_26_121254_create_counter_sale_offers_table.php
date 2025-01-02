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
        Schema::create('counter_sale_offers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('property_id')->index('property_id');
            $table->integer('sale_offer_id')->index('sale_offer_id');
            $table->integer('counter_offer_price');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('status')->comment('1 => \'counter\', 2 => \'declined\',  3 => \'accepted\',');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('counter_sale_offers');
    }
};
