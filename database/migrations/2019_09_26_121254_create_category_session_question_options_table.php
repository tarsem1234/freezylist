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
        Schema::create('category_session_question_options', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_session_question_id')->index('category_session_question_id');
            $table->string('title', 191);
            $table->smallInteger('correct_answer')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('category_session_question_options');
    }
};
