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
        Schema::create('rent_offers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('property_id')->index('property_id');
            $table->integer('owner_id')->unsigned()->index('owner_id');
            $table->integer('buyer_id')->unsigned()->index('buyer_id');
            $table->decimal('rent_price', 12);
            $table->string('name', 191);
            $table->string('email', 191);
            $table->bigInteger('phone');
            $table->date('date_of_occupancy');
            $table->boolean('month_count');
            $table->string('lease_term', 191);
            $table->boolean('pets_welcome');
            $table->string('pets_type', 191)->nullable();
            $table->string('pet_other_explanation', 191)->nullable();
            $table->boolean('agree');
            $table->string('epa', 191)->nullable();
            $table->boolean('opportunity')->nullable();
            $table->boolean('status')->comment('0 => pending, 1 => accepted, 2 => rejected_by_landlord, 3 => rejected_by_tenant,5=>User Deleted');
            $table->boolean('closed')->default(0)->comment('0=>not closed, 1=>closed');
            $table->boolean('landlord_signature')->nullable()->default(0)->comment('0=>false,1=>true');
            $table->boolean('tenant_signature')->nullable()->default(0)->comment('0=>false,1=>true');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('rent_offers');
    }
};
