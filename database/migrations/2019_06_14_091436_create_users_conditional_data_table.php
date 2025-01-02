<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_conditional_data', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sender_id')->unsigned()->index('sender_id');
            $table->integer('owner_id')->unsigned()->index('owner_id');
            $table->integer('offer_id')->index('offer_id');
            $table->string('buyer_signature', 191);
            $table->string('buyer_fullname', 255);
            $table->string('seller_signature', 191);
            $table->string('seller_fullname', 255);
            $table->timestamps();
            $table->softDeletes();
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::drop('users_conditional_data');
    }
};
