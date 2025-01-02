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
        Schema::table('user_interests', function (Blueprint $table) {
            $table->foreign('user_profile_id', 'user_interests_ibfk_2')->references('id')->on('user_profiles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_interests', function (Blueprint $table) {
            $table->dropForeign('user_interests_ibfk_2');
        });
    }
};
