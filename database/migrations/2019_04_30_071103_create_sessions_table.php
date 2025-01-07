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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191)->unique();
            $table->integer('user_id')->unsigned()->nullable()->index('user_id');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent', 65535)->nullable();
            $table->text('payload', 65535);
            $table->integer('last_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('sessions');
    }
};
