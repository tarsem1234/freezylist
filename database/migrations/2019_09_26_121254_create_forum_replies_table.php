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
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('forum_replies_user_id_foreign');
            $table->integer('forum_id')->unsigned()->index('forum_replies_forum_id_foreign');
            $table->text('reply', 65535);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('forum_replies');
    }
};
