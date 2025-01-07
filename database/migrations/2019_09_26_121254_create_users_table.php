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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('email', 191)->unique();
            $table->string('password', 191)->nullable();
            $table->integer('state_id')->nullable()->index('state_id');
            $table->string('county', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('zip_code', 6)->nullable();
            $table->bigInteger('phone_no')->nullable();
            $table->boolean('status')->default(1);
            $table->string('latitude', 191)->nullable();
            $table->string('longitude', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('confirmation_code', 191)->nullable();
            $table->boolean('confirmed')->default(0);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('users');
    }
};
