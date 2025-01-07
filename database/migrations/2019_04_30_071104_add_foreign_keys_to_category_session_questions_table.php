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
        Schema::table('category_session_questions', function (Blueprint $table) {
            $table->foreign('category_session_id', 'category_session_questions_ibfk_1')->references('id')->on('category_sessions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_session_questions', function (Blueprint $table) {
            $table->dropForeign('category_session_questions_ibfk_1');
        });
    }
};
