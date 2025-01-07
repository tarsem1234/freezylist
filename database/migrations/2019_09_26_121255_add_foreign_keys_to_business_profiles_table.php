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
        Schema::table('business_profiles', function (Blueprint $table) {
            $table->foreign('user_id', 'business_profiles_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('industry_id', 'business_profiles_ibfk_2')->references('id')->on('industries')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_profiles', function (Blueprint $table) {
            $table->dropForeign('business_profiles_ibfk_1');
            $table->dropForeign('business_profiles_ibfk_2');
        });
    }
};
