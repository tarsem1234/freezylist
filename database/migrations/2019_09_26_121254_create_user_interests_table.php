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
        Schema::create('user_interests', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_profile_id')->unsigned()->index('user_profile_id');
            $table->boolean('interest_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('user_interests');
    }
};
