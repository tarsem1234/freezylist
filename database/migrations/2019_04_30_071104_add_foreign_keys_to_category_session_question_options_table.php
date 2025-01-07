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
        Schema::table('category_session_question_options', function (Blueprint $table) {
            $table->foreign('category_session_question_id', 'category_session_question_options_ibfk_2')->references('id')->on('category_session_questions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_session_question_options', function (Blueprint $table) {
            $table->dropForeign('category_session_question_options_ibfk_2');
        });
    }
};
