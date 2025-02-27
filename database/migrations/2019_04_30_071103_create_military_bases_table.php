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
        Schema::create('military_bases', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('base');
            $table->integer('city_id')->index('city_id');
            $table->integer('state_id')->index('state_id');
            $table->string('branch');
            $table->string('sub_branch');
            $table->string('map_value', 250);
            $table->integer('zipcode_id')->index('zipcode_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('military_bases');
    }
};
