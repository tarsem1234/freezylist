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
        Schema::create('xmlfeed_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 191);
            $table->string('password', 191);
            $table->boolean('status')->default(1)->comment('0=Inactive, 1=Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('xmlfeed_users');
    }
};
