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
        Schema::create('questions_buyer', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('offer_id')->index('offer_id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->boolean('using_VA_or_FHA')->comment('1=>yes, 2=>no');
            $table->boolean('addendum')->comment('1=>yes, 2=>no');
            $table->date('close_date')->nullable();
            $table->boolean('set_specific_date')->comment('1=>yes, 2=>no');
            $table->date('date_of_expiry')->nullable();
            $table->boolean('joint_cowners')->default(2)->comment('1=>yes, 2=>no');
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
        Schema::drop('questions_buyer');
    }
};
