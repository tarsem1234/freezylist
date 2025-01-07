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
        Schema::create('school_districts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('district', 250);
            $table->integer('state_id')->index('state_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('school_districts');
    }
};
