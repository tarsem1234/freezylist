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
        Schema::table('category_sessions', function (Blueprint $table) {
            $table->foreign('category_id', 'category_sessions_ibfk_1')->references('id')->on('categories')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_sessions', function (Blueprint $table) {
            $table->dropForeign('category_sessions_ibfk_1');
        });
    }
};
