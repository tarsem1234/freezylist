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
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->foreign('user_id', 'user_sessions_ibfk_4')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('type', 'user_sessions_ibfk_6')->references('id')->on('types')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('category_session_id', 'user_sessions_ibfk_7')->references('id')->on('category_sessions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->dropForeign('user_sessions_ibfk_4');
            $table->dropForeign('user_sessions_ibfk_6');
            $table->dropForeign('user_sessions_ibfk_7');
        });
    }
};
