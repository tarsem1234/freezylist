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
        Schema::create('rent_signatures', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('offer_id')->index('offer_id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->smallInteger('signature_type')->nullable()->comment('1=>lead based, 2=>property disclaimer, 3=>rent agreement');
            $table->string('signature', 191);
            $table->string('fullname');
            $table->smallInteger('type')->comment('1 => \'buyer\', 2 => \'seller\', 3 => \'cobuyer\', 4 => \'coseller\'');
            $table->smallInteger('affix_status')->comment('0 => \'signature not done\', 1 => \'signature done\'');
            $table->integer('state_id')->nullable();
            $table->string('county', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->integer('zip_code')->nullable();
            $table->bigInteger('phone_no')->nullable();
            $table->string('address', 191)->nullable();
            $table->string('ip', 191);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('rent_signatures');
    }
};
