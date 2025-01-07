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
        Schema::create('questions_seller', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('offer_id')->index('offer_id');
            $table->boolean('earnest_money')->default(2)->comment('1=>Yes, 2=>No');
            $table->smallInteger('percentage_of_earnest_money')->nullable();
            $table->integer('amount_for_earnest_money')->nullable();
            $table->string('where_funds_deposited')->nullable();
            $table->string('legal_firm_address')->nullable();
            $table->text('household_items', 65535)->nullable();
            $table->boolean('real_estate_agent')->default(2);
            $table->string('real_estate_firm_name', 191)->nullable();
            $table->decimal('commission', 10, 0)->nullable();
            $table->string('agent_name')->nullable();
            $table->bigInteger('agent_phone')->nullable();
            $table->boolean('houseowners_associations')->default(2);
            $table->date('date_of_occupancy')->nullable();
            $table->string('require_time')->nullable();
            $table->date('property_vacant_date')->nullable();
            $table->boolean('joint_cowners')->nullable()->default(2)->comment('1 => \'Yes\', 2 => \'No');
            $table->string('partners', 191)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('questions_seller');
    }
};
