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
        Schema::table('subscribe_services', function (Blueprint $table) {
            $table->foreign('user_id', 'subscribe_services_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscribe_services', function (Blueprint $table) {
            $table->dropForeign('subscribe_services_ibfk_2');
        });
    }
};
