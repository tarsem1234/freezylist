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
        Schema::create('category_sessions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->index('category_id');
            $table->string('name', 191);
            $table->text('description', 65535);
            $table->integer('points');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('category_sessions');
    }
};
