<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('rent_signatures', function (Blueprint $table) {
            $table->integer('state_id')->nullable()->after('affix_status');
            $table->string('county', 191)->nullable()->after('state_id');
            $table->string('city', 191)->nullable()->after('county');
            $table->integer('zip_code')->nullable()->after('city');
            $table->bigInteger('phone_no')->nullable()->after('zip_code');
            $table->string('address', 191)->nullable()->after('phone_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('rent_signatures', function (Blueprint $table) {
            $table->dropColumn('county');
            $table->dropColumn('state_id');
            $table->dropColumn('zip_code');
            $table->dropColumn('city');
            $table->dropColumn('phone_no');
            $table->dropColumn('address');
        });
    }
};
