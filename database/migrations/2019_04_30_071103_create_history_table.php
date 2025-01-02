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
        Schema::create('history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned()->index('history_type_id_foreign');
            $table->integer('user_id')->unsigned()->index('history_user_id_foreign');
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('icon', 191)->nullable();
            $table->string('class', 191)->nullable();
            $table->string('text', 191);
            $table->text('assets', 65535)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('history');
    }
};
