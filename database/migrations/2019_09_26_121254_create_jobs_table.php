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
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('queue', 191);
            $table->text('payload', 65535);
            $table->boolean('attempts');
            $table->integer('reserved_at')->unsigned()->nullable();
            $table->integer('available_at')->unsigned();
            $table->integer('created_at')->unsigned();
            $table->index(['queue', 'reserved_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('jobs');
    }
};
