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
        Schema::table('signers', function (Blueprint $table) {
            $table->foreign('from_user_id', 'signers_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('invited_user_id', 'signers_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signers', function (Blueprint $table) {
            $table->dropForeign('signers_ibfk_1');
            $table->dropForeign('signers_ibfk_2');
        });
    }
};
