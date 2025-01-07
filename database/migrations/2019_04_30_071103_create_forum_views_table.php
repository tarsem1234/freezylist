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
        Schema::create('forum_views', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('forum_id')->unsigned()->index('forum_id');
            $table->string('ip', 191);
            $table->integer('views');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('forum_views');
    }
};
