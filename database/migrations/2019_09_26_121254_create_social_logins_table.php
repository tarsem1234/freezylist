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
        Schema::create('social_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('social_logins_user_id_foreign');
            $table->string('provider', 32);
            $table->string('provider_id', 191);
            $table->string('token', 191)->nullable();
            $table->string('avatar', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('social_logins');
    }
};
