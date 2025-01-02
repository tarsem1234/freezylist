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
        Schema::create('property_architectures', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('property_id')->index('property_id');
            $table->integer('school_district_id')->nullable()->index('school_district_id');
            $table->string('school_id', 191)->nullable()->index('school_id');
            $table->smallInteger('home_type');
            $table->integer('beds');
            $table->integer('baths');
            $table->integer('plot_size');
            $table->integer('home_size')->nullable();
            $table->text('describe_your_home', 65535);
            $table->string('year_built', 191);
            $table->string('year_updated', 191)->nullable();
            $table->string('HOA_dues', 191)->nullable();
            $table->integer('total_rooms')->nullable();
            $table->string('stories', 191)->nullable();
            $table->string('garage_capacity', 191)->nullable();
            $table->text('additional_features', 65535)->nullable();
            $table->smallInteger('basement')->nullable()->default(4);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('property_architectures');
    }
};
