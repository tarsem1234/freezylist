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
        Schema::create('vacation_properties', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('country_id')->index('country_id');
            $table->integer('state_id')->nullable()->index('state_id');
            $table->string('city', 191)->nullable()->index('city_id');
            $table->string('property_name', 191);
            $table->boolean('property_type');
            $table->integer('region_id')->index('region_id');
            $table->integer('subregion_id')->index('subregion_id');
            $table->integer('zip_code')->nullable();
            $table->string('address', 191)->nullable();
            $table->string('property_web_link', 191)->nullable();
            $table->boolean('point_based_timeshare');
            $table->integer('points')->nullable();
            $table->boolean('lock_out_unit');
            $table->boolean('variable');
            $table->boolean('exchange_timeshare');
            $table->text('locations', 65535)->nullable();
            $table->smallInteger('bathrooms');
            $table->smallInteger('bedrooms');
            $table->string('sleeps', 111);
            $table->integer('price');
            $table->boolean('rental_price_negotiable');
            $table->text('property_description', 65535);
            $table->boolean('is_available_for_sale');
            $table->smallInteger('ownership_type');
            $table->integer('sale_price')->nullable();
            $table->integer('lease_expire_year')->nullable();
            $table->integer('how_many_points')->nullable();
            $table->integer('annual_maintenance_fees')->nullable();
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('status')->comment('1 => \'Rented\', 2 => \'Available\', 3 => \'Sold\', 4 => \'In Progress\',');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('vacation_properties');
    }
};
