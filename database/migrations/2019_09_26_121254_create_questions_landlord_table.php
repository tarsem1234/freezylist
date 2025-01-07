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
        Schema::create('questions_landlord', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('offer_id')->index('offer_id');
            $table->integer('security_deposit');
            $table->boolean('pets_welcome');
            $table->integer('non_refundable_pet_deposit')->nullable();
            $table->date('effective_start_date');
            $table->text('furnishings', 65535)->nullable();
            $table->text('utilities', 65535)->nullable();
            $table->boolean('require_cosigner')->default(2)->comment('1=>yes, 2=>no');
            $table->boolean('joint_cowners');
            $table->string('partners', 191)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('questions_landlord');
    }
};
