<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('questions_seller_post_closing', function ($table) {
            $table->tinyInteger('show_post_closing')->default(2)->comment('1=>On Yes Button, 2=>On No Button')->after('additional_provisions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('questions_seller_post_closing', function ($table) {
            $table->dropColumn('show_post_closing')->after('additional_provisions');
        });
    }
};
