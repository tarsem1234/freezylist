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
        Schema::create('questions_seller_post_closing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('offer_id')->index('offer_id');
            $table->integer('current_mortgage')->comment('1=>Yes, 2=>No');
            $table->boolean('additional_charge')->default(2);
            $table->boolean('refundable_security')->default(2);
            $table->boolean('unearned_rents')->default(2);
            $table->boolean('utilities')->default(2);
            $table->boolean('renter_policy')->default(2);
            $table->boolean('liability_insurance')->default(2);
            $table->text('additional_provisions', 65535)->nullable();
            $table->boolean('show_post_closing')->default(2)->comment('1=>On Yes Button, 2=>On No Button');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('questions_seller_post_closing');
    }
};
