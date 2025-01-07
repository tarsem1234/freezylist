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
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->foreign('user_id', 'forum_replies_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('forum_id', 'forum_replies_ibfk_2')->references('id')->on('forums')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->dropForeign('forum_replies_ibfk_1');
            $table->dropForeign('forum_replies_ibfk_2');
        });
    }
};
