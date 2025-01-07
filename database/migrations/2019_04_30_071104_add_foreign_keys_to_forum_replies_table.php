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
            $table->foreign('forum_id')->references('id')->on('forums')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->dropForeign('forum_replies_forum_id_foreign');
            $table->dropForeign('forum_replies_user_id_foreign');
        });
    }
};
