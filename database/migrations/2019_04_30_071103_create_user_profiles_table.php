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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('full_name', 191);
            $table->string('address', 191)->nullable();
            $table->boolean('share_profile')->nullable();
            $table->boolean('loan_status')->nullable();
            $table->string('first_name', 191)->nullable();
            $table->string('middle_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('electronic_signature', 191)->nullable();
            $table->string('secure_code', 191)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('user_profiles');
    }
};
