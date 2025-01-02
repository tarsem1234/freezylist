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
        Schema::create('networks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('from_user_id')->unsigned()->index('from_user_id');
            $table->integer('to_user_id')->unsigned()->index('to_user_id');
            $table->integer('status')->comment('1=>approved, 2=>not approved');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('networks');
    }
};
