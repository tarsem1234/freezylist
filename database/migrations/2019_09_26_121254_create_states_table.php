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
        Schema::create('states', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('postal', 250);
            $table->string('state', 250);
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 150)->nullable();
            $table->timestamps();
            $table->string('region', 250);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('states');
    }
};
