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
        Schema::table('document_lists', function (Blueprint $table) {
            $table->foreign('state_id', 'document_lists_ibfk_1')->references('id')->on('states')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_lists', function (Blueprint $table) {
            $table->dropForeign('document_lists_ibfk_1');
        });
    }
};
