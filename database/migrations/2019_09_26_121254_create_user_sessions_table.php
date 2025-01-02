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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('category_session_id')->index('category_session_id');
            $table->integer('current_question_id')->default(0);
            $table->boolean('status')->default(0)->comment('0=new, 1=completed');
            $table->integer('type')->default(1)->index('type')->comment('1=normal, 2=bonus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('user_sessions');
    }
};
