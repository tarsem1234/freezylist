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
        Schema::table('forum_views', function (Blueprint $table) {
            $table->foreign('forum_id', 'forum_views_ibfk_1')->references('id')->on('forums')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_views', function (Blueprint $table) {
            $table->dropForeign('forum_views_ibfk_1');
        });
    }
};
