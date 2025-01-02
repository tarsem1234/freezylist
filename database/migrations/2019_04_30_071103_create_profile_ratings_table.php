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
        Schema::create('profile_ratings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('from_user_id')->unsigned()->index('from_user_id');
            $table->integer('user_id')->unsigned()->index('to_user_id');
            $table->integer('rating');
            $table->text('review', 65535)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('profile_ratings');
    }
};
