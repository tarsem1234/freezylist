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
        Schema::create('schools', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('year');
            $table->bigInteger('nces_id');
            $table->integer('leaid');
            $table->integer('schno');
            $table->integer('stid');
            $table->integer('seasch');
            $table->integer('school_district')->index('school_district');
            $table->string('name', 250);
            $table->string('phone', 50);
            $table->string('address', 250);
            $table->integer('city')->index('city');
            $table->integer('state')->index('state');
            $table->string('county', 191);
            $table->integer('zipcode');
            $table->string('latitude', 250);
            $table->string('longitude', 250);
            $table->integer('county_number');
            $table->string('level', 250);
            $table->integer('teacher');
            $table->integer('student');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('schools');
    }
};
